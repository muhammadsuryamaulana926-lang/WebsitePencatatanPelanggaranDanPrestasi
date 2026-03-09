<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPrestasi = [
            ['nama_prestasi' => 'Akademik', 'poin' => 50, 'kategori' => 'akademik'],
            ['nama_prestasi' => 'Non Akademik', 'poin' => 50, 'kategori' => 'non_akademik'],
        ];

        foreach ($jenisPrestasi as $data) {
            DB::table('jenis_prestasi')->insert([
                'nama_prestasi' => $data['nama_prestasi'],
                'poin' => $data['poin'],
                'kategori' => $data['kategori'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}