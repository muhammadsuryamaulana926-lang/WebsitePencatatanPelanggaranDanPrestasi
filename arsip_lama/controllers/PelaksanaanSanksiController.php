<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;

class PelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa', 'sanksi.pelanggaran.jenisPelanggaran'])->get();
        $sanksi = Sanksi::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran'])->get();
        return view('page_admin.data-pelaksanaan-sanksi', compact('pelaksanaanSanksi', 'sanksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sanksi_id' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_sanksi', 'public');
        }

        PelaksanaanSanksi::create([
            'sanksi_id' => $request->sanksi_id,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'bukti' => $buktiPath,
            'catatan' => $request->catatan,
            'status' => $request->status ?? 'terjadwal'
        ]);
        
        return redirect('/admin/data-pelaksanaan-sanksi')->with('success', 'Data pelaksanaan sanksi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sanksi_id' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);
        
        $updateData = [
            'sanksi_id' => $request->sanksi_id,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'catatan' => $request->catatan,
            'status' => $request->status ?? 'terjadwal'
        ];
        
        // Handle file upload jika ada file baru
        if ($request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($pelaksanaanSanksi->bukti && \Storage::disk('public')->exists($pelaksanaanSanksi->bukti)) {
                \Storage::disk('public')->delete($pelaksanaanSanksi->bukti);
            }
            $updateData['bukti'] = $request->file('bukti')->store('bukti_sanksi', 'public');
        }
        
        $pelaksanaanSanksi->update($updateData);
        
        return redirect('/admin/data-pelaksanaan-sanksi')->with('success', 'Data pelaksanaan sanksi berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelaksanaanSanksi = PelaksanaanSanksi::findOrFail($id);
        
        // Hapus file bukti jika ada
        if ($pelaksanaanSanksi->bukti && \Storage::disk('public')->exists($pelaksanaanSanksi->bukti)) {
            \Storage::disk('public')->delete($pelaksanaanSanksi->bukti);
        }
        
        $pelaksanaanSanksi->delete();
        
        return redirect('/admin/data-pelaksanaan-sanksi')->with('success', 'Data pelaksanaan sanksi berhasil dihapus');
    }
}