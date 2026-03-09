<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bimbingan_konseling', function (Blueprint $table) {
            $table->enum('status_pengajuan', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan')->after('status');
            $table->text('alasan_penolakan')->nullable()->after('status_pengajuan');
        });
    }

    public function down(): void
    {
        Schema::table('bimbingan_konseling', function (Blueprint $table) {
            $table->dropColumn(['status_pengajuan', 'alasan_penolakan']);
        });
    }
};