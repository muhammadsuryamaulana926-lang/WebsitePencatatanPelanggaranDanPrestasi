<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    use HasFactory;

    protected $table = 'bimbingan_konseling';

    protected $primaryKey = 'bk_id';
    
    protected $fillable = [
        'siswa_id',
        'guru_konselor',
        'tahun_ajaran_id',
        'jenis_layanan',
        'topik',
        'keluhan_masalah',
        'tindakan_solusi',
        'status',
        'status_pengajuan',
        'alasan_penolakan',
        'tanggal_konseling',
        'tanggal_tindak_lanjut',
        'hasil_evaluasi'
    ];

    protected $casts = [
        'tanggal_konseling' => 'date',
        'tanggal_tindak_lanjut' => 'date'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function konselor()
    {
        return $this->belongsTo(Guru::class, 'guru_konselor');
    }
}