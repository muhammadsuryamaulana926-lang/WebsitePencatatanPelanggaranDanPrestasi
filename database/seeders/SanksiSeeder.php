<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggaran;
use App\Models\Sanksi;

class SanksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data pelanggaran yang sudah ada
        $pelanggaran = Pelanggaran::first();
        if (!$pelanggaran) {
            return; // Skip jika tidak ada data pelanggaran
        }

        $jenisSanksi = [
            ['jenis_sanksi' => 'Dicatat dan Konseling', 'deskripsi' => 'Pelanggaran ringan dicatat dan diberikan konseling'],
            ['jenis_sanksi' => 'Peringatan Lisan', 'deskripsi' => 'Diberikan peringatan lisan oleh guru/wali kelas'],
            ['jenis_sanksi' => 'Peringatan Tertulis', 'deskripsi' => 'Surat peringatan tertulis dengan perjanjian'],
            ['jenis_sanksi' => 'Panggilan Orang Tua dengan Perjanjian', 'deskripsi' => 'Orang tua dipanggil untuk membuat perjanjian'],
            ['jenis_sanksi' => 'Perjanjian Siswa Diatas Materai', 'deskripsi' => 'Siswa membuat perjanjian tertulis diatas materai'],
            ['jenis_sanksi' => 'Diskors Selama 3 Hari', 'deskripsi' => 'Siswa tidak diperbolehkan masuk sekolah selama 3 hari'],
            ['jenis_sanksi' => 'Diskors Selama 7 Hari', 'deskripsi' => 'Siswa tidak diperbolehkan masuk sekolah selama 7 hari'],
            ['jenis_sanksi' => 'Diserahkan Kepada Orang Tua 2 Minggu', 'deskripsi' => 'Siswa diserahkan kepada orang tua untuk pembinaan 2 minggu'],
            ['jenis_sanksi' => 'Diserahkan Kepada Orang Tua 1 Bulan', 'deskripsi' => 'Siswa diserahkan kepada orang tua untuk pembinaan 1 bulan'],
            ['jenis_sanksi' => 'Dikembalikan Kepada Orang Tua (Keluar)', 'deskripsi' => 'Siswa dikeluarkan dari sekolah']
        ];

        foreach ($jenisSanksi as $sanksi) {
            DB::table('sanksi')->insert([
                'pelanggaran_id' => $pelanggaran->id,
                'jenis_sanksi' => $sanksi['jenis_sanksi'],
                'deskripsi' => $sanksi['deskripsi'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}