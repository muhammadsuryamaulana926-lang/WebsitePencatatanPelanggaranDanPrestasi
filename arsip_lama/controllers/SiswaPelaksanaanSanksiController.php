<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;
use Illuminate\Support\Facades\Auth;

class SiswaPelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $siswa = \App\Models\Siswa::where('nis', Auth::user()->username)->first();
        
        if (!$siswa) {
            return view('page_siswa.pelaksanaan-sanksi', ['sanksiSaya' => collect()]);
        }

        $sanksiSaya = Sanksi::whereHas('pelanggaran', function($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })
        ->where('status', '!=', 'dibatalkan')
        ->with(['pelaksanaanSanksi', 'pelanggaran.siswa', 'pelanggaran.jenisPelanggaran'])
        ->get();

        return view('page_siswa.pelaksanaan-sanksi', compact('sanksiSaya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sanksi_id' => 'required|exists:sanksi,id',
            'tanggal_pelaksanaan' => 'required|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'status' => 'required|in:dikerjakan,tuntas',
            'catatan' => 'nullable|string'
        ]);

        // Cek apakah sanksi milik siswa yang login
        $siswa = \App\Models\Siswa::where('nis', Auth::user()->username)->first();
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }
        
        $sanksi = Sanksi::whereHas('pelanggaran', function($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })->findOrFail($request->sanksi_id);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_sanksi', 'public');
        }

        PelaksanaanSanksi::create([
            'sanksi_id' => $request->sanksi_id,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'bukti' => $buktiPath,
            'catatan' => $request->catatan,
            'status' => $request->status
        ]);

        // Update status sanksi otomatis
        $this->updateStatusSanksi($sanksi);

        return redirect('/siswa/pelaksanaan-sanksi')->with('success', 'Pelaksanaan sanksi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sanksi_id' => 'required|exists:sanksi,id',
            'tanggal_pelaksanaan' => 'required|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'status' => 'required|in:dikerjakan,tuntas',
            'catatan' => 'nullable|string'
        ]);

        $siswa = \App\Models\Siswa::where('nis', Auth::user()->username)->first();
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        // Cek apakah sanksi milik siswa yang login
        $sanksi = Sanksi::whereHas('pelanggaran', function($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        })->findOrFail($request->sanksi_id);

        $pelaksanaanData = [
            'sanksi_id' => $request->sanksi_id,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'catatan' => $request->catatan,
            'status' => $request->status
        ];

        if ($request->hasFile('bukti')) {
            $pelaksanaanData['bukti'] = $request->file('bukti')->store('bukti_sanksi', 'public');
        }

        if ($id === 'new') {
            // Buat data baru
            PelaksanaanSanksi::create($pelaksanaanData);
            $message = 'Pelaksanaan sanksi berhasil ditambahkan';
        } else {
            // Update data yang ada
            $pelaksanaanSanksi = PelaksanaanSanksi::whereHas('sanksi.pelanggaran', function($query) use ($siswa) {
                $query->where('siswa_id', $siswa->id);
            })->findOrFail($id);

            if ($request->hasFile('bukti') && $pelaksanaanSanksi->bukti && \Storage::disk('public')->exists($pelaksanaanSanksi->bukti)) {
                \Storage::disk('public')->delete($pelaksanaanSanksi->bukti);
            }

            $pelaksanaanSanksi->update($pelaksanaanData);
            $message = 'Pelaksanaan sanksi berhasil diupdate';
        }

        // Update status sanksi otomatis
        $this->updateStatusSanksi($sanksi);

        return redirect('/siswa/pelaksanaan-sanksi')->with('success', $message);
    }

    public function updateBulk(Request $request)
    {
        $siswa = \App\Models\Siswa::where('nis', Auth::user()->username)->first();
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        foreach ($request->sanksi as $sanksiId => $data) {
            if (empty($data['tanggal_pelaksanaan']) || empty($data['status'])) {
                continue;
            }

            $sanksi = Sanksi::whereHas('pelanggaran', function($query) use ($siswa) {
                $query->where('siswa_id', $siswa->id);
            })->find($sanksiId);

            if (!$sanksi) continue;

            $pelaksanaan = PelaksanaanSanksi::where('sanksi_id', $sanksiId)->first();
            
            $pelaksanaanData = [
                'sanksi_id' => $sanksiId,
                'tanggal_pelaksanaan' => $data['tanggal_pelaksanaan'],
                'status' => $data['status'],
                'catatan' => $data['catatan'] ?? null
            ];

            if ($request->hasFile("sanksi.{$sanksiId}.bukti")) {
                $file = $request->file("sanksi.{$sanksiId}.bukti");
                if ($file->isValid()) {
                    if ($pelaksanaan && $pelaksanaan->bukti && \Storage::disk('public')->exists($pelaksanaan->bukti)) {
                        \Storage::disk('public')->delete($pelaksanaan->bukti);
                    }
                    $pelaksanaanData['bukti'] = $file->store('bukti_sanksi', 'public');
                }
            }

            if ($pelaksanaan) {
                $pelaksanaan->update($pelaksanaanData);
            } else {
                PelaksanaanSanksi::create($pelaksanaanData);
            }

            // Update status sanksi otomatis
            $this->updateStatusSanksi($sanksi);
        }

        return redirect('/siswa/pelaksanaan-sanksi')->with('success', 'Pelaksanaan sanksi berhasil disimpan');
    }

    private function updateStatusSanksi($sanksi)
    {
        $pelaksanaanList = $sanksi->pelaksanaanSanksi;
        
        if ($pelaksanaanList->isEmpty()) {
            // Tidak ada pelaksanaan, status tetap direncanakan
            $sanksi->update(['status' => 'direncanakan']);
        } else {
            // Cek apakah ada pelaksanaan dengan status tuntas
            $adaTuntas = $pelaksanaanList->where('status', 'tuntas')->count() > 0;
            $adaDikerjakan = $pelaksanaanList->where('status', 'dikerjakan')->count() > 0;
            
            if ($adaTuntas) {
                $sanksi->update(['status' => 'selesai']);
            } elseif ($adaDikerjakan) {
                $sanksi->update(['status' => 'berjalan']);
            } else {
                $sanksi->update(['status' => 'direncanakan']);
            }
        }
    }
}