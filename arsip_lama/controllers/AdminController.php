<?php

namespace App\Http\Controllers;

use App\Models\VerifikasiData;
use App\Models\MonitoringPelanggaran;
use App\Models\BimbinganKonseling;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $verifikasiData = VerifikasiData::with('guru')->get();
        $monitoringPelanggaran = MonitoringPelanggaran::with(['pelanggaran.siswa', 'guruKepsek'])->get();
        $bimbinganKonseling = BimbinganKonseling::with(['siswa', 'konselor'])->get();
        $tahunAjaran = TahunAjaran::all();
        
        // Data statistik
        $totalSiswa = \App\Models\Siswa::count();
        $totalGuru = \App\Models\Guru::count();
        $pelanggaranBulanIni = \App\Models\Pelanggaran::whereMonth('created_at', now()->month)->count();
        $sanksiAktif = \App\Models\Sanksi::whereIn('status', ['direncanakan', 'berjalan'])->count();
        $totalPrestasi = \App\Models\Prestasi::count();
        
        // Data grafik pelanggaran per bulan (12 bulan terakhir)
        $pelanggaranPerBulan = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = \App\Models\Pelanggaran::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $pelanggaranPerBulan[] = [
                'bulan' => $date->format('M Y'),
                'jumlah' => $count
            ];
        }
        
        // Data grafik jenis sanksi terbanyak
        $jenisSanksi = \App\Models\Sanksi::select('jenis_sanksi', \DB::raw('count(*) as total'))
            ->groupBy('jenis_sanksi')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        return view('page_admin.admin', compact(
            'verifikasiData', 
            'monitoringPelanggaran', 
            'bimbinganKonseling', 
            'tahunAjaran',
            'totalSiswa',
            'totalGuru', 
            'pelanggaranBulanIni',
            'sanksiAktif',
            'totalPrestasi',
            'pelanggaranPerBulan',
            'jenisSanksi'
        ));
    }

    public function dataVerifikasi()
    {
        // Data yang sudah ada di tabel verifikasi
        $verifikasiData = VerifikasiData::with('guru')->get();
        
        // Data baru yang perlu verifikasi (belum ada di tabel verifikasi)
        $siswaBaruBelumVerifikasi = \App\Models\Siswa::whereNotIn('id', 
            VerifikasiData::where('tabel_terkait', 'siswa')->pluck('id_terkait')
        )->get();
        
        $guruBaruBelumVerifikasi = \App\Models\Guru::whereNotIn('id', 
            VerifikasiData::where('tabel_terkait', 'guru')->pluck('id_terkait')
        )->get();
        
        $pelanggaranBaruBelumVerifikasi = \App\Models\Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->whereNotIn('id', VerifikasiData::where('tabel_terkait', 'pelanggaran')->pluck('id_terkait'))
            ->get();
        
        $prestasiBaruBelumVerifikasi = \App\Models\Prestasi::with(['siswa', 'jenisPrestasi'])
            ->whereNotIn('id', VerifikasiData::where('tabel_terkait', 'prestasi')->pluck('id_terkait'))
            ->get();
        
        $guru = \App\Models\Guru::all();
        
        return view('page_admin.data-verifikasi', compact(
            'verifikasiData', 
            'guru',
            'siswaBaruBelumVerifikasi',
            'guruBaruBelumVerifikasi', 
            'pelanggaranBaruBelumVerifikasi',
            'prestasiBaruBelumVerifikasi'
        ));
    }

    public function monitoringPelanggaran()
    {
        // Data monitoring yang sudah ada
        $monitoringPelanggaran = MonitoringPelanggaran::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'guruKepsek'])->get();
        
        // Pelanggaran baru yang belum dimonitor (otomatis muncul)
        $pelanggaranBelumDimonitor = \App\Models\Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guruPencatat'])
            ->whereNotIn('id', MonitoringPelanggaran::pluck('pelanggaran_id'))
            ->orderBy('created_at', 'desc')
            ->get();
        
        $guru = \App\Models\Guru::all();
        
        return view('page_admin.monitoring-pelanggaran', compact(
            'monitoringPelanggaran', 
            'pelanggaranBelumDimonitor',
            'guru'
        ));
    }

    public function storeMonitoring(Request $request)
    {
        MonitoringPelanggaran::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'guru_kepsek' => $request->guru_kepsek,
            'catatan' => $request->catatan,
            'status' => $request->status ?? 'dipantau'
        ]);
        
        return redirect('/admin/monitoring-pelanggaran')->with('success', 'Pelanggaran berhasil ditambahkan ke monitoring');
    }

    public function addToMonitoring(Request $request)
    {
        MonitoringPelanggaran::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'guru_kepsek' => $request->guru_kepsek,
            'catatan' => $request->catatan,
            'status' => 'dipantau'
        ]);
        
        return redirect('/admin/monitoring-pelanggaran')->with('success', 'Pelanggaran berhasil ditambahkan ke monitoring');
    }

    public function updateMonitoring(Request $request, $id)
    {
        $monitoring = MonitoringPelanggaran::findOrFail($id);
        $monitoring->update([
            'guru_kepsek' => $request->guru_kepsek,
            'catatan' => $request->catatan,
            'status' => $request->status
        ]);
        
        return redirect('/admin/monitoring-pelanggaran')->with('success', 'Data monitoring berhasil diupdate');
    }

    public function deleteMonitoring($id)
    {
        $monitoring = MonitoringPelanggaran::findOrFail($id);
        $monitoring->delete();
        
        return redirect('/admin/monitoring-pelanggaran')->with('success', 'Data monitoring berhasil dihapus');
    }

    public function bimbinganKonseling()
    {
        $bimbinganKonseling = BimbinganKonseling::with(['siswa', 'konselor'])->get();
        $siswa = \App\Models\Siswa::all();
        $guru = \App\Models\Guru::all();
        return view('page_admin.bimbingan-konseling', compact('bimbinganKonseling', 'siswa', 'guru'));
    }

    public function storeBimbinganKonseling(Request $request)
    {
        BimbinganKonseling::create([
            'siswa_id' => $request->siswa_id,
            'guru_konselor_id' => $request->guru_konselor_id,
            'topik' => $request->topik,
            'status' => $request->status,
            'tindakan' => $request->tindakan
        ]);
        
        return redirect('/admin/bimbingan-konseling')->with('success', 'Bimbingan konseling berhasil ditambahkan');
    }

    public function manajemenUser()
    {
        $users = \App\Models\User::with('guru')->get();
        $guru = \App\Models\Guru::all();
        return view('page_admin.manajemen-user', compact('users', 'guru'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'level' => 'required'
        ], [
            'username.unique' => 'Username sudah digunakan'
        ]);

        \App\Models\User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'guru_id' => $request->guru_id,
            'can_verify' => $request->has('can_verify')
        ]);
        
        return redirect('/admin/manajemen-user')->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'level' => 'required'
        ], [
            'username.unique' => 'Username sudah digunakan'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $updateData = [
            'username' => $request->username,
            'level' => $request->level,
            'guru_id' => $request->guru_id,
            'can_verify' => $request->has('can_verify')
        ];
        
        if ($request->password) {
            $updateData['password'] = bcrypt($request->password);
        }
        
        $user->update($updateData);
        
        return redirect('/admin/manajemen-user')->with('success', 'User berhasil diupdate');
    }

    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        
        return redirect('/admin/manajemen-user')->with('success', 'User berhasil dihapus');
    }

    public function updateBimbinganKonseling(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required',
            'guru_konselor_id' => 'required',
            'topik' => 'required',
            'status' => 'required'
        ]);

        $bimbingan = BimbinganKonseling::findOrFail($id);
        $bimbingan->update([
            'siswa_id' => $request->siswa_id,
            'guru_konselor_id' => $request->guru_konselor_id,
            'topik' => $request->topik,
            'status' => $request->status,
            'tindakan' => $request->tindakan
        ]);
        
        return redirect('/admin/bimbingan-konseling')->with('success', 'Bimbingan konseling berhasil diupdate');
    }

    public function destroyBimbinganKonseling($id)
    {
        $bimbingan = BimbinganKonseling::findOrFail($id);
        $bimbingan->delete();
        
        return redirect('/admin/bimbingan-konseling')->with('success', 'Bimbingan konseling berhasil dihapus');
    }

    public function updateTahunAjaran(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required'
        ]);

        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'status_aktif' => $request->has('status_aktif')
        ]);
        
        return redirect('/admin/tahun-ajaran')->with('success', 'Tahun ajaran berhasil diupdate');
    }

    public function destroyTahunAjaran($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();
        
        return redirect('/admin/tahun-ajaran')->with('success', 'Tahun ajaran berhasil dihapus');
    }

    public function tahunAjaran()
    {
        $tahunAjaran = TahunAjaran::all();
        return view('page_admin.tahun-ajaran', compact('tahunAjaran'));
    }

    public function storeTahunAjaran(Request $request)
    {
        TahunAjaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'status_aktif' => $request->has('status_aktif')
        ]);
        
        return redirect('/admin/tahun-ajaran')->with('success', 'Tahun ajaran berhasil ditambahkan');
    }

    public function storeVerifikasi(Request $request)
    {
        VerifikasiData::create([
            'tabel_terkait' => $request->tabel_terkait,
            'id_terkait' => $request->id_terkait,
            'guru_verifikator' => $request->guru_verifikator,
            'status' => 'menunggu'
        ]);
        
        return redirect('/admin/data-verifikasi')->with('success', 'Data berhasil ditambahkan ke antrian verifikasi');
    }

    public function addToVerifikasi(Request $request)
    {
        VerifikasiData::create([
            'tabel_terkait' => $request->tabel_terkait,
            'id_terkait' => $request->id_terkait,
            'guru_verifikator' => $request->guru_verifikator,
            'status' => 'menunggu'
        ]);
        
        return redirect('/admin/data-verifikasi')->with('success', 'Data berhasil ditambahkan ke antrian verifikasi');
    }

    public function updateVerifikasi(Request $request, $id)
    {
        $verifikasi = VerifikasiData::findOrFail($id);
        $verifikasi->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);
        
        return redirect('/admin/data-verifikasi')->with('success', 'Status verifikasi berhasil diupdate');
    }

    public function monitoringAll()
    {
        // Ambil semua siswa dengan total poin pelanggaran dan data pelaksanaan sanksi
        $monitoring = \App\Models\Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'pelanggaran.sanksi.pelaksanaanSanksi'])
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
            ->sortByDesc('total_poin');
            
        return view('page_admin.monitoring-all', compact('monitoring'));
    }

    public function exportBimbinganKonseling(Request $request)
    {
        $query = BimbinganKonseling::with(['siswa', 'konselor']);
        
        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        if ($request->periode && $request->periode != 'semua') {
            $query->whereMonth('created_at', $request->periode);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('exports.bimbingan-konseling', compact('data'));
        return $pdf->download('laporan-bimbingan-konseling.pdf');
    }

    public function riwayatPelanggaran(Request $request)
    {
        $query = \App\Models\Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat', 'sanksi']);
        
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
        
        return view('page_admin.riwayat-pelanggaran', compact('pelanggaran', 'kelas'));
    }

    public function exportLaporanPdf(Request $request)
    {
        // Data statistik
        $totalSiswa = \App\Models\Siswa::count();
        $totalGuru = \App\Models\Guru::count();
        $totalPelanggaran = \App\Models\Pelanggaran::count();
        $totalPrestasi = \App\Models\Prestasi::count();
        
        // Data pelanggaran dengan filter
        $query = \App\Models\Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat']);
        
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->get();
        
        // Data prestasi
        $prestasi = \App\Models\Prestasi::with(['siswa.kelas', 'jenisPrestasi'])
            ->when($request->filled('bulan'), function($q) use ($request) {
                $q->whereMonth('created_at', $request->bulan);
            })
            ->when($request->filled('tahun'), function($q) use ($request) {
                $q->whereYear('created_at', $request->tahun);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Data monitoring
        $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'guruKepsek'])
            ->get();
        
        // Data bimbingan konseling
        $bimbingan = BimbinganKonseling::with(['siswa.kelas', 'konselor'])
            ->when($request->filled('bulan'), function($q) use ($request) {
                $q->whereMonth('created_at', $request->bulan);
            })
            ->when($request->filled('tahun'), function($q) use ($request) {
                $q->whereYear('created_at', $request->tahun);
            })
            ->get();
        
        $data = [
            'totalSiswa' => $totalSiswa,
            'totalGuru' => $totalGuru,
            'totalPelanggaran' => $totalPelanggaran,
            'totalPrestasi' => $totalPrestasi,
            'pelanggaran' => $pelanggaran,
            'prestasi' => $prestasi,
            'monitoring' => $monitoring,
            'bimbingan' => $bimbingan,
            'periode' => $request->bulan ? date('F Y', mktime(0, 0, 0, $request->bulan, 1, $request->tahun ?? date('Y'))) : 'Semua Data',
            'tanggal_cetak' => date('d F Y')
        ];
        
        $pdf = Pdf::loadView('exports.laporan-admin', $data);
        return $pdf->download('laporan-admin-' . date('Y-m-d') . '.pdf');
    }
}