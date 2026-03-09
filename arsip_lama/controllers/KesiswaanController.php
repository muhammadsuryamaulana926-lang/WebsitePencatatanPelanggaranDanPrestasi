<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\JenisPelanggaran;
use App\Models\JenisPrestasi;
use App\Models\Siswa;
use App\Models\VerifikasiData;
use App\Models\MonitoringPelanggaran;
use App\Models\TahunAjaran;
use App\Models\RiwayatPelanggaran;

class KesiswaanController extends Controller
{
    public function index()
    {
        return view('page_kesiswaan.kesiswaan');
    }

    public function inputPelanggaran()
    {
        $siswa = Siswa::with('kelas')->get();
        $jenisPelanggaran = JenisPelanggaran::all();
        $guru = \App\Models\Guru::all();
        $tahunAjaran = TahunAjaran::all();
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])->get();
        return view('page_kesiswaan.input-pelanggaran', compact('siswa', 'jenisPelanggaran', 'guru', 'tahunAjaran', 'pelanggaran'));
    }

    public function storePelanggaran(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_pencatat' => 'nullable|exists:guru,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string'
        ]);

        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan
        ]);

        // Otomatis tambahkan ke tabel verifikasi_data
        VerifikasiData::create([
            'tabel_terkait' => 'pelanggaran',
            'id_terkait' => $pelanggaran->id,
            'guru_verifikator' => $request->guru_pencatat ?? 1, // Default guru ID 1 jika tidak ada
            'status' => 'menunggu'
        ]);
        
        return redirect('/kesiswaan/input-pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan');
    }

    public function inputPrestasi()
    {
        $siswa = Siswa::with('kelas')->get();
        $jenisPrestasi = JenisPrestasi::all();
        $guru = \App\Models\Guru::all();
        $tahunAjaran = TahunAjaran::all();
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru'])->get();
        return view('page_kesiswaan.input-prestasi', compact('siswa', 'jenisPrestasi', 'guru', 'tahunAjaran', 'prestasi'));
    }

    public function storePrestasi(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_pencatat' => 'nullable|exists:guru,id',
            'poin' => 'required|integer',
            'keterangan' => 'nullable|string'
        ]);

        $prestasi = Prestasi::create([
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'poin' => $request->poin,
            'keterangan' => $request->keterangan,
            'status_verifikasi' => 'disetujui'
        ]);
        
        return redirect('/kesiswaan/input-prestasi')->with('success', 'Data prestasi berhasil ditambahkan');
    }

    public function verifikasiData()
    {
        $verifikasi = VerifikasiData::with('guru')->latest()->get();
        return view('page_kesiswaan.verifikasi-data', compact('verifikasi'));
    }

    public function monitoringAll()
    {
        // Ambil semua siswa dengan total poin pelanggaran dan data pelaksanaan sanksi
        $monitoring = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'pelanggaran.sanksi.pelaksanaanSanksi'])
            ->get()
            ->map(function($siswa) {
                $totalPoin = $siswa->pelanggaran->sum('poin');
                $status = 'normal';
                
                if ($totalPoin >= 100) {
                    $status = 'critical';
                } elseif ($totalPoin >= 50) {
                    $status = 'warning';
                }
                
                return (object) [
                    'siswa' => $siswa,
                    'total_poin' => $totalPoin,
                    'status' => $status,
                    'updated_at' => $siswa->updated_at
                ];
            })
            // Tampilkan semua siswa
            ->sortByDesc('total_poin');
            
        return view('page_kesiswaan.monitoring-all', compact('monitoring'));
    }

    public function viewDataSendiri()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get();
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi'])->get();
        return view('page_kesiswaan.view-data-sendiri', compact('pelanggaran', 'prestasi'));
    }

    public function viewDataAnak()
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi.jenisPrestasi'])->get();
        return view('page_kesiswaan.view-data-anak', compact('siswa'));
    }

    public function exportLaporan()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get();
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi'])->get();
        return view('page_kesiswaan.export-laporan', compact('pelanggaran', 'prestasi'));
    }

    public function updateVerifikasiData(Request $request, $id)
    {
        $verifikasiData = VerifikasiData::findOrFail($id);
        $verifikasiData->update(['status' => $request->status]);
        
        // Jika pelanggaran diverifikasi, buat sanksi otomatis
        if ($verifikasiData->tabel_terkait === 'pelanggaran' && $request->status === 'diverifikasi') {
            $pelanggaran = Pelanggaran::with('jenisPelanggaran')->find($verifikasiData->id_terkait);
            if ($pelanggaran) {
                $this->buatSanksiOtomatis($pelanggaran);
            }
        }
        
        return redirect('/kesiswaan/verifikasi-data')->with('success', 'Status verifikasi berhasil diupdate');
    }

    public function updateVerifikasi(Request $request, $id, $tipe)
    {
        $status = $request->status === 'verified' ? 'diverifikasi' : 'ditolak';
        
        // Update status di tabel verifikasi_data
        $verifikasiData = VerifikasiData::where('tabel_terkait', $tipe)
            ->where('id_terkait', $id)
            ->first();
            
        if ($verifikasiData) {
            $verifikasiData->update(['status' => $status]);
            
            // Jika pelanggaran diverifikasi, buat sanksi otomatis
            if ($tipe === 'pelanggaran' && $status === 'diverifikasi') {
                $pelanggaran = Pelanggaran::with('jenisPelanggaran')->find($id);
                if ($pelanggaran) {
                    $this->buatSanksiOtomatis($pelanggaran);
                }
            }
            
            // Jika prestasi, update juga status_verifikasi di tabel prestasi
            if ($tipe === 'prestasi') {
                $prestasi = Prestasi::find($id);
                if ($prestasi) {
                    $prestasi->update(['status_verifikasi' => $status === 'diverifikasi' ? 'disetujui' : 'ditolak']);
                }
            }
        }
        
        return redirect()->route('kesiswaan.verifikasi-data')->with('success', 'Status verifikasi berhasil diupdate');
    }

    private function buatSanksiOtomatis($pelanggaran)
    {
        // Tentukan jenis sanksi berdasarkan poin pelanggaran
        $poin = $pelanggaran->poin;
        $jenisSanksi = '';
        $deskripsi = '';
        
        if ($poin <= 10) {
            $jenisSanksi = 'Teguran Lisan';
            $deskripsi = 'Mendapat teguran lisan dari guru BK';
        } elseif ($poin <= 25) {
            $jenisSanksi = 'Teguran Tertulis';
            $deskripsi = 'Membuat surat pernyataan tidak mengulangi pelanggaran';
        } elseif ($poin <= 50) {
            $jenisSanksi = 'Panggilan Orang Tua';
            $deskripsi = 'Orang tua dipanggil ke sekolah untuk konseling';
        } elseif ($poin <= 75) {
            $jenisSanksi = 'Skorsing 1 Hari';
            $deskripsi = 'Tidak boleh mengikuti kegiatan belajar selama 1 hari';
        } elseif ($poin <= 100) {
            $jenisSanksi = 'Skorsing 3 Hari';
            $deskripsi = 'Tidak boleh mengikuti kegiatan belajar selama 3 hari';
        } else {
            $jenisSanksi = 'Pemanggilan Komite Sekolah';
            $deskripsi = 'Kasus diserahkan kepada komite sekolah untuk tindakan lebih lanjut';
        }
        
        // Buat sanksi
        \App\Models\Sanksi::create([
            'pelanggaran_id' => $pelanggaran->id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $deskripsi,
            'tanggal_mulai' => now()->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(7)->format('Y-m-d'), // 7 hari untuk menyelesaikan
            'status' => 'direncanakan'
        ]);
    }

    public function deletePelanggaran($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        
        // Simpan ke riwayat sebelum dihapus
        RiwayatPelanggaran::create([
            'siswa_id' => $pelanggaran->siswa_id,
            'jenis_pelanggaran_id' => $pelanggaran->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $pelanggaran->tahun_ajaran_id,
            'guru_pencatat' => $pelanggaran->guru_pencatat,
            'poin' => $pelanggaran->poin,
            'keterangan' => $pelanggaran->keterangan,
            'tanggal_pelanggaran' => $pelanggaran->created_at,
            'tanggal_dihapus' => now(),
            'alasan_hapus' => 'Dihapus oleh kesiswaan'
        ]);
        
        $pelanggaran->delete();
        
        return redirect('/kesiswaan/input-pelanggaran')->with('success', 'Data pelanggaran berhasil dihapus dan disimpan ke riwayat');
    }

    public function riwayatPelanggaran()
    {
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru'])
            ->orderBy('tanggal_dihapus', 'desc')
            ->get();
        return view('page_kesiswaan.riwayat-pelanggaran', compact('riwayat'));
    }

    public function exportPdf()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get();
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi'])->get();
        
        $pdf = \PDF::loadView('exports.kesiswaan-pdf', compact('pelanggaran', 'prestasi'));
        return $pdf->download('laporan-kesiswaan-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        return \Excel::download(new \App\Exports\KesiswaanExport, 'laporan-kesiswaan-' . date('Y-m-d') . '.xlsx');
    }

    public function deleteRiwayat($id)
    {
        $riwayat = RiwayatPelanggaran::findOrFail($id);
        $riwayat->delete();
        
        return redirect('/kesiswaan/riwayat-pelanggaran')->with('success', 'Riwayat pelanggaran berhasil dihapus permanen');
    }

    public function sanksi()
    {
        $sanksi = \App\Models\Sanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'pelaksanaanSanksi'])->get();
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get();
        return view('page_kesiswaan.sanksi', compact('sanksi', 'pelanggaran'));
    }

    public function storeSanksi(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:direncanakan,berjalan,selesai,ditunda,dibatalkan'
        ]);

        \App\Models\Sanksi::create($request->all());
        
        return redirect('/kesiswaan/sanksi')->with('success', 'Data sanksi berhasil ditambahkan');
    }

    public function updateSanksi(Request $request, $id)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:direncanakan,berjalan,selesai,ditunda,dibatalkan'
        ]);

        $sanksi = \App\Models\Sanksi::findOrFail($id);
        $sanksi->update($request->all());
        
        return redirect('/kesiswaan/sanksi')->with('success', 'Data sanksi berhasil diupdate');
    }

    public function deleteSanksi($id)
    {
        $sanksi = \App\Models\Sanksi::findOrFail($id);
        $sanksi->delete();
        
        return redirect('/kesiswaan/sanksi')->with('success', 'Data sanksi berhasil dihapus');
    }

    public function getSanksi($id)
    {
        $sanksi = \App\Models\Sanksi::findOrFail($id);
        return response()->json($sanksi);
    }

    public function lihatBukti($id)
    {
        $pelaksanaan = \App\Models\PelaksanaanSanksi::findOrFail($id);
        
        if (!$pelaksanaan->bukti || !\Storage::disk('public')->exists($pelaksanaan->bukti)) {
            abort(404, 'Bukti tidak ditemukan');
        }
        
        return response()->file(storage_path('app/public/' . $pelaksanaan->bukti));
    }

    public function updateStatusPelaksanaan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terjadwal,dikerjakan,tuntas,terlambat,perpanjangan'
        ]);

        $pelaksanaan = \App\Models\PelaksanaanSanksi::findOrFail($id);
        $pelaksanaan->update(['status' => $request->status]);
        
        // Update status sanksi otomatis berdasarkan pelaksanaan
        $sanksi = $pelaksanaan->sanksi;
        $this->updateStatusSanksiFromPelaksanaan($sanksi);
        
        return redirect('/kesiswaan/sanksi')->with('success', 'Status pelaksanaan berhasil diupdate');
    }

    private function updateStatusSanksiFromPelaksanaan($sanksi)
    {
        $pelaksanaanList = $sanksi->pelaksanaanSanksi;
        
        if ($pelaksanaanList->isEmpty()) {
            $sanksi->update(['status' => 'direncanakan']);
        } else {
            $adaTuntas = $pelaksanaanList->where('status', 'tuntas')->count() > 0;
            $adaDikerjakan = $pelaksanaanList->where('status', 'dikerjakan')->count() > 0;
            $adaTerjadwal = $pelaksanaanList->where('status', 'terjadwal')->count() > 0;
            
            if ($adaTuntas) {
                $sanksi->update(['status' => 'selesai']);
            } elseif ($adaDikerjakan) {
                $sanksi->update(['status' => 'berjalan']);
            } elseif ($adaTerjadwal) {
                $sanksi->update(['status' => 'berjalan']);
            } else {
                $sanksi->update(['status' => 'direncanakan']);
            }
        }
    }

    public function riwayatPelanggaranSemua(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat', 'sanksi']);
        
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }
        
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }
        
        if ($request->filled('siswa')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->siswa . '%');
            });
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->paginate(20);
        $kelas = \App\Models\Kelas::all();
        
        return view('page_kesiswaan.riwayat-pelanggaran-semua', compact('pelanggaran', 'kelas'));
    }
}