<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\JenisPelanggaran;
use App\Models\Siswa;
use App\Models\Prestasi;
use App\Models\VerifikasiData;
use Illuminate\Support\Facades\Auth;
use App\Exports\PelanggaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruPageController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru_id;
        
        // Statistik pribadi
        $pelanggaranBulanIni = Pelanggaran::where('guru_pencatat', $guruId)
            ->whereMonth('created_at', now()->month)
            ->count();
            
        $siswaBinaan = Siswa::count(); // Atau sesuai logika siswa binaan
        
        // Daftar pelanggaran terakhir
        $pelanggaranTerakhir = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->where('guru_pencatat', $guruId)
            ->latest()
            ->take(5)
            ->get();
            
        return view('page_guru.guru', compact('pelanggaranBulanIni', 'siswaBinaan', 'pelanggaranTerakhir'));
    }

    public function inputPelanggaran()
    {
        $siswa = Siswa::with('kelas')->get();
        $jenisPelanggaran = JenisPelanggaran::all();
        $guru = \App\Models\Guru::all();
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->latest()
            ->get();
        
        return view('page_guru.input-pelanggaran', compact('siswa', 'jenisPelanggaran', 'guru', 'pelanggaran'));
    }

    public function storePelanggaran(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'guru_pencatat' => 'required|exists:guru,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string'
        ]);

        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', true)->first();
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan
        ]);

        VerifikasiData::create([
            'tabel_terkait' => 'pelanggaran',
            'id_terkait' => $pelanggaran->id,
            'guru_verifikator' => $request->guru_pencatat,
            'status' => 'menunggu'
        ]);
        
        // Otomatis buat sanksi berdasarkan total poin
        $this->createAutoSanksi($pelanggaran);
        
        return redirect('/guru/input-pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan dan sanksi otomatis dibuat');
    }

    public function viewDataSendiri()
    {
        // Ambil semua pelanggaran dengan eager loading yang eksplisit
        $pelanggaran = Pelanggaran::with([
            'siswa' => function($query) {
                $query->with('kelas');
            },
            'jenisPelanggaran',
            'guruPencatat'
        ])
        ->latest()
        ->get();
        
        // Ambil daftar guru untuk filter
        $guru = \App\Models\Guru::all();
        
        return view('page_guru.view-data-sendiri', compact('pelanggaran', 'guru'));
    }







    public function exportLaporan($guruId = null)
    {
        if ($guruId) {
            $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])
                ->where('guru_pencatat', $guruId)
                ->get();
            $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi'])
                ->where('guru_pencatat', $guruId)
                ->get();
            $guru = \App\Models\Guru::find($guruId);
            
            return view('page_guru.export-laporan-single', compact('pelanggaran', 'prestasi', 'guru'));
        } else {
            $dataByGuru = \App\Models\Guru::with([
                'pelanggaranPencatat.siswa.kelas',
                'pelanggaranPencatat.jenisPelanggaran',
                'prestasiPencatat.siswa.kelas',
                'prestasiPencatat.jenisPrestasi'
            ])->get()->filter(function($guru) {
                return $guru->pelanggaranPencatat->count() > 0 || $guru->prestasiPencatat->count() > 0;
            });
            
            return view('page_guru.export-laporan', compact('dataByGuru'));
        }
    }

    public function exportExcel($guruId = null)
    {
        return Excel::download(new PelanggaranExport($guruId), 'laporan-pelanggaran.xlsx');
    }

    public function exportPdf($guruId = null)
    {
        if ($guruId) {
            $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])
                ->where('guru_pencatat', $guruId)
                ->get();
            $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi'])
                ->where('guru_pencatat', $guruId)
                ->get();
            $guru = \App\Models\Guru::find($guruId);
        } else {
            $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])->get();
            $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi'])->get();
            $guru = null;
        }

        $pdf = Pdf::loadView('exports.pelanggaran-pdf', compact('pelanggaran', 'prestasi', 'guru'));
        return $pdf->download('laporan-pelanggaran.pdf');
    }

    public function deletePelanggaran($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        
        // Simpan ke riwayat sebelum dihapus
        \App\Models\RiwayatPelanggaran::create([
            'siswa_id' => $pelanggaran->siswa_id,
            'jenis_pelanggaran_id' => $pelanggaran->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $pelanggaran->tahun_ajaran_id ?? 1,
            'guru_pencatat' => $pelanggaran->guru_pencatat,
            'poin' => $pelanggaran->poin,
            'keterangan' => $pelanggaran->keterangan,
            'tanggal_pelanggaran' => $pelanggaran->created_at,
            'tanggal_dihapus' => now(),
            'alasan_hapus' => 'Dihapus oleh guru'
        ]);
        
        $pelanggaran->delete();
        
        return redirect('/guru/input-pelanggaran')->with('success', 'Data pelanggaran berhasil dihapus dan disimpan ke riwayat');
    }

    public function riwayatPelanggaran()
    {
        $riwayat = \App\Models\RiwayatPelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])
            ->orderBy('tanggal_dihapus', 'desc')
            ->get();
        return view('page_guru.riwayat-pelanggaran', compact('riwayat'));
    }
    
    private function createAutoSanksi($pelanggaran)
    {
        // Hitung total poin siswa (hanya yang sanksinya belum selesai)
        $totalPoin = $this->getTotalPoinSiswaGuru($pelanggaran->siswa_id);
        $jenisSanksi = $this->getJenisSanksiByPoinGuru($totalPoin);
        
        // Cek apakah ada sanksi aktif (belum selesai) untuk siswa ini
        $sanksiAktif = \App\Models\Sanksi::whereHas('pelanggaran', function($query) use ($pelanggaran) {
            $query->where('siswa_id', $pelanggaran->siswa_id);
        })
        ->whereIn('status', ['belum_dilaksanakan', 'direncanakan', 'berjalan'])
        ->with('pelaksanaanSanksi')
        ->get();
        
        // Batalkan sanksi lama jika ada dan sanksi baru lebih berat
        foreach ($sanksiAktif as $sanksiLama) {
            if ($this->isSanksiLebihBeratGuru($jenisSanksi, $sanksiLama->jenis_sanksi)) {
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
        $sanksiPelanggaran = $this->getDaftarPelanggaranSiswaGuru($pelanggaran->siswa_id);
        $sanksi = \App\Models\Sanksi::create([
            'pelanggaran_id' => $pelanggaran->id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $this->getDeskripsiSanksiGuru($jenisSanksi) . "\n\nPelanggaran terkait: " . $sanksiPelanggaran,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => $this->getTanggalSelesaiGuru($jenisSanksi),
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
    
    private function getTotalPoinSiswaGuru($siswaId)
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
    
    private function getJenisSanksiByPoinGuru($totalPoin)
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
    
    private function getDeskripsiSanksiGuru($jenisSanksi)
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
    
    private function getTanggalSelesaiGuru($jenisSanksi)
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
    
    private function isSanksiLebihBeratGuru($sanksiBaruJenis, $sanksiLamaJenis)
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
    
    private function getDaftarPelanggaranSiswaGuru($siswaId)
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