<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserOrtuNisSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua siswa dari database
        $siswa = DB::table('siswa')->get();
        
        foreach ($siswa as $s) {
            // Username format: ortu_[NIS]
            $usernameOrtu = 'ortu_' . $s->nis;
            
            // Cek apakah user sudah ada
            $existingUser = DB::table('users')->where('username', $usernameOrtu)->first();
            
            if (!$existingUser) {
                // Buat user orang tua dengan username = ortu_NIS
                DB::table('users')->insert([
                    'username' => $usernameOrtu,
                    'password' => Hash::make($s->nis), // Password = NIS
                    'level' => 'ortu',
                    'can_verify' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                echo "Created ortu user: {$usernameOrtu}\n";
            }
        }
    }
}