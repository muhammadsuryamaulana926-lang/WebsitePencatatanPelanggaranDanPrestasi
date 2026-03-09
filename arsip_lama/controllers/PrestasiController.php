<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\JenisPrestasi;
use App\Models\TahunAjaran;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with(['siswa', 'guruPencatat', 'jenisPrestasi'])->get();
        $siswa = Siswa::all();
        $guru = Guru::where('status', 'aktif')->get();
        $jenisPrestasi = JenisPrestasi::all();
        $tahunAjaran = TahunAjaran::all();
        return view('page_admin.data-prestasi', compact('prestasi', 'siswa', 'guru', 'jenisPrestasi', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'jenis_prestasi_id' => 'required',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id'
        ]);

        Prestasi::create([
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'poin' => 10,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect('/admin/data-prestasi')->with('success', 'Data prestasi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required',
            'jenis_prestasi_id' => 'required',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id'
        ]);

        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update([
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'poin' => 10,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect('/admin/data-prestasi')->with('success', 'Data prestasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->delete();
        
        return redirect('/admin/data-prestasi')->with('success', 'Data prestasi berhasil dihapus');
    }
}