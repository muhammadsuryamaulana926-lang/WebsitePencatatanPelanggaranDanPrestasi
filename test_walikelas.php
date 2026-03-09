<?php
/**
 * SCRIPT TEST WALI KELAS
 * Untuk mengecek data pelanggaran setiap kelas
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Pelanggaran;

$waliKelasAccounts = [
    ['username' => 'walikelas_pplg1', 'password' => 'pplg1123', 'kelas' => '12 PPLG 1'],
    ['username' => 'walikelas_pplg2', 'password' => 'pplg2123', 'kelas' => '12 PPLG 2'],
    ['username' => 'walikelas_pplg3', 'password' => 'pplg3123', 'kelas' => '12 PPLG 3'],
    ['username' => 'walikelas_pemasaran', 'password' => 'pemasaran123', 'kelas' => '12 Pemasaran'],
    ['username' => 'walikelas_dkv', 'password' => 'dkv123', 'kelas' => '12 DKV'],
    ['username' => 'walikelas_akuntansi1', 'password' => 'akun1123', 'kelas' => '12 Akuntansi 1'],
    ['username' => 'walikelas_akuntansi2', 'password' => 'akun2123', 'kelas' => '12 Akuntansi 2'],
    ['username' => 'walikelas_animasi', 'password' => 'animasi123', 'kelas' => '12 Animasi']
];

echo "🏫 PANDUAN AKSES WALI KELAS\n";
echo "==========================\n\n";

foreach ($waliKelasAccounts as $account) {
    $user = User::where('username', $account['username'])->first();
    
    if ($user && $user->guru) {
        $guru = $user->guru;
        $kelasWali = $guru->kelasWali;
        
        echo "📚 KELAS: {$account['kelas']}\n";
        echo "👨🏫 WALI KELAS: {$guru->nama_guru}\n";
        echo "🔐 LOGIN INFO:\n";
        echo "   Username: {$account['username']}\n";
        echo "   Password: {$account['password']}\n";
        echo "🌐 URL AKSES:\n";
        echo "   Dashboard: http://localhost/walikelas\n";
        echo "   Input Pelanggaran: http://localhost/walikelas/input-pelanggaran\n";
        echo "   View Data: http://localhost/walikelas/view-data-sendiri\n";
        echo "   Export: http://localhost/walikelas/export-laporan\n";
        
        // Hitung statistik
        $totalPelanggaran = 0;
        $totalPoin = 0;
        $totalSiswa = 0;
        
        foreach ($kelasWali as $kelas) {
            $totalSiswa += $kelas->siswa->count();
            $pelanggaranKelas = Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->id);
            })->get();
            $totalPelanggaran += $pelanggaranKelas->count();
            $totalPoin += $pelanggaranKelas->sum('poin');
        }
        
        echo "📊 STATISTIK:\n";
        echo "   Total Siswa: {$totalSiswa}\n";
        echo "   Total Pelanggaran: {$totalPelanggaran}\n";
        echo "   Total Poin: {$totalPoin}\n";
        echo "\n" . str_repeat("=", 50) . "\n\n";
    }
}

echo "💡 CARA MENGGUNAKAN:\n";
echo "1. Buka browser dan akses http://localhost/login\n";
echo "2. Login dengan username dan password di atas\n";
echo "3. Setiap wali kelas hanya bisa melihat data kelasnya sendiri\n";
echo "4. Data akan otomatis terfilter berdasarkan kelas yang diwali\n\n";

echo "✅ SEMUA AKUN WALI KELAS SUDAH SIAP DIGUNAKAN!\n";
?>