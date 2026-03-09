<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama_guru',
        'bidang_studi',
        'status'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function pelanggaranDicatat()
    {
        return $this->hasMany(Pelanggaran::class, 'guru_pencatat');
    }

    public function pelanggaranPencatat()
    {
        return $this->hasMany(Pelanggaran::class, 'guru_pencatat');
    }

    public function prestasiDicatat()
    {
        return $this->hasMany(Prestasi::class, 'guru_pencatat');
    }

    public function prestasiPencatat()
    {
        return $this->hasMany(Prestasi::class, 'guru_pencatat');
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'guru_konselor');
    }

    public function monitoringPelanggaran()
    {
        return $this->hasMany(MonitoringPelanggaran::class, 'guru_kepsek');
    }

    public function verifikasiData()
    {
        return $this->hasMany(VerifikasiData::class, 'guru_verifikator');
    }
}