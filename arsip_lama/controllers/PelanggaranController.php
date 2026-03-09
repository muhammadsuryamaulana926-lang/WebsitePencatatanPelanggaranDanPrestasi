<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggaran = Pelanggaran::with(['siswa', 'guruPencatat', 'jenisPelanggaran'])->get();
        $siswa = Siswa::all();
        $guru = Guru::where('status', 'aktif')->get();
        $jenisPelanggaran = JenisPelanggaran::all();
        $tahunAjaran = TahunAjaran::all();
        return view('page_admin.data-pelanggaran', compact('pelanggaran', 'siswa', 'guru', 'jenisPelanggaran', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'poin' => 'required|numeric'
        ]);

        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'guru_pencatat' => $request->guru_pencatat,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan
        ]);

        // Otomatis tambahkan ke tabel verifikasi_data
        \App\Models\VerifikasiData::create([
            'tabel_terkait' => 'pelanggaran',
            'id_terkait' => $pelanggaran->id,
            'guru_verifikator' => $request->guru_pencatat ?? 1,
            'status' => 'menunggu'
        ]);
        
        // Otomatis buat sanksi berdasarkan total poin
        $this->createAutoSanksi($pelanggaran);
        
        return redirect('/admin/data-pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan dan sanksi otomatis dibuat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'poin' => 'required|numeric'
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update([
            'siswa_id' => $request->siswa_id,
            'guru_pencatat' => $request->guru_pencatat,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect('/admin/data-pelanggaran')->with('success', 'Data pelanggaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();
        
        return redirect('/admin/data-pelanggaran')->with('success', 'Data pelanggaran berhasil dihapus');
    }
    
    private function createAutoSanksi($pelanggaran)
    {
        // Hitung total poin siswa (hanya yang sanksinya belum selesai)
        $totalPoin = $this->getTotalPoinSiswa($pelanggaran->siswa_id);
        $jenisSanksi = $this->getJenisSanksiByPoin($totalPoin);
        
        // Cek apakah ada sanksi aktif (belum selesai) untuk siswa ini
        $sanksiAktif = \App\Models\Sanksi::whereHas('pelanggaran', function($query) use ($pelanggaran) {
            $query->where('siswa_id', $pelanggaran->siswa_id);
        })
        ->whereIn('status', ['belum_dilaksanakan', 'direncanakan', 'berjalan'])
        ->with('pelaksanaanSanksi')
        ->get();
        
        // Batalkan sanksi lama jika ada dan sanksi baru lebih berat
        foreach ($sanksiAktif as $sanksiLama) {
            if ($this->isSanksiLebihBerat($jenisSanksi, $sanksiLama->jenis_sanksi)) {
                // Update status sanksi lama menjadi dibatalkan
                $sanksiLama->update([
                    'status' => 'dibatalkan',
                    'deskripsi' => $sanksiLama->deskripsi . "\n\n[DIBATALKAN] Digantikan dengan sanksi lebih berat: {$jenisSanksi}"
                ]);
                
                // Update pelaksanaan sanksi lama jika ada
                $sanksiLama->pelaksanaanSanksi()->update([
                    'status' => 'dibatalkan',
                    'catatan' => 'Sanksi dibatalkan karena ada pelanggaran baru dengan sanksi lebih berat'
                ]);
            }
        }
        
        // Buat sanksi baru
        $sanksiPelanggaran = $this->getDaftarPelanggaranSiswa($pelanggaran->siswa_id);
        $sanksi = \App\Models\Sanksi::create([
            'pelanggaran_id' => $pelanggaran->id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $this->getDeskripsiSanksi($jenisSanksi) . "\n\nPelanggaran terkait: " . $sanksiPelanggaran,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => $this->getTanggalSelesai($jenisSanksi),
            'status' => 'belum_dilaksanakan'
        ]);
        
        // Buat pelaksanaan sanksi otomatis
        \App\Models\PelaksanaanSanksi::create([
            'sanksi_id' => $sanksi->id,
            'siswa_id' => $pelanggaran->siswa_id,
            'tanggal_pelaksanaan' => now(),
            'status' => 'belum_dikerjakan'
        ]);
    }
    
    private function getTotalPoinSiswa($siswaId)
    {
        return \Illuminate\Support\Facades\DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->leftJoin('sanksi', 'pelanggaran.id', '=', 'sanksi.pelanggaran_id')
            ->leftJoin('pelaksanaan_sanksi', 'sanksi.id', '=', 'pelaksanaan_sanksi.sanksi_id')
            ->where('pelanggaran.siswa_id', $siswaId)
            ->where(function($query) {
                $query->whereNull('sanksi.id')
                      ->orWhere('pelaksanaan_sanksi.status', '!=', 'selesai')
                      ->orWhereNull('pelaksanaan_sanksi.status');
            })
            ->sum('jenis_pelanggaran.poin');
    }
    
    private function getJenisSanksiByPoin($totalPoin)
    {
        if ($totalPoin >= 90) {
            return 'Dikembalikan Kepada Orang Tua (Keluar)';
        } elseif ($totalPoin >= 41) {
            return 'Diserahkan Kepada Orang Tua 1 Bulan';
        } elseif ($totalPoin >= 36) {
            return 'Diserahkan Kepada Orang Tua 2 Minggu';
        } elseif ($totalPoin >= 26) {
            return 'Diskors Selama 7 Hari';
        } elseif ($totalPoin >= 21) {
            return 'Diskors Selama 3 Hari';
        } elseif ($totalPoin >= 16) {
            return 'Perjanjian Siswa Diatas Materai';
        } elseif ($totalPoin >= 11) {
            return 'Peringatan Tertulis';
        } elseif ($totalPoin >= 6) {
            return 'Peringatan Lisan';
        } else {
            return 'Dicatat dan Konseling';
        }
    }
    
    private function getDeskripsiSanksi($jenisSanksi)
    {
        $deskripsi = [
            'Dicatat dan Konseling' => 'Pelanggaran ringan dicatat dan diberikan konseling',
            'Peringatan Lisan' => 'Diberikan peringatan lisan oleh guru/wali kelas',
            'Peringatan Tertulis' => 'Surat peringatan tertulis dengan perjanjian',
            'Perjanjian Siswa Diatas Materai' => 'Siswa membuat perjanjian tertulis diatas materai',
            'Diskors Selama 3 Hari' => 'Siswa tidak diperbolehkan masuk sekolah selama 3 hari',
            'Diskors Selama 7 Hari' => 'Siswa tidak diperbolehkan masuk sekolah selama 7 hari',
            'Diserahkan Kepada Orang Tua 2 Minggu' => 'Siswa diserahkan kepada orang tua untuk pembinaan 2 minggu',
            'Diserahkan Kepada Orang Tua 1 Bulan' => 'Siswa diserahkan kepada orang tua untuk pembinaan 1 bulan',
            'Dikembalikan Kepada Orang Tua (Keluar)' => 'Siswa dikeluarkan dari sekolah'
        ];
        
        return $deskripsi[$jenisSanksi] ?? 'Sanksi sesuai pelanggaran';
    }
    
    private function getTanggalSelesai($jenisSanksi)
    {
        $hari = [
            'Diskors Selama 3 Hari' => 3,
            'Diskors Selama 7 Hari' => 7,
            'Diserahkan Kepada Orang Tua 2 Minggu' => 14,
            'Diserahkan Kepada Orang Tua 1 Bulan' => 30
        ];
        
        $tambahHari = $hari[$jenisSanksi] ?? 7;
        return now()->addDays($tambahHari);
    }
    
    private function isSanksiLebihBerat($sanksiBaruJenis, $sanksiLamaJenis)
    {
        $tingkatSanksi = [
            'Dicatat dan Konseling' => 1,
            'Peringatan Lisan' => 2,
            'Peringatan Tertulis' => 3,
            'Perjanjian Siswa Diatas Materai' => 4,
            'Diskors Selama 3 Hari' => 5,
            'Diskors Selama 7 Hari' => 6,
            'Diserahkan Kepada Orang Tua 2 Minggu' => 7,
            'Diserahkan Kepada Orang Tua 1 Bulan' => 8,
            'Dikembalikan Kepada Orang Tua (Keluar)' => 9
        ];
        
        $tingkatBaru = $tingkatSanksi[$sanksiBaruJenis] ?? 0;
        $tingkatLama = $tingkatSanksi[$sanksiLamaJenis] ?? 0;
        
        return $tingkatBaru > $tingkatLama;
    }
    
    private function getDaftarPelanggaranSiswa($siswaId)
    {
        $pelanggaran = \App\Models\Pelanggaran::with('jenisPelanggaran')
            ->where('siswa_id', $siswaId)
            ->whereDoesntHave('sanksi', function($query) {
                $query->where('status', 'selesai');
            })
            ->get();
            
        return $pelanggaran->map(function($p) {
            return $p->jenisPelanggaran->nama_pelanggaran ?? 'Pelanggaran tidak ditemukan';
        })->implode(', ');
    }
}