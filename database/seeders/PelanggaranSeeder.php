<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Siswa::first();
        $jenisPelanggaran = JenisPelanggaran::first();

        if ($siswa && $jenisPelanggaran) {
            Pelanggaran::create([
                'siswa_id' => $siswa->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->id,
                'poin' => $jenisPelanggaran->poin,
                'keterangan' => 'Contoh pelanggaran untuk testing'
            ]);
        }
    }
}