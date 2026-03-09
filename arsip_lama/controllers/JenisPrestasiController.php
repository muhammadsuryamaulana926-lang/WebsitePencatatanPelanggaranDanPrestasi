<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPrestasi;

class JenisPrestasiController extends Controller
{
    public function index()
    {
        $jenisPrestasi = JenisPrestasi::all();
        return view('page_admin.data-jenis-prestasi', compact('jenisPrestasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required',
            'poin' => 'required|numeric',
            'kategori' => 'required'
        ]);

        JenisPrestasi::create([
            'nama_prestasi' => $request->nama_prestasi,
            'poin' => $request->poin,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi
        ]);
        
        return redirect('/admin/data-jenis-prestasi')->with('success', 'Data jenis prestasi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prestasi' => 'required',
            'poin' => 'required|numeric',
            'kategori' => 'required'
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($id);
        $jenisPrestasi->update([
            'nama_prestasi' => $request->nama_prestasi,
            'poin' => $request->poin,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi
        ]);
        
        return redirect('/admin/data-jenis-prestasi')->with('success', 'Data jenis prestasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $jenisPrestasi = JenisPrestasi::findOrFail($id);
        $jenisPrestasi->delete();
        
        return redirect('/admin/data-jenis-prestasi')->with('success', 'Data jenis prestasi berhasil dihapus');
    }
}