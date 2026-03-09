<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiData extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_data';
    
    protected $fillable = [
        'tabel_terkait',
        'id_terkait',
        'guru_verifikator',
        'status',
        'catatan'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_verifikator');
    }

    public function getDataTerkaitAttribute()
    {
        if ($this->tabel_terkait === 'prestasi') {
            return Prestasi::with(['siswa.kelas', 'jenisPrestasi'])->find($this->id_terkait);
        } elseif ($this->tabel_terkait === 'pelanggaran') {
            return Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->find($this->id_terkait);
        }
        return null;
    }

    public function getSiswaAttribute()
    {
        return $this->data_terkait?->siswa;
    }

    public function getJenisDataAttribute()
    {
        if ($this->tabel_terkait === 'prestasi') {
            return 'Prestasi: ' . ($this->data_terkait?->jenisPrestasi?->nama_prestasi ?? '-');
        } elseif ($this->tabel_terkait === 'pelanggaran') {
            return 'Pelanggaran: ' . ($this->data_terkait?->jenisPelanggaran?->nama_pelanggaran ?? '-');
        }
        return ucfirst($this->tabel_terkait);
    }
}