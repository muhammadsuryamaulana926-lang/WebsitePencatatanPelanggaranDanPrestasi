<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas_id',
        'jenis_kelamin'
    ];



    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class);
    }

    public function orangtua()
    {
        return $this->hasMany(Orangtua::class);
    }
}