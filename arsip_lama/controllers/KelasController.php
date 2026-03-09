<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->get();
        $guru = Guru::where('status', 'aktif')->get();
        return view('page_admin.data-kelas', compact('kelas', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas'
        ], [
            'nama_kelas.unique' => 'Nama kelas sudah ada, gunakan nama lain'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'jurusan' => $request->jurusan,
            'wali_kelas_id' => $request->wali_kelas_id
        ]);
        
        return redirect('/admin/data-kelas')->with('success', 'Data kelas berhasil ditambahkan');
    }



    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        
        return redirect('/admin/data-kelas')->with('success', 'Data kelas berhasil dihapus');
    }
}