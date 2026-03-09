<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPelanggaran extends Model
{
    protected $table = 'riwayat_pelanggaran';

    protected $fillable = [
        'siswa_id',
        'jenis_pelanggaran_id',
        'tahun_ajaran_id',
        'guru_pencatat',
        'poin',
        'keterangan',
        'tanggal_pelanggaran',
        'tanggal_dihapus',
        'alasan_hapus'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
