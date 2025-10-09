<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user();
        return view('pengaturan.profil', compact('user'));
    }

    /**
     * Update profil pengguna
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update nama
        $user->name = $request->name;

        // Jika user ingin ganti password
        if ($request->filled('current_password') || $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Nonaktifkan akun
     */
    public function deactivate(Request $request)
    {
        $user = Auth::user();
        $user->status = 'nonaktif'; // pastikan kolom `status` ada di tabel users
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah dinonaktifkan.');
    }
}
