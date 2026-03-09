<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class WaliKelasController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $kelasWali = $guru ? $guru->kelasWali : collect();
        
        $totalSiswa = 0;
        $totalPelanggaran = 0;
        $totalPrestasi = 0;
        
        foreach($kelasWali as $kelas) {
            $totalSiswa += $kelas->siswa->count();
            $totalPelanggaran += Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->id);
            })->count();
        }
        
        return view('page_walikelas.walikelas', compact('kelasWali', 'totalSiswa', 'totalPelanggaran', 'totalPrestasi'));
    }

    public function inputPelanggaran()
    {
        $guru = Auth::user()->guru;
        $kelasWali = $guru ? $guru->kelasWali : collect();
        
        // Ambil hanya siswa dari kelas yang diwali untuk dropdown dan tabel
        $siswa = collect();
        $pelanggaranKelas = collect();
        foreach($kelasWali as $kelas) {
            $siswa = $siswa->merge($kelas->siswa()->with('kelas')->get());
            $pelanggaranKelas = $pelanggaranKelas->merge($kelas->siswa()->with('pelanggaran.jenisPelanggaran', 'pelanggaran.guruPencatat', 'pelanggaran.verifikasi')->get());
        }
        
        $jenisPelanggaran = JenisPelanggaran::all();
        $allGuru = Guru::where('status', 'aktif')->get();
        
        return view('page_walikelas.input-pelanggaran', compact('siswa', 'pelanggaranKelas', 'jenisPelanggaran', 'allGuru'));
    }

    public function storePelanggaran(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'poin' => 'required|numeric'
        ]);

        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', true)->first();
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'poin' => $request->poin,
            'guru_pencatat' => $request->guru_pencatat ?: Auth::user()->guru->id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'keterangan' => $request->keterangan
        ]);

        // Otomatis tambahkan ke tabel verifikasi_data
        \App\Models\VerifikasiData::create([
            'tabel_terkait' => 'pelanggaran',
            'id_terkait' => $pelanggaran->id,
            'guru_verifikator' => $request->guru_pencatat ?: Auth::user()->guru->id,
            'status' => 'menunggu'
        ]);
        
        return redirect('/walikelas/input-pelanggaran')->with('success', 'Pelanggaran berhasil ditambahkan dan masuk ke antrian verifikasi');
    }

    public function viewDataSendiri()
    {
        $guru = Auth::user()->guru;
        $kelasWali = $guru ? $guru->kelasWali : collect();
        
        // Hanya ambil pelanggaran dari kelas yang diwali oleh guru yang login
        $pelanggaran = collect();
        foreach($kelasWali as $kelas) {
            $pelanggaranKelas = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
                ->whereHas('siswa', function($q) use ($kelas) {
                    $q->where('kelas_id', $kelas->id);
                })->get();
            $pelanggaran = $pelanggaran->merge($pelanggaranKelas);
        }
        
        return view('page_walikelas.view-data-sendiri', compact('pelanggaran', 'kelasWali', 'guru'));
    }

    public function exportLaporan()
    {
        $guru = Auth::user()->guru;
        $kelasWali = $guru ? $guru->kelasWali : collect();
        
        $pelanggaran = collect();
        foreach($kelasWali as $kelas) {
            $pelanggaranKelas = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
                ->whereHas('siswa', function($q) use ($kelas) {
                    $q->where('kelas_id', $kelas->id);
                })->get();
            $pelanggaran = $pelanggaran->merge($pelanggaranKelas);
        }
        
        $pdf = Pdf::loadView('exports.walikelas-pdf', compact('pelanggaran', 'kelasWali', 'guru'));
        return $pdf->download('laporan-walikelas-' . date('Y-m-d') . '.pdf');
    }
}