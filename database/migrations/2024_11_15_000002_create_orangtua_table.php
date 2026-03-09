<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orangtua', function (Blueprint $table) {
            $table->id('orangtua_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->enum('hubungan', ['ayah', 'ibu', 'wali']);
            $table->string('nama_orangtua', 100);
            $table->string('pekerjaan', 100)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};