<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingan_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('konselor_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->string('topik', 150);
            $table->text('tindakan')->nullable();
            $table->date('tanggal_bimbingan');
            $table->enum('status', ['terdaftar', 'diproses', 'selesai', 'tindak_lanjut'])->default('terdaftar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan_konseling');
    }
};