<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guru = [
            ['nip' => '19850112 200912 1 001', 'nama_guru' => 'Rudi Hartanto, S.Kom', 'bidang_studi' => 'Pemrograman Dasar'],
            ['nip' => '19890321 201401 1 002', 'nama_guru' => 'Desi Rahmawati, S.Kom', 'bidang_studi' => 'Basis Data'],
            ['nip' => '19910408 201408 1 003', 'nama_guru' => 'Andika Prasetyo, S.Kom', 'bidang_studi' => 'Pengembangan Gim & Web'],
            ['nip' => '19841207 201002 2 001', 'nama_guru' => 'Sari Mulyani, S.Pd', 'bidang_studi' => 'Bisnis & Pemasaran'],
            ['nip' => '19870614 201303 2 002', 'nama_guru' => 'Bambang Sentosa, S.Pd', 'bidang_studi' => 'Manajemen Produk'],
            ['nip' => '19860419 201203 3 001', 'nama_guru' => 'Rika Anjani, S.Sn', 'bidang_studi' => 'Desain Grafis'],
            ['nip' => '19900125 201501 3 002', 'nama_guru' => 'Yoga Pratama, S.Sn', 'bidang_studi' => 'Multimedia & Editing'],
            ['nip' => '19791211 200801 4 001', 'nama_guru' => 'Dewi Kartikasari, S.E', 'bidang_studi' => 'Akuntansi Dasar'],
            ['nip' => '19880530 201101 4 002', 'nama_guru' => 'Taufik Hidayat, S.E', 'bidang_studi' => 'Perpajakan'],
            ['nip' => '19920317 201506 4 003', 'nama_guru' => 'Melati Rahayu, S.E', 'bidang_studi' => 'Pengantar Ekonomi'],
            ['nip' => '19870928 201202 5 001', 'nama_guru' => 'Rendi Mahardika, S.Sn', 'bidang_studi' => 'Animasi 2D & 3D'],
            ['nip' => '19910419 201509 5 002', 'nama_guru' => 'Fitri Yuliana, S.Sn', 'bidang_studi' => 'Storyboard & Ilustrasi'],
            ['nip' => '19860318 201104 6 001', 'nama_guru' => 'Linda Apriliyani, S.Pd', 'bidang_studi' => 'Bahasa Inggris'],
            ['nip' => '19900912 201409 6 002', 'nama_guru' => 'Rian Mahendra, S.Pd', 'bidang_studi' => 'Bahasa Inggris'],
            ['nip' => '19870521 201208 7 001', 'nama_guru' => 'Misaki Nur Aoyama, S.Pd', 'bidang_studi' => 'Bahasa Jepang'],
            ['nip' => '19920227 201601 7 002', 'nama_guru' => 'Yuki Prasetya, S.Pd', 'bidang_studi' => 'Bahasa Jepang'],
            ['nip' => '19781214 200801 8 001', 'nama_guru' => 'Sulastri Wulandari, S.Pd', 'bidang_studi' => 'Bahasa Indonesia'],
            ['nip' => '19890330 201304 8 002', 'nama_guru' => 'Rangga Aditama, S.Pd', 'bidang_studi' => 'Bahasa Indonesia'],
            ['nip' => '19810402 200906 9 001', 'nama_guru' => 'Dedi Hartono, S.Pd', 'bidang_studi' => 'PPKn'],
            ['nip' => '19901122 201502 9 002', 'nama_guru' => 'Tri Yuningsih, S.Pd', 'bidang_studi' => 'PPKn'],
            ['nip' => '19790510 200703 10 001', 'nama_guru' => 'Ahmad Saeful, S.Pd', 'bidang_studi' => 'Matematika'],
            ['nip' => '19880216 201110 10 002', 'nama_guru' => 'Inayah Rahmatika, S.Pd', 'bidang_studi' => 'Matematika'],
            ['nip' => '19830211 200805 11 001', 'nama_guru' => 'H. Saiful Anwar, S.Ag', 'bidang_studi' => 'Pendidikan Agama Islam (PAI)'],
            ['nip' => '19911205 201403 11 002', 'nama_guru' => 'Umi Khairani, S.Ag', 'bidang_studi' => 'Pendidikan Agama Islam (PAI)'],
        ];

        foreach ($guru as $data) {
            DB::table('guru')->insert([
                'nip' => $data['nip'],
                'nama_guru' => $data['nama_guru'],
                'bidang_studi' => $data['bidang_studi'],
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}