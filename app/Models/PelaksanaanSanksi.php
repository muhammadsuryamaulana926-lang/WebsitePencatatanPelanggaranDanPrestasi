<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanSanksi extends Model
{
    use HasFactory;

    protected $table = 'pelaksanaan_sanksi';

    protected $fillable = [
        'sanksi_id',
        'tanggal_pelaksanaan',
        'bukti',
        'catatan',
        'status'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date'
    ];

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class);
    }
}