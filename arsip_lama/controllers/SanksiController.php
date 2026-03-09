<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = Sanksi::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran'])->get();
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran'])->get();
        return view('page_admin.data-sanksi', compact('sanksi', 'pelanggaran'));
    }

    public function jenisSanksi()
    {
        $sanksi = Sanksi::with('pelanggaran.siswa')->get();
        $pelanggaran = \App\Models\Pelanggaran::with('siswa')->get();
        return view('page_admin.jenis_sanksi', compact('sanksi', 'pelanggaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required'
        ]);

        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran'])->findOrFail($request->pelanggaran_id);
        $totalPoin = $this->getTotalPoinSiswa($pelanggaran->siswa_id);
        $jenisSanksi = $this->getJenisSanksiByPoin($totalPoin);

        Sanksi::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $request->deskripsi ?? $this->getDeskripsiSanksi($jenisSanksi),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);
        
        return redirect()->back()->with('success', 'Sanksi berhasil ditambahkan dengan jenis: ' . $jenisSanksi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggaran_id' => 'required',
            'jenis_sanksi' => 'required'
        ]);

        $sanksi = Sanksi::findOrFail($id);
        $sanksi->update([
            'pelanggaran_id' => $request->pelanggaran_id,
            'jenis_sanksi' => $request->jenis_sanksi,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status ?? 'belum_dilaksanakan'
        ]);
        
        return redirect()->back()->with('success', 'Sanksi berhasil diupdate');
    }

    public function destroy($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        $sanksi->delete();
        
        return redirect()->back()->with('success', 'Sanksi berhasil dihapus');
    }

    private function getTotalPoinSiswa($siswaId)
    {
        // Hitung poin dari pelanggaran yang sanksinya belum selesai atau belum ada sanksi
        $poinBelumSelesai = DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->leftJoin('sanksi', 'pelanggaran.id', '=', 'sanksi.pelanggaran_id')
            ->leftJoin('pelaksanaan_sanksi', 'sanksi.id', '=', 'pelaksanaan_sanksi.sanksi_id')
            ->where('pelanggaran.siswa_id', $siswaId)
            ->where(function($query) {
                $query->whereNull('sanksi.id') // Belum ada sanksi
                      ->orWhere('pelaksanaan_sanksi.status', '!=', 'selesai') // Sanksi belum selesai
                      ->orWhereNull('pelaksanaan_sanksi.status'); // Belum ada pelaksanaan sanksi
            })
            ->sum('jenis_pelanggaran.poin');
            
        return $poinBelumSelesai;
    }

    private function getJenisSanksiByPoin($totalPoin)
    {
        if ($totalPoin >= 90) {
            return 'Dikembalikan Kepada Orang Tua (Keluar)';
        } elseif ($totalPoin >= 41) {
            return 'Diserahkan Kepada Orang Tua 1 Bulan';
        } elseif ($totalPoin >= 36) {
            return 'Diserahkan Kepada Orang Tua 2 Minggu';
        } elseif ($totalPoin >= 26) {
            return 'Diskors Selama 7 Hari';
        } elseif ($totalPoin >= 21) {
            return 'Diskors Selama 3 Hari';
        } elseif ($totalPoin >= 16) {
            return 'Perjanjian Siswa Diatas Materai';
        } elseif ($totalPoin >= 11) {
            return 'Peringatan Tertulis';
        } elseif ($totalPoin >= 6) {
            return 'Peringatan Lisan';
        } else {
            return 'Dicatat dan Konseling';
        }
    }

    private function getDeskripsiSanksi($jenisSanksi)
    {
        $deskripsi = [
            'Dicatat dan Konseling' => 'Pelanggaran ringan dicatat dan diberikan konseling',
            'Peringatan Lisan' => 'Diberikan peringatan lisan oleh guru/wali kelas',
            'Peringatan Tertulis' => 'Surat peringatan tertulis dengan perjanjian',
            'Perjanjian Siswa Diatas Materai' => 'Siswa membuat perjanjian tertulis diatas materai',
            'Diskors Selama 3 Hari' => 'Siswa tidak diperbolehkan masuk sekolah selama 3 hari',
            'Diskors Selama 7 Hari' => 'Siswa tidak diperbolehkan masuk sekolah selama 7 hari',
            'Diserahkan Kepada Orang Tua 2 Minggu' => 'Siswa diserahkan kepada orang tua untuk pembinaan 2 minggu',
            'Diserahkan Kepada Orang Tua 1 Bulan' => 'Siswa diserahkan kepada orang tua untuk pembinaan 1 bulan',
            'Dikembalikan Kepada Orang Tua (Keluar)' => 'Siswa dikeluarkan dari sekolah'
        ];
        
        return $deskripsi[$jenisSanksi] ?? 'Sanksi sesuai pelanggaran';
    }

    public function getSanksiOtomatis(Request $request)
    {
        $pelanggaranId = $request->pelanggaran_id;
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran'])->findOrFail($pelanggaranId);
        $totalPoin = $this->getTotalPoinSiswa($pelanggaran->siswa_id);
        $jenisSanksi = $this->getJenisSanksiByPoin($totalPoin);
        $deskripsi = $this->getDeskripsiSanksi($jenisSanksi);
        
        return response()->json([
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $deskripsi,
            'total_poin' => $totalPoin
        ]);
    }
}