<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'level' => 'required'
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            
            if ($user->level !== $credentials['level']) {
                Auth::logout();
                return back()->withErrors([
                    'level' => 'Level yang dipilih tidak sesuai dengan akun Anda.',
                ]);
            }
            
            $request->session()->regenerate();
            
            switch ($user->level) {
                case 'admin':
                    return redirect()->intended('/admin');
                case 'guru':
                    return redirect()->intended('/guru');
                case 'bk':
                    return redirect()->intended('/bk');
                case 'walikelas':
                    return redirect()->intended('/walikelas');
                case 'kepalasekolah':
                    return redirect()->intended('/kepalasekolah');
                case 'ortu':
                    return redirect()->intended('/ortu');
                case 'kesiswaan':
                    return redirect()->intended('/kesiswaan');
                case 'siswa':
                    return redirect()->intended('/siswa');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password tidak sesuai.',
        ]);
    }

    public function loginSiswa()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        return view('login-siswa', compact('siswa'));
    }

    public function loginSiswaSubmit(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Debug: cek apakah user ada
        $user = \App\Models\User::where('username', $credentials['username'])->first();
        
        if (!$user) {
            return back()->withErrors([
                'username' => 'User tidak ditemukan. Username: ' . $credentials['username'],
            ]);
        }
        
        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ]);
        }
        
        if ($user->level !== 'siswa') {
            return back()->withErrors([
                'username' => 'Akun ini bukan akun siswa.',
            ]);
        }
        
        Auth::login($user);
        $request->session()->regenerate();
        return redirect('/siswa');
    }

    public function loginOrtu()
    {
        $orangtua = \App\Models\Orangtua::with('siswa')->orderBy('nama_orangtua')->get();
        return view('login-ortu', compact('orangtua'));
    }

    public function loginOrtuSubmit(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('username', $credentials['username'])->first();
        
        if (!$user) {
            return back()->withErrors([
                'username' => 'User tidak ditemukan.',
            ]);
        }
        
        if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ]);
        }
        
        if ($user->level !== 'ortu') {
            return back()->withErrors([
                'username' => 'Akun ini bukan akun orang tua.',
            ]);
        }
        
        Auth::login($user);
        $request->session()->regenerate();
        return redirect('/ortu');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}