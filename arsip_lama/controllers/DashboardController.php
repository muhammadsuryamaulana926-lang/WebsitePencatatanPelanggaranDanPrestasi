<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik umum
        $totalSiswa = Siswa::count();
        $totalPelanggaran = Pelanggaran::count();
        $totalPrestasi = Prestasi::count();
        $totalKonseling = BimbinganKonseling::count();

        // Data pelanggaran per kelas
        $pelanggaranPerKelas = Kelas::withCount('siswa')
            ->with(['siswa' => function($query) {
                $query->withCount('pelanggaran');
            }])
            ->get()
            ->map(function($kelas) {
                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'total_pelanggaran' => $kelas->siswa->sum('pelanggaran_count')
                ];
            });

        // Data prestasi per kelas
        $prestasiPerKelas = Kelas::withCount('siswa')
            ->with(['siswa' => function($query) {
                $query->withCount('prestasi');
            }])
            ->get()
            ->map(function($kelas) {
                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'total_prestasi' => $kelas->siswa->sum('prestasi_count')
                ];
            });

        // Data trend bulanan (12 bulan terakhir)
        $trendData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M');
            
            $pelanggaranCount = Pelanggaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $prestasiCount = Prestasi::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $konselingCount = BimbinganKonseling::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $trendData[] = [
                'month' => $month,
                'pelanggaran' => $pelanggaranCount,
                'prestasi' => $prestasiCount,
                'konseling' => $konselingCount
            ];
        }

        // Top 5 siswa dengan poin pelanggaran tertinggi
        $topPelanggaran = Siswa::with('kelas')
            ->withSum('pelanggaran', 'poin')
            ->orderByDesc('pelanggaran_sum_poin')
            ->limit(5)
            ->get();

        // Top 5 siswa dengan poin prestasi tertinggi
        $topPrestasi = Siswa::with('kelas')
            ->withSum('prestasi', 'poin')
            ->orderByDesc('prestasi_sum_poin')
            ->limit(5)
            ->get();

        // Jadwal konseling hari ini
        $jadwalKonseling = BimbinganKonseling::with(['siswa.kelas', 'konselor'])
            ->whereDate('created_at', today())
            ->orderBy('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalSiswa',
            'totalPelanggaran', 
            'totalPrestasi',
            'totalKonseling',
            'pelanggaranPerKelas',
            'prestasiPerKelas',
            'trendData',
            'topPelanggaran',
            'topPrestasi',
            'jadwalKonseling'
        ));
    }

    public function getChartData()
    {
        // API endpoint untuk mendapatkan data chart terbaru
        $pelanggaranPerKelas = Kelas::with(['siswa' => function($query) {
                $query->withCount('pelanggaran');
            }])
            ->get()
            ->map(function($kelas) {
                return [
                    'label' => $kelas->nama_kelas,
                    'value' => $kelas->siswa->sum('pelanggaran_count')
                ];
            });

        $prestasiPerKelas = Kelas::with(['siswa' => function($query) {
                $query->withCount('prestasi');
            }])
            ->get()
            ->map(function($kelas) {
                return [
                    'label' => $kelas->nama_kelas,
                    'value' => $kelas->siswa->sum('prestasi_count')
                ];
            });

        return response()->json([
            'pelanggaran_per_kelas' => $pelanggaranPerKelas,
            'prestasi_per_kelas' => $prestasiPerKelas
        ]);
    }
}