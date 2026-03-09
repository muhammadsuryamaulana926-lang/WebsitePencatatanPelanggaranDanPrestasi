<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrangtuaBaruSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        
        $namaAyah = [
            'Budi Santoso', 'Agus Wijaya', 'Hendra Gunawan', 'Dedi Kurniawan', 'Eko Prasetyo',
            'Fajar Nugroho', 'Gilang Ramadhan', 'Hadi Saputra', 'Irfan Maulana', 'Joko Susilo',
            'Krisna Bayu', 'Lukman Hakim', 'Maman Suherman', 'Nico Pratama', 'Omar Fadhil',
            'Pandu Wicaksono', 'Rudi Hartono', 'Slamet Riyadi', 'Tono Sugiarto', 'Usman Efendi'
        ];
        
        $namaIbu = [
            'Siti Nurhaliza', 'Dewi Lestari', 'Rina Marlina', 'Fitri Handayani', 'Gita Safitri',
            'Hesti Wulandari', 'Intan Permata', 'Jelita Sari', 'Kartika Dewi', 'Lina Rahayu',
            'Mella Widya', 'Nadia Putri', 'Olivia Rahma', 'Putri Ayu', 'Rina Susanti',
            'Sri Wahyuni', 'Tuti Alawiyah', 'Umi Kalsum', 'Vina Amelia', 'Wati Suryani'
        ];
        
        $pekerjaan = [
            'Pegawai Swasta', 'Wiraswasta', 'Guru', 'Dokter', 'Pedagang', 'Petani', 'Buruh',
            'PNS', 'TNI/Polri', 'Ibu Rumah Tangga', 'Karyawan', 'Sopir', 'Tukang', 'Pensiunan'
        ];
        
        $pendidikan = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        
        $counter = 0;
        
        foreach ($siswa as $s) {
            $namaAyahOrtu = $namaAyah[$counter % count($namaAyah)];
            $namaIbuOrtu = $namaIbu[$counter % count($namaIbu)];
            
            // Cek apakah data orangtua untuk siswa ini sudah ada
            $existingOrtu = DB::table('orangtua')->where('siswa_id', $s->id)->first();
            
            if (!$existingOrtu) {
                // Buat user untuk ayah dengan username ortu_[NIS]
                $usernameAyah = 'ortu_' . $s->nis;
                $existingUserAyah = DB::table('users')->where('username', $usernameAyah)->first();
                
                if (!$existingUserAyah) {
                    $userAyahId = DB::table('users')->insertGetId([
                        'username' => $usernameAyah,
                        'password' => Hash::make($s->nis),
                        'level' => 'ortu',
                        'can_verify' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $userAyahId = $existingUserAyah->id;
                }
                
                // Data ayah
                DB::table('orangtua')->insert([
                    'user_id' => $userAyahId,
                    'siswa_id' => $s->id,
                    'hubungan' => 'ayah',
                    'nama_orangtua' => $namaAyahOrtu,
                    'pekerjaan' => $pekerjaan[$counter % count($pekerjaan)],
                    'pendidikan' => $pendidikan[$counter % count($pendidikan)],
                    'no_telp' => '0812345' . str_pad($counter + 1, 5, '0', STR_PAD_LEFT),
                    'alamat' => 'Jl. Merdeka No. ' . ($counter + 1) . ', Jakarta',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Data ibu (menggunakan user_id yang sama dengan ayah)
                DB::table('orangtua')->insert([
                    'user_id' => $userAyahId,
                    'siswa_id' => $s->id,
                    'hubungan' => 'ibu',
                    'nama_orangtua' => $namaIbuOrtu,
                    'pekerjaan' => $pekerjaan[($counter + 5) % count($pekerjaan)],
                    'pendidikan' => $pendidikan[($counter + 2) % count($pendidikan)],
                    'no_telp' => '0813456' . str_pad($counter + 1, 5, '0', STR_PAD_LEFT),
                    'alamat' => 'Jl. Merdeka No. ' . ($counter + 1) . ', Jakarta',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            $counter++;
        }
    }
}