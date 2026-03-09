<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil guru berdasarkan bidang studi untuk penugasan wali kelas yang sesuai
        $guruPPLG = Guru::where('bidang_studi', 'like', '%Pemrograman%')->orWhere('bidang_studi', 'like', '%Basis Data%')->orWhere('bidang_studi', 'like', '%Pengembangan%')->pluck('id')->toArray();
        $guruPemasaran = Guru::where('bidang_studi', 'like', '%Pemasaran%')->orWhere('bidang_studi', 'like', '%Bisnis%')->pluck('id')->toArray();
        $guruDKV = Guru::where('bidang_studi', 'like', '%Desain%')->orWhere('bidang_studi', 'like', '%Multimedia%')->pluck('id')->toArray();
        $guruAkuntansi = Guru::where('bidang_studi', 'like', '%Akuntansi%')->orWhere('bidang_studi', 'like', '%Ekonomi%')->pluck('id')->toArray();
        $guruAnimasi = Guru::where('bidang_studi', 'like', '%Animasi%')->orWhere('bidang_studi', 'like', '%Ilustrasi%')->pluck('id')->toArray();
        $guruUmum = Guru::whereNotIn('id', array_merge($guruPPLG, $guruPemasaran, $guruDKV, $guruAkuntansi, $guruAnimasi))->pluck('id')->toArray();
        
        $kelas = [
            ['nama_kelas' => '12 PPLG 1', 'jurusan' => 'Pengembangan Perangkat Lunak dan Gim', 'wali_kelas_id' => $guruPPLG[0] ?? $guruUmum[0] ?? null],
            ['nama_kelas' => '12 PPLG 2', 'jurusan' => 'Pengembangan Perangkat Lunak dan Gim', 'wali_kelas_id' => $guruPPLG[1] ?? $guruUmum[1] ?? null],
            ['nama_kelas' => '12 PPLG 3', 'jurusan' => 'Pengembangan Perangkat Lunak dan Gim', 'wali_kelas_id' => $guruPPLG[2] ?? $guruUmum[2] ?? null],
            ['nama_kelas' => '12 Pemasaran', 'jurusan' => 'Pemasaran', 'wali_kelas_id' => $guruPemasaran[0] ?? $guruUmum[3] ?? null],
            ['nama_kelas' => '12 DKV', 'jurusan' => 'Desain Komunikasi Visual', 'wali_kelas_id' => $guruDKV[0] ?? $guruUmum[4] ?? null],
            ['nama_kelas' => '12 Akuntansi 1', 'jurusan' => 'Akuntansi dan Keuangan Lembaga', 'wali_kelas_id' => $guruAkuntansi[0] ?? $guruUmum[5] ?? null],
            ['nama_kelas' => '12 Akuntansi 2', 'jurusan' => 'Akuntansi dan Keuangan Lembaga', 'wali_kelas_id' => $guruAkuntansi[1] ?? $guruUmum[6] ?? null],
            ['nama_kelas' => '12 Animasi', 'jurusan' => 'Animasi', 'wali_kelas_id' => $guruAnimasi[0] ?? $guruUmum[7] ?? null],
        ];

        foreach ($kelas as $data) {
            DB::table('kelas')->insert([
                'nama_kelas' => $data['nama_kelas'],
                'jurusan' => $data['jurusan'],
                'wali_kelas_id' => $data['wali_kelas_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}