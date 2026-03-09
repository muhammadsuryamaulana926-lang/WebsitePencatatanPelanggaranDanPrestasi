<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = [
    'admin' => 'admin',
    'kesiswaan' => 'kesiswaan',
    'bk' => 'bk',
    'guru' => 'guru',
    'walikelas' => 'walikelas',
    'kepalasekolah' => 'kepalasekolah',
    'siswa' => 'siswa',
    'ortu' => 'ortu'
];

foreach ($users as $username => $level) {
    $user = \App\Models\User::where('username', $username)->first();
    if ($user) {
        $user->password = \Illuminate\Support\Facades\Hash::make('password');
        $user->save();
        echo "Updated $username\n";
    } else {
        \App\Models\User::create([
            'username' => $username,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'level' => $level
        ]);
        echo "Created $username\n";
    }
}
echo "All passwords set to 'password'\n";
