<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change to VARCHAR first
        DB::statement("ALTER TABLE verifikasi_data MODIFY COLUMN status VARCHAR(20) DEFAULT 'menunggu'");
        
        // Update existing 'disetujui' to 'diverifikasi'
        DB::table('verifikasi_data')->where('status', 'disetujui')->update(['status' => 'diverifikasi']);
        
        // Change back to ENUM with new values
        DB::statement("ALTER TABLE verifikasi_data MODIFY COLUMN status ENUM('menunggu', 'diverifikasi', 'ditolak', 'revisi') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE verifikasi_data MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'ditolak') DEFAULT 'menunggu'");
    }
};