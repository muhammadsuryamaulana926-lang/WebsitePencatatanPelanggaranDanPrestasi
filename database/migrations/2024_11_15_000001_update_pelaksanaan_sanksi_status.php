<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->enum('status', ['terjadwal', 'dikerjakan', 'tuntas', 'terlambat', 'perpanjangan'])->default('terjadwal');
        });
    }

    public function down(): void
    {
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->enum('status', ['belum_diverifikasi', 'disetujui', 'ditolak'])->default('belum_diverifikasi');
        });
    }
};