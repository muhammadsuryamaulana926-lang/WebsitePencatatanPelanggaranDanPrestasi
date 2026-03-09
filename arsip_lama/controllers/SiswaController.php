<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('page_admin.data-siswa', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required'
        ], [
            'nis.unique' => 'NIS sudah terdaftar, gunakan NIS lain'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);
        
        return redirect('/admin/data-siswa')->with('success', 'Data siswa berhasil ditambahkan');
    }



    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        
        return redirect('/admin/data-siswa')->with('success', 'Data siswa berhasil dihapus');
    }

    public function dashboard()
    {
        $siswa = Siswa::with('kelas')->where('nis', Auth::user()->username)->first();
        
        if (!$siswa) {
            return view('page_siswa.siswa', [
                'totalPoinPelanggaran' => 0,
                'totalPoinPrestasi' => 0,
                'sanksiAktif' => 0,
                'riwayatTerbaru' => collect()
            ]);
        }

        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'guruPencatat'])
            ->where('siswa_id', $siswa->id)
            ->get();
            
        $prestasi = Prestasi::with(['jenisPrestasi', 'guruPencatat'])
            ->where('siswa_id', $siswa->id)
            ->get();

        $sanksiAktif = \App\Models\Sanksi::whereHas('pelanggaran', function($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })->whereIn('status', ['direncanakan', 'berjalan'])->count();

        $riwayatTerbaru = collect();
        
        foreach($pelanggaran->take(3) as $p) {
            $riwayatTerbaru->push([
                'tanggal' => $p->created_at->format('d/m'),
                'jenis' => 'Pelanggaran',
                'deskripsi' => $p->jenisPelanggaran->nama_pelanggaran ?? 'Pelanggaran',
                'status' => 'Selesai',
                'badge_class' => 'bg-danger'
            ]);
        }
        
        foreach($prestasi->take(3) as $pr) {
            $riwayatTerbaru->push([
                'tanggal' => $pr->created_at->format('d/m'),
                'jenis' => 'Prestasi',
                'deskripsi' => $pr->jenisPrestasi->nama_prestasi ?? 'Prestasi',
                'status' => 'Disetujui',
                'badge_class' => 'bg-warning'
            ]);
        }
        
        return view('page_siswa.siswa', [
            'siswa' => $siswa,
            'totalPoinPelanggaran' => $pelanggaran->sum('poin'),
            'totalPoinPrestasi' => $prestasi->sum('poin'),
            'sanksiAktif' => $sanksiAktif,
            'riwayatTerbaru' => $riwayatTerbaru->sortByDesc('tanggal')->take(5)
        ]);
    }

    public function viewDataSendiri()
    {
        $siswa = Siswa::with(['kelas', 'orangtua'])->where('nis', Auth::user()->username)->first();
        
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'guruPencatat'])
            ->where('siswa_id', $siswa->id)
            ->get();
            
        $prestasi = Prestasi::with(['jenisPrestasi', 'guruPencatat'])
            ->where('siswa_id', $siswa->id)
            ->get();
        
        return view('page_siswa.view-data-sendiri', compact('siswa', 'pelanggaran', 'prestasi'));
    }

    public function exportLaporan()
    {
        $siswa = Siswa::with('kelas')->where('nis', Auth::user()->username)->first();
        
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'guruPencatat'])
            ->where('siswa_id', $siswa->id)
            ->get();
            
        $prestasi = Prestasi::with(['jenisPrestasi', 'guruPencatat'])
            ->where('siswa_id', $siswa->id)
            ->get();
        
        $pdf = Pdf::loadView('exports.siswa-pdf', compact('siswa', 'pelanggaran', 'prestasi'));
        return $pdf->download('laporan-siswa-' . $siswa->nis . '-' . date('Y-m-d') . '.pdf');
    }

    public function bimbinganKonseling()
    {
        $siswa = Siswa::where('nis', Auth::user()->username)->first();
        
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        $bimbingan = BimbinganKonseling::with('konselor')
            ->where('siswa_id', $siswa->id)
            ->where('status_pengajuan', 'disetujui')
            ->orderBy('tanggal_konseling', 'desc')
            ->get();
        
        return view('page_siswa.bimbingan-konseling', compact('siswa', 'bimbingan'));
    }

    public function ajukanBimbingan()
    {
        $siswa = Siswa::where('nis', Auth::user()->username)->first();
        
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        $pengajuan = BimbinganKonseling::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('page_siswa.ajukan-bimbingan', compact('siswa', 'pengajuan'));
    }

    public function storePengajuanBimbingan(Request $request)
    {
        $request->validate([
            'topik' => 'required',
            'keluhan' => 'required'
        ]);

        $siswa = Siswa::where('nis', Auth::user()->username)->first();
        
        // Ambil guru pertama yang ada sebagai default konselor
        $guruKonselor = \App\Models\Guru::first();
        
        BimbinganKonseling::create([
            'siswa_id' => $siswa->id,
            'guru_konselor' => $guruKonselor->id,
            'jenis_layanan' => 'konseling_individual',
            'topik' => $request->topik,
            'keluhan_masalah' => $request->keluhan,
            'tindakan_solusi' => 'Menunggu jadwal konseling dari BK',
            'tanggal_konseling' => now()->format('Y-m-d'),
            'status' => 'terjadwal',
            'status_pengajuan' => 'diajukan'
        ]);
        
        return redirect('/siswa/ajukan-bimbingan')->with('success', 'Pengajuan bimbingan berhasil dikirim. Menunggu persetujuan BK.');
    }
}