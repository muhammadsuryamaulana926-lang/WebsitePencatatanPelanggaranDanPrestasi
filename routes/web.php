<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// API routes untuk mobile atau test (opsional)
Route::get('/api/users/check-username/{username}', function ($username) {
    return response()->json(['exists' => \App\Models\User::where('username', $username)->exists()]);
});
