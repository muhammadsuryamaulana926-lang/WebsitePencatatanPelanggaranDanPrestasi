<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data siswa
        $siswaList = DB::table('siswa')->get();
        
        foreach ($siswaList as $siswa) {
            // Cek apakah user sudah ada
            $existingUser = DB::table('users')->where('username', $siswa->nis)->first();
            
            if (!$existingUser) {
                DB::table('users')->insert([
                    'username' => $siswa->nis,
                    'password' => Hash::make($siswa->nis), // Password = NIS
                    'level' => 'siswa',
                    'can_verify' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}