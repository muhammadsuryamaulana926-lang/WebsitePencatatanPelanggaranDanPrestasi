<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    protected $fillable = [
        'siswa_id',
        'guru_pencatat',
        'jenis_prestasi_id',
        'tahun_ajaran_id',
        'poin',
        'tingkat',
        'peringkat',
        'tanggal_prestasi',
        'keterangan',
        'status_verifikasi'
    ];



    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class);
    }

    public function guruPencatat()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat');
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