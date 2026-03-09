<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sanksi_id')->constrained('sanksi')->onDelete('cascade');
            $table->date('tanggal_pelaksanaan');
            $table->string('bukti')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['terjadwal', 'dikerjakan', 'tuntas', 'terlambat', 'perpanjangan'])->default('terjadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_sanksi');
    }
};