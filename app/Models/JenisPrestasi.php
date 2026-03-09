<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPrestasi extends Model
{
    use HasFactory;

    protected $table = 'jenis_prestasi';

    protected $fillable = [
        'nama_prestasi',
        'poin',
        'kategori',
        'deskripsi'
    ];

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }
}