<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            if (!Schema::hasColumn('prestasi', 'tahun_ajaran_id')) {
                $table->unsignedBigInteger('tahun_ajaran_id')->after('jenis_prestasi_id')->default(1);
            }
        });
        
        // Update existing records to have a valid tahun_ajaran_id
        DB::statement('UPDATE prestasi SET tahun_ajaran_id = 1 WHERE tahun_ajaran_id IS NULL OR tahun_ajaran_id = 0');
        
        // Add foreign key constraint
        Schema::table('prestasi', function (Blueprint $table) {
            if (!Schema::hasColumn('prestasi', 'tahun_ajaran_id')) {
                return; // Column doesn't exist, skip
            }
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            if (Schema::hasColumn('prestasi', 'tahun_ajaran_id')) {
                $table->dropForeign(['tahun_ajaran_id']);
                $table->dropColumn('tahun_ajaran_id');
            }
        });
    }
};