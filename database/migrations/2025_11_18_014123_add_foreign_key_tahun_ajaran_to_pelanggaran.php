<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing records to have a valid tahun_ajaran_id
        DB::statement('UPDATE pelanggaran SET tahun_ajaran_id = 1 WHERE tahun_ajaran_id IS NULL OR tahun_ajaran_id = 0');
        
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggaran', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
        });
    }
};
