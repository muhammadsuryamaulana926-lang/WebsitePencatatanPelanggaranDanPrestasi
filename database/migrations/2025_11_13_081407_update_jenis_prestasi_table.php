<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jenis_prestasi', function (Blueprint $table) {
            // Ubah enum kategori untuk menambah opsi baru
            $table->dropColumn('kategori');
        });
        
        Schema::table('jenis_prestasi', function (Blueprint $table) {
            $table->enum('kategori', ['akademik', 'non_akademik', 'olahraga', 'seni'])->after('poin');
            
            // Ubah penghargaan menjadi deskripsi jika ada
            if (Schema::hasColumn('jenis_prestasi', 'penghargaan')) {
                $table->renameColumn('penghargaan', 'deskripsi');
            } else {
                $table->text('deskripsi')->nullable()->after('kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_prestasi', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
        
        Schema::table('jenis_prestasi', function (Blueprint $table) {
            $table->enum('kategori', ['akademik', 'nonakademik', 'lainnya'])->after('poin');
            
            if (Schema::hasColumn('jenis_prestasi', 'deskripsi')) {
                $table->renameColumn('deskripsi', 'penghargaan');
            }
        });
    }
};
