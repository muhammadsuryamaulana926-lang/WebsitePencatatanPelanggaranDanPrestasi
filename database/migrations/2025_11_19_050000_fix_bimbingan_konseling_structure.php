<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('bimbingan_konseling');
        
        Schema::create('bimbingan_konseling', function (Blueprint $table) {
            $table->id('bk_id');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('guru_konselor')->constrained('guru')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran')->onDelete('set null');
            $table->enum('jenis_layanan', ['konseling_individual', 'konseling_kelompok', 'bimbingan_klasikal', 'konsultasi']);
            $table->string('topik');
            $table->text('keluhan_masalah');
            $table->text('tindakan_solusi');
            $table->enum('status', ['terjadwal', 'berlangsung', 'selesai']);
            $table->date('tanggal_konseling');
            $table->date('tanggal_tindak_lanjut')->nullable();
            $table->text('hasil_evaluasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan_konseling');
    }
};