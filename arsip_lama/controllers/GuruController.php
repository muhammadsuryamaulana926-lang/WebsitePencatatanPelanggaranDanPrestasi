<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('page_admin.data-guru', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama_guru' => 'required',
            'status' => 'required'
        ], [
            'nip.unique' => 'NIP sudah terdaftar, gunakan NIP lain'
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'bidang_studi' => $request->bidang_studi,
            'status' => $request->status
        ]);
        
        return redirect('/admin/data-guru')->with('success', 'Data guru berhasil ditambahkan');
    }



    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        
        return redirect('/admin/data-guru')->with('success', 'Data guru berhasil dihapus');
    }
}