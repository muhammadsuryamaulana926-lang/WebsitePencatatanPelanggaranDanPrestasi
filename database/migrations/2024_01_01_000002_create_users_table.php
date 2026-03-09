<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->nullable()->constrained('guru')->onDelete('set null');
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('level', ['admin', 'guru', 'siswa', 'bk', 'kepalasekolah', 'walikelas', 'ortu', 'kesiswaan']);
            $table->boolean('can_verify')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};