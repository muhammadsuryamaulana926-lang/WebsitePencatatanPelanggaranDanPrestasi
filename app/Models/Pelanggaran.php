<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id',
        'guru_pencatat',
        'jenis_pelanggaran_id',
        'tahun_ajaran_id',
        'poin',
        'keterangan'
    ];



    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function guruPencatat()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat');
    }

    public function sanksi()
    {
        return $this->hasMany(Sanksi::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiData::class, 'id_terkait')->where('tabel_terkait', 'pelanggaran');
    }

    protected static function booted()
    {
        static::created(function ($pelanggaran) {
            // Otomatis tambahkan ke tabel verifikasi_data
            \App\Models\VerifikasiData::create([
                'tabel_terkait' => 'pelanggaran',
                'id_terkait' => $pelanggaran->id,
                'guru_verifikator' => $pelanggaran->guru_pencatat ?? 1,
                'status' => 'menunggu'
            ]);

            // Otomatis buat sanksi berdasarkan total poin
            $pelanggaran->createAutoSanksi();
        });
    }

    public function createAutoSanksi()
    {
        // Hitung total poin siswa (hanya yang sanksinya belum selesai)
        $totalPoin = $this->getTotalPoinSiswa($this->siswa_id);
        $jenisSanksi = $this->getJenisSanksiByPoin($totalPoin);

        // Cek apakah ada sanksi aktif (belum selesai) untuk siswa ini
        $sanksiAktif = \App\Models\Sanksi::whereHas('pelanggaran', function ($query) {
            $query->where('siswa_id', $this->siswa_id);
        })
            ->whereIn('status', ['belum_dilaksanakan', 'direncanakan', 'berjalan'])
            ->get();

        // Batalkan sanksi lama jika ada dan sanksi baru lebih berat
        foreach ($sanksiAktif as $sanksiLama) {
            if ($this->isSanksiLebihBerat($jenisSanksi, $sanksiLama->jenis_sanksi)) {
                $sanksiLama->update([
                    'status' => 'dibatalkan',
                    'deskripsi' => $sanksiLama->deskripsi . "\n\n[DIBATALKAN] Digantikan dengan sanksi lebih berat: {$jenisSanksi}"
                ]);

                $sanksiLama->pelaksanaanSanksi()->update([
                    'status' => 'dibatalkan',
                    'catatan' => 'Sanksi dibatalkan karena ada pelanggaran baru dengan sanksi lebih berat'
                ]);
            }
        }

        // Buat sanksi baru
        $sanksiPelanggaran = $this->getDaftarPelanggaranSiswa($this->siswa_id);
        $sanksi = \App\Models\Sanksi::create([
            'pelanggaran_id' => $this->id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi' => $this->getDeskripsiSanksi($jenisSanksi) . "\n\nPelanggaran terkait: " . $sanksiPelanggaran,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => $this->getTanggalSelesai($jenisSanksi),
            'status' => 'belum_dilaksanakan'
        ]);

        // Buat pelaksanaan sanksi otomatis
        \App\Models\PelaksanaanSanksi::create([
            'sanksi_id' => $sanksi->id,
            'siswa_id' => $this->siswa_id,
            'tanggal_pelaksanaan' => now(),
            'status' => 'belum_dikerjakan'
        ]);
    }

    private function getTotalPoinSiswa($siswaId)
    {
        return \Illuminate\Support\Facades\DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->leftJoin('sanksi', 'pelanggaran.id', '=', 'sanksi.pelanggaran_id')
            ->leftJoin('pelaksanaan_sanksi', 'sanksi.id', '=', 'pelaksanaan_sanksi.sanksi_id')
            ->where('pelanggaran.siswa_id', $siswaId)
            ->where(function ($query) {
                $query->whereNull('sanksi.id')
                    ->orWhere('pelaksanaan_sanksi.status', '!=', 'selesai')
                    ->orWhereNull('pelaksanaan_sanksi.status');
            })
            ->sum('jenis_pelanggaran.poin');
    }

    private function getJenisSanksiByPoin($totalPoin)
    {
        if ($totalPoin >= 90) return 'Dikembalikan Kepada Orang Tua (Keluar)';
        if ($totalPoin >= 41) return 'Diserahkan Kepada Orang Tua 1 Bulan';
        if ($totalPoin >= 36) return 'Diserahkan Kepada Orang Tua 2 Minggu';
        if ($totalPoin >= 26) return 'Diskors Selama 7 Hari';
        if ($totalPoin >= 21) return 'Diskors Selama 3 Hari';
        if ($totalPoin >= 16) return 'Perjanjian Siswa Diatas Materai';
        if ($totalPoin >= 11) return 'Peringatan Tertulis';
        if ($totalPoin >= 6) return 'Peringatan Lisan';
        return 'Dicatat dan Konseling';
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

    private function getTanggalSelesai($jenisSanksi)
    {
        $hari = [
            'Diskors Selama 3 Hari' => 3,
            'Diskors Selama 7 Hari' => 7,
            'Diserahkan Kepada Orang Tua 2 Minggu' => 14,
            'Diserahkan Kepada Orang Tua 1 Bulan' => 30
        ];
        return now()->addDays($hari[$jenisSanksi] ?? 7);
    }

    private function isSanksiLebihBerat($sanksiBaruJenis, $sanksiLamaJenis)
    {
        $tingkatSanksi = [
            'Dicatat dan Konseling' => 1,
            'Peringatan Lisan' => 2,
            'Peringatan Tertulis' => 3,
            'Perjanjian Siswa Diatas Materai' => 4,
            'Diskors Selama 3 Hari' => 5,
            'Diskors Selama 7 Hari' => 6,
            'Diserahkan Kepada Orang Tua 2 Minggu' => 7,
            'Diserahkan Kepada Orang Tua 1 Bulan' => 8,
            'Dikembalikan Kepada Orang Tua (Keluar)' => 9
        ];
        return ($tingkatSanksi[$sanksiBaruJenis] ?? 0) > ($tingkatSanksi[$sanksiLamaJenis] ?? 0);
    }

    private function getDaftarPelanggaranSiswa($siswaId)
    {
        $pelanggaran = static::with('jenisPelanggaran')
            ->where('siswa_id', $siswaId)
            ->whereDoesntHave('sanksi', function ($query) {
                $query->where('status', 'selesai');
            })
            ->get();
        return $pelanggaran->map(fn($p) => $p->jenisPelanggaran->nama_pelanggaran ?? 'Unknown')->implode(', ');
    }
}
