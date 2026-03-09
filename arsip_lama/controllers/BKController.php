<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BKController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        
        $totalSiswaBinaan = BimbinganKonseling::where('guru_konselor', $guru->id ?? 1)->count();
        $sesiMingguIni = BimbinganKonseling::where('guru_konselor', $guru->id ?? 1)
            ->where('created_at', '>=', now()->startOfWeek())->count();
        $kasusBerat = BimbinganKonseling::where('guru_konselor', $guru->id ?? 1)
            ->where('status', 'berlangsung')->count();
        
        return view('page_bk.bk', compact('totalSiswaBinaan', 'sesiMingguIni', 'kasusBerat'));
    }

    public function inputBK()
    {
        $siswa = Siswa::with('kelas')->get();
        $guru = Guru::where('status', 'aktif')->get();
        $bimbinganKonseling = BimbinganKonseling::with(['siswa.kelas', 'konselor'])
            ->get();
            
        $pengajuanBaru = BimbinganKonseling::with(['siswa.kelas'])
            ->where('status_pengajuan', 'diajukan')
            ->get();
        
        return view('page_bk.input-bk', compact('siswa', 'guru', 'bimbinganKonseling', 'pengajuanBaru'));
    }

    public function storeBK(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'topik' => 'required',
            'status' => 'required'
        ]);

        BimbinganKonseling::create([
            'siswa_id' => $request->siswa_id,
            'guru_konselor' => $request->guru_konselor ?: Auth::user()->guru->id,
            'jenis_layanan' => 'konseling_individual',
            'topik' => $request->topik,
            'tindakan_solusi' => $request->tindakan,
            'tanggal_konseling' => $request->tanggal_konseling ?: now()->format('Y-m-d'),
            'status' => $request->status ?: 'terjadwal',
            'status_pengajuan' => 'disetujui'
        ]);
        
        return redirect('/bk/input-bk')->with('success', 'Data bimbingan konseling berhasil ditambahkan');
    }

    public function updateBK(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'tindakan' => 'required'
        ]);

        $statusMap = [
            'terjadwal' => 'terdaftar',
            'berlangsung' => 'diproses', 
            'selesai' => 'selesai',
            'follow_up' => 'tindak_lanjut'
        ];
        
        $status = $statusMap[$request->status] ?? $request->status;

        BimbinganKonseling::where('bk_id', $id)->update([
            'status' => $request->status,
            'tindakan_solusi' => $request->tindakan,
            'tanggal_konseling' => $request->tanggal_konseling ?: now()->format('Y-m-d')
        ]);

        return redirect('/bk/input-bk')->with('success', 'Status bimbingan berhasil diupdate');
    }

    public function verifikasiPengajuan(Request $request, $id)
    {
        $action = $request->action;
        
        if ($action == 'setujui') {
            BimbinganKonseling::where('bk_id', $id)->update([
                'status_pengajuan' => 'disetujui',
                'guru_konselor' => Auth::user()->guru->id
            ]);
            $message = 'Pengajuan bimbingan disetujui';
        } else {
            BimbinganKonseling::where('bk_id', $id)->update([
                'status_pengajuan' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan
            ]);
            $message = 'Pengajuan bimbingan ditolak';
        }
        
        return redirect('/bk/input-bk')->with('success', $message);
    }

    public function viewDataSendiri()
    {
        $guru = Auth::user()->guru;
        $bimbinganKonseling = BimbinganKonseling::with(['siswa.kelas', 'konselor'])
            ->where('guru_konselor', $guru->id ?? 1)
            ->get();
        
        return view('page_bk.view-data-sendiri', compact('bimbinganKonseling'));
    }

    public function exportLaporan(Request $request)
    {
        $guru = Auth::user()->guru;
        $query = BimbinganKonseling::with(['siswa.kelas', 'konselor'])
            ->where('guru_konselor', $guru->id ?? 1);
        
        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }
        
        if ($request->periode && $request->periode != 'semua') {
            $query->whereMonth('created_at', $request->periode);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        if ($request->has('export')) {
            $pdf = Pdf::loadView('exports.bk-laporan', compact('data', 'guru'));
            return $pdf->download('laporan-bk-bimbingan-konseling.pdf');
        }
        
        return view('page_bk.export-laporan', compact('data'));
    }
}