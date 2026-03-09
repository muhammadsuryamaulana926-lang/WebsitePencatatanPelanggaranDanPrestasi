<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;
use App\Models\User;
use App\Models\Siswa;

class OrangtuaController extends Controller
{
    public function index()
    {
        $orangtua = Orangtua::with(['user', 'siswa'])->get();
        $users = User::where('level', 'ortu')->get();
        $siswa = Siswa::all();
        return view('page_admin.data-orangtua', compact('orangtua', 'users', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|in:ayah,ibu,wali',
            'nama_orangtua' => 'required|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:50',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string'
        ]);

        Orangtua::create($request->all());
        
        return redirect('/admin/data-orangtua')->with('success', 'Data orang tua berhasil ditambahkan');
    }



    public function destroy($id)
    {
        $orangtua = Orangtua::where('orangtua_id', $id)->firstOrFail();
        $orangtua->delete();
        
        return redirect('/admin/data-orangtua')->with('success', 'Data orang tua berhasil dihapus');
    }
}