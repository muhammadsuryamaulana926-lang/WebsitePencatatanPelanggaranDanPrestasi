<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use Barryvdh\DomPDF\Facade\Pdf;

class KepalaSekolahController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalPelanggaran = Pelanggaran::count();
        $totalPrestasi = Prestasi::count();
        $totalBimbingan = BimbinganKonseling::count();
        
        return view('page_kepala_sekolah.kepala_sekolah', compact('totalSiswa', 'totalPelanggaran', 'totalPrestasi', 'totalBimbingan'));
    }

    public function monitoringAll()
    {
        // Monitoring semua data siswa dengan total poin pelanggaran dan data pelaksanaan sanksi
        $monitoring = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'pelanggaran.sanksi.pelaksanaanSanksi', 'prestasi.jenisPrestasi'])
            ->get()
            ->map(function($siswa) {
                $totalPoinPelanggaran = $siswa->pelanggaran->sum('poin');
                $totalPoinPrestasi = $siswa->prestasi->sum('poin');
                $status = 'normal';
                
                if ($totalPoinPelanggaran >= 100) {
                    $status = 'critical';
                } elseif ($totalPoinPelanggaran >= 50) {
                    $status = 'warning';
                }
                
                return (object) [
                    'siswa' => $siswa,
                    'total_poin' => $totalPoinPelanggaran,
                    'total_poin_prestasi' => $totalPoinPrestasi,
                    'status' => $status,
                    'updated_at' => $siswa->updated_at
                ];
            })
            ->sortByDesc('total_poin');
            
        return view('page_kepala_sekolah.monitoring-all', compact('monitoring'));
    }

    public function viewDataSendiri()
    {
        $user = auth()->user();
        $guru = $user->guru;
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])->get();
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guruPencatat'])->get();
        $bimbinganKonseling = BimbinganKonseling::with(['siswa.kelas', 'konselor'])->get();
        
        return view('page_kepala_sekolah.view-data-sendiri', compact('guru', 'pelanggaran', 'prestasi', 'bimbinganKonseling'));
    }

    public function viewDataAnak()
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi.jenisPrestasi'])->get();
        $kelas = Kelas::with('siswa')->get();
        
        return view('page_kepala_sekolah.view-data-anak', compact('siswa', 'kelas'));
    }

    public function exportLaporan()
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])->get();
        $prestasi = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guruPencatat'])->get();
        $bimbinganKonseling = BimbinganKonseling::with(['siswa.kelas', 'konselor'])->get();
        $siswa = Siswa::with(['kelas', 'pelanggaran', 'prestasi'])->get();
        
        $pdf = Pdf::loadView('exports.kepala-sekolah-pdf', compact('pelanggaran', 'prestasi', 'bimbinganKonseling', 'siswa'));
        return $pdf->download('laporan-kepala-sekolah-' . date('Y-m-d') . '.pdf');
    }

    public function getDetailSiswa($id)
    {
        try {
            $siswa = Siswa::with([
                'kelas',
                'pelanggaran.jenisPelanggaran',
                'pelanggaran.guruPencatat',
                'pelanggaran.sanksi',
                'prestasi.jenisPrestasi',
                'prestasi.guruPencatat'
            ])->find($id);

            if (!$siswa) {
                return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
            }

            $bimbinganKonseling = BimbinganKonseling::with('konselor')
                ->where('siswa_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'siswa' => $siswa,
                'bimbingan_konseling' => $bimbinganKonseling
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function riwayatPelanggaran(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat', 'sanksi']);
        
        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }
        
        // Filter berdasarkan nama siswa
        if ($request->filled('siswa')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->siswa . '%');
            });
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->paginate(20);
        $kelas = Kelas::all();
        
        return view('page_kepala_sekolah.riwayat-pelanggaran', compact('pelanggaran', 'kelas'));
    }

    public function profile()
    {
        $user = auth()->user();
        $guru = $user->guru;
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data profil tidak ditemukan');
        }
        
        return view('page_kepala_sekolah.profile', compact('guru'));
    }
}