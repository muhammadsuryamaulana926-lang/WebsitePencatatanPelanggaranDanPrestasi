<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran')->onDelete('cascade');
            $table->foreignId('guru_kepsek')->nullable()->constrained('guru')->onDelete('set null');
            $table->text('catatan')->nullable();
            $table->enum('status', ['dipantau', 'dalam_tindakan', 'selesai'])->default('dipantau');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_pelanggaran');
    }
};