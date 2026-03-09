<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'poin',
        'kategori',
        'kategori_utama',
        'sanksi_rekomendasi'
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}