<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * 🔹 Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * 🔹 Proses login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika user nonaktif, langsung logout
            if (Auth::user()->status === 'nonaktif') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif.'
                ]);
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * 🔹 Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }

    /**
     * 🔹 Tampilkan halaman registrasi
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * 🔹 Proses registrasi pengguna baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ]);

        // Simpan user baru
        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',    // otomatis role user
            'status' => 'aktif', // otomatis aktif
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
