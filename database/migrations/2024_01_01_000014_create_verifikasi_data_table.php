<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_data', function (Blueprint $table) {
            $table->id();
            $table->string('tabel_terkait', 50);
            $table->integer('id_terkait');
            $table->foreignId('guru_verifikator')->constrained('guru')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'diverifikasi', 'ditolak', 'revisi'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_data');
    }
};