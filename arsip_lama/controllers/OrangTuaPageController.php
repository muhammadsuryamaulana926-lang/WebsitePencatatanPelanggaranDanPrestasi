<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrangTuaPageController extends Controller
{
    public function index()
    {
        $username = Auth::user()->username;
        
        // Cek apakah username format ortu_[NIS]
        if (str_starts_with($username, 'ortu_')) {
            $nis = str_replace('ortu_', '', $username);
            $orangtua = Orangtua::whereHas('siswa', function($query) use ($nis) {
                $query->where('nis', $nis);
            })->with('siswa.kelas')->first();
        } else {
            $orangtua = Orangtua::where('nama_orangtua', $username)->with('siswa.kelas')->first();
        }
        
        if (!$orangtua) {
            return redirect()->back()->with('error', 'Data orang tua tidak ditemukan');
        }

        $pelanggaran = Pelanggaran::where('siswa_id', $orangtua->siswa_id)->get();
        $prestasi = Prestasi::where('siswa_id', $orangtua->siswa_id)->get();
        
        return view('page_ortu.ortu', compact('orangtua', 'pelanggaran', 'prestasi'));
    }

    public function viewDataSendiri()
    {
        $username = Auth::user()->username;
        
        if (str_starts_with($username, 'ortu_')) {
            $nis = str_replace('ortu_', '', $username);
            $orangtua = Orangtua::whereHas('siswa', function($query) use ($nis) {
                $query->where('nis', $nis);
            })->with('siswa.kelas.waliKelas')->first();
        } else {
            $orangtua = Orangtua::where('nama_orangtua', $username)->with('siswa.kelas.waliKelas')->first();
        }
        
        if (!$orangtua) {
            return redirect()->back()->with('error', 'Data orang tua tidak ditemukan');
        }

        return view('page_ortu.view-data-sendiri', compact('orangtua'));
    }

    public function viewDataAnak()
    {
        $username = Auth::user()->username;
        
        if (str_starts_with($username, 'ortu_')) {
            $nis = str_replace('ortu_', '', $username);
            $orangtua = Orangtua::whereHas('siswa', function($query) use ($nis) {
                $query->where('nis', $nis);
            })->with('siswa.kelas')->first();
        } else {
            $orangtua = Orangtua::where('nama_orangtua', $username)->with('siswa.kelas')->first();
        }
        
        if (!$orangtua) {
            return redirect()->back()->with('error', 'Data orang tua tidak ditemukan');
        }

        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'guruPencatat'])
            ->where('siswa_id', $orangtua->siswa_id)
            ->get();
            
        $prestasi = Prestasi::with(['jenisPrestasi', 'guruPencatat'])
            ->where('siswa_id', $orangtua->siswa_id)
            ->get();

        return view('page_ortu.view-data-anak', compact('orangtua', 'pelanggaran', 'prestasi'));
    }

    public function exportLaporan()
    {
        $username = Auth::user()->username;
        
        if (str_starts_with($username, 'ortu_')) {
            $nis = str_replace('ortu_', '', $username);
            $orangtua = Orangtua::whereHas('siswa', function($query) use ($nis) {
                $query->where('nis', $nis);
            })->with('siswa.kelas')->first();
        } else {
            $orangtua = Orangtua::where('nama_orangtua', $username)->with('siswa.kelas')->first();
        }
        
        if (!$orangtua) {
            return redirect()->back()->with('error', 'Data orang tua tidak ditemukan');
        }

        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'guruPencatat'])
            ->where('siswa_id', $orangtua->siswa_id)
            ->get();
            
        $prestasi = Prestasi::with(['jenisPrestasi', 'guruPencatat'])
            ->where('siswa_id', $orangtua->siswa_id)
            ->get();

        $pdf = Pdf::loadView('exports.orangtua-pdf', compact('orangtua', 'pelanggaran', 'prestasi'));
        return $pdf->download('laporan-anak-' . $orangtua->siswa->nis . '-' . date('Y-m-d') . '.pdf');
    }
}