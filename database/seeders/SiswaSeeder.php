<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaData = [
            // 12 PPLG 1 (15 siswa)
            ['2021001', 'Ahmad Rizki', '12 PPLG 1', 'L'],
            ['232301002', 'Amelia Putri', '12 PPLG 1', 'P'],
            ['232301003', 'Citra Lestari', '12 PPLG 1', 'P'],
            ['232301004', 'Dava Pratama', '12 PPLG 1', 'L'],
            ['232301005', 'Eka Yuliani', '12 PPLG 1', 'P'],
            ['232301006', 'Fajar Nugroho', '12 PPLG 1', 'L'],
            ['232301007', 'Gita Ramadhani', '12 PPLG 1', 'P'],
            ['232301008', 'Hari Setiawan', '12 PPLG 1', 'L'],
            ['232301009', 'Intan Safitri', '12 PPLG 1', 'P'],
            ['232301010', 'Jaya Prakoso', '12 PPLG 1', 'L'],
            ['232301011', 'Kania Putri', '12 PPLG 1', 'P'],
            ['232301012', 'Lukman Hakim', '12 PPLG 1', 'L'],
            ['232301013', 'Melani Ayu', '12 PPLG 1', 'P'],
            ['232301014', 'Nico Mahendra', '12 PPLG 1', 'L'],
            ['232301015', 'Olivia Rahma', '12 PPLG 1', 'P'],
            
            // 12 PPLG 2 (15 siswa)
            ['2021002', 'Siti Nurhaliza', '12 PPLG 2', 'P'],
            ['232302001', 'Bagas Wicaksono', '12 PPLG 2', 'L'],
            ['232302002', 'Cindy Oktavia', '12 PPLG 2', 'P'],
            ['232302003', 'Dio Raditya', '12 PPLG 2', 'L'],
            ['232302004', 'Eni Marlina', '12 PPLG 2', 'P'],
            ['232302005', 'Ferdy Triansyah', '12 PPLG 2', 'L'],
            ['232302006', 'Giska Amelia', '12 PPLG 2', 'P'],
            ['232302007', 'Hendra Saputra', '12 PPLG 2', 'L'],
            ['232302008', 'Indah Septiani', '12 PPLG 2', 'P'],
            ['232302009', 'Joko Priyanto', '12 PPLG 2', 'L'],
            ['232302010', 'Kurniawati Dewi', '12 PPLG 2', 'P'],
            ['232302011', 'Luthfi Ramadhan', '12 PPLG 2', 'L'],
            ['232302012', 'Mella Widya', '12 PPLG 2', 'P'],
            ['232302013', 'Novi Saputra', '12 PPLG 2', 'L'],
            ['232302014', 'Putri Sari', '12 PPLG 2', 'P'],
            
            // 12 PPLG 3 (15 siswa)
            ['2021003', 'Budi Setiawan', '12 PPLG 3', 'L'],
            ['232303001', 'Angga Pratama', '12 PPLG 3', 'L'],
            ['232303002', 'Bella Sundari', '12 PPLG 3', 'P'],
            ['232303003', 'Chakra Naufal', '12 PPLG 3', 'L'],
            ['232303004', 'Desi Arumsari', '12 PPLG 3', 'P'],
            ['232303005', 'Eko Gunawan', '12 PPLG 3', 'L'],
            ['232303006', 'Feby Lestari', '12 PPLG 3', 'P'],
            ['232303007', 'Gilang Permana', '12 PPLG 3', 'L'],
            ['232303008', 'Hani Yuliana', '12 PPLG 3', 'P'],
            ['232303009', 'Irawan Putra', '12 PPLG 3', 'L'],
            ['232303010', 'Jelsi Maharani', '12 PPLG 3', 'P'],
            ['232303011', 'Koko Pratomo', '12 PPLG 3', 'L'],
            ['232303012', 'Laras Anggun', '12 PPLG 3', 'P'],
            ['232303013', 'Miko Santoso', '12 PPLG 3', 'L'],
            ['232303014', 'Nia Meilani', '12 PPLG 3', 'P'],
            
            // 12 Pemasaran (15 siswa)
            ['232304001', 'Ahmad Fauzan', '12 Pemasaran', 'L'],
            ['232304002', 'Alif Rahman', '12 Pemasaran', 'L'],
            ['232304003', 'Brenda Putri', '12 Pemasaran', 'P'],
            ['232304004', 'Chairul Anwar', '12 Pemasaran', 'L'],
            ['232304005', 'Devi Safitri', '12 Pemasaran', 'P'],
            ['232304006', 'Erna Wulandari', '12 Pemasaran', 'P'],
            ['232304007', 'Fandi Agustian', '12 Pemasaran', 'L'],
            ['232304008', 'Gina Andini', '12 Pemasaran', 'P'],
            ['232304009', 'Hadi Prasetyo', '12 Pemasaran', 'L'],
            ['232304010', 'Intan Lestari', '12 Pemasaran', 'P'],
            ['232304011', 'Jundi Firmansyah', '12 Pemasaran', 'L'],
            ['232304012', 'Keisha Amanda', '12 Pemasaran', 'P'],
            ['232304013', 'Lutfiah Hidayah', '12 Pemasaran', 'P'],
            ['232304014', 'Maman Suherman', '12 Pemasaran', 'L'],
            ['232304015', 'Nindi Oktaviani', '12 Pemasaran', 'P'],
            
            // 12 DKV (15 siswa)
            ['232305001', 'Budi Pratama', '12 DKV', 'L'],
            ['232305002', 'Arka Wirawan', '12 DKV', 'L'],
            ['232305003', 'Bianka Maharani', '12 DKV', 'P'],
            ['232305004', 'Cahyo Nugroho', '12 DKV', 'L'],
            ['232305005', 'Dilla Sari', '12 DKV', 'P'],
            ['232305006', 'Eros Pratama', '12 DKV', 'L'],
            ['232305007', 'Farida Melani', '12 DKV', 'P'],
            ['232305008', 'Genta Pamungkas', '12 DKV', 'L'],
            ['232305009', 'Hulma Nirmala', '12 DKV', 'P'],
            ['232305010', 'Ikbal Mahendra', '12 DKV', 'L'],
            ['232305011', 'Jelita Marwah', '12 DKV', 'P'],
            ['232305012', 'Kevin Saputra', '12 DKV', 'L'],
            ['232305013', 'Liana Putri', '12 DKV', 'P'],
            ['232305014', 'Malik Rizki', '12 DKV', 'L'],
            ['232305015', 'Nadila Arum', '12 DKV', 'P'],
            
            // 12 Akuntansi 1 (15 siswa)
            ['232306001', 'Citra Dewi', '12 Akuntansi 1', 'P'],
            ['232306002', 'Andi Pratama', '12 Akuntansi 1', 'L'],
            ['232306003', 'Bella Safira', '12 Akuntansi 1', 'P'],
            ['232306004', 'Candra Wijaya', '12 Akuntansi 1', 'L'],
            ['232306005', 'Dina Marlina', '12 Akuntansi 1', 'P'],
            ['232306006', 'Eko Saputra', '12 Akuntansi 1', 'L'],
            ['232306007', 'Fitri Handayani', '12 Akuntansi 1', 'P'],
            ['232306008', 'Gilang Ramadhan', '12 Akuntansi 1', 'L'],
            ['232306009', 'Hesti Wulandari', '12 Akuntansi 1', 'P'],
            ['232306010', 'Indra Gunawan', '12 Akuntansi 1', 'L'],
            ['232306011', 'Jihan Amelia', '12 Akuntansi 1', 'P'],
            ['232306012', 'Krisna Bayu', '12 Akuntansi 1', 'L'],
            ['232306013', 'Lestari Dewi', '12 Akuntansi 1', 'P'],
            ['232306014', 'Maulana Fikri', '12 Akuntansi 1', 'L'],
            ['232306015', 'Nisa Rahmawati', '12 Akuntansi 1', 'P'],
            
            // 12 Akuntansi 2 (15 siswa)
            ['232307001', 'Arif Hidayat', '12 Akuntansi 2', 'L'],
            ['232307002', 'Bunga Lestari', '12 Akuntansi 2', 'P'],
            ['232307003', 'Cahya Permana', '12 Akuntansi 2', 'L'],
            ['232307004', 'Desi Kartika', '12 Akuntansi 2', 'P'],
            ['232307005', 'Edi Kurniawan', '12 Akuntansi 2', 'L'],
            ['232307006', 'Farah Nabila', '12 Akuntansi 2', 'P'],
            ['232307007', 'Galih Prasetyo', '12 Akuntansi 2', 'L'],
            ['232307008', 'Hana Safitri', '12 Akuntansi 2', 'P'],
            ['232307009', 'Irfan Maulana', '12 Akuntansi 2', 'L'],
            ['232307010', 'Julia Rahayu', '12 Akuntansi 2', 'P'],
            ['232307011', 'Kenzo Aditya', '12 Akuntansi 2', 'L'],
            ['232307012', 'Luna Aprilia', '12 Akuntansi 2', 'P'],
            ['232307013', 'Mario Santoso', '12 Akuntansi 2', 'L'],
            ['232307014', 'Nadia Putri', '12 Akuntansi 2', 'P'],
            ['232307015', 'Omar Fadhil', '12 Akuntansi 2', 'L'],
            
            // 12 Animasi (15 siswa)
            ['232308001', 'Alvin Nugraha', '12 Animasi', 'L'],
            ['232308002', 'Bintang Cahaya', '12 Animasi', 'P'],
            ['232308003', 'Cakra Buana', '12 Animasi', 'L'],
            ['232308004', 'Diana Sari', '12 Animasi', 'P'],
            ['232308005', 'Evan Pratama', '12 Animasi', 'L'],
            ['232308006', 'Fira Amelia', '12 Animasi', 'P'],
            ['232308007', 'Gerry Mahendra', '12 Animasi', 'L'],
            ['232308008', 'Hilda Permata', '12 Animasi', 'P'],
            ['232308009', 'Ivan Saputra', '12 Animasi', 'L'],
            ['232308010', 'Jasmine Putri', '12 Animasi', 'P'],
            ['232308011', 'Kevin Ardiansyah', '12 Animasi', 'L'],
            ['232308012', 'Lala Sari', '12 Animasi', 'P'],
            ['232308013', 'Miko Ramadhan', '12 Animasi', 'L'],
            ['232308014', 'Naya Indira', '12 Animasi', 'P'],
            ['232308015', 'Oscar Pratama', '12 Animasi', 'L']
        ];

        foreach ($siswaData as $data) {
            $kelas = DB::table('kelas')->where('nama_kelas', $data[2])->first();
            
            if (!$kelas) {
                echo "Warning: Kelas '{$data[2]}' not found for student {$data[1]}\n";
                continue;
            }
            
            DB::table('siswa')->insert([
                'nis' => $data[0],
                'nama_siswa' => $data[1],
                'kelas_id' => $kelas->id,
                'jenis_kelamin' => $data[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}