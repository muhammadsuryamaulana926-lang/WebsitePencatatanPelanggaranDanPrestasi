<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'monitoring_pelanggaran';

    protected $fillable = [
        'pelanggaran_id',
        'guru_kepsek',
        'catatan',
        'status'
    ];



    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }

    public function guruKepsek()
    {
        return $this->belongsTo(Guru::class, 'guru_kepsek');
    }
}