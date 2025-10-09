<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Rute utama untuk tampilan berbasis Blade (publik & privat)
|--------------------------------------------------------------------------
*/


Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// 🌐 Halaman Awal (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 🏠 Dashboard Publik
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 📚 Halaman Jurnal Publik (view only)
Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');

// 🔑 Autentikasi Pengguna
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Rute Pengaturan (hanya bisa diakses setelah login)
Route::middleware('auth')->prefix('pengaturan')->group(function () {

    // 🧭 Halaman utama pengaturan
    Route::get('/', [PengaturanController::class, 'index'])->name('pengaturan.index');

    // 👤 Pengaturan Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('pengaturan.profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('pengaturan.profil.update');
    Route::post('/profil/nonaktif', [ProfilController::class, 'deactivate'])->name('pengaturan.profil.deactivate');

    // 🧩 Manajemen Bidang Ilmu
    Route::get('/bidang-ilmu', [PengaturanController::class, 'bidangIlmu'])->name('pengaturan.bidang-ilmu');
    Route::post('/bidang-ilmu', [PengaturanController::class, 'storeBidangIlmu'])->name('bidang-ilmu.store');
    Route::put('/bidang-ilmu/{id}', [PengaturanController::class, 'updateBidangIlmu'])->name('bidang-ilmu.update');
    Route::delete('/bidang-ilmu/{id}', [PengaturanController::class, 'destroyBidangIlmu'])->name('bidang-ilmu.destroy');

    // 📚 Manajemen Jurnal
    Route::get('/jurnal', [JurnalController::class, 'manage'])->name('pengaturan.jurnal');
    Route::post('/jurnal', [JurnalController::class, 'storeJurnal'])->name('pengaturan.jurnal.store');
    Route::put('/jurnal/{id}', [JurnalController::class, 'update'])->name('pengaturan.jurnal.update');
    Route::delete('/jurnal/{id}', [JurnalController::class, 'destroy'])->name('pengaturan.jurnal.destroy');

    // 👥 Manajemen Pengguna (khusus admin)
    Route::middleware('isAdmin')->group(function () {
        Route::get('/pengguna', [PengaturanController::class, 'pengguna'])->name('pengaturan.pengguna');
        Route::post('/pengguna/store', [PengaturanController::class, 'storePengguna'])->name('pengaturan.pengguna.store');
        Route::patch('/pengaturan/pengguna/{id}/nonaktifkan', [PengaturanController::class, 'nonaktifkan'])->name('pengaturan.nonaktifkan');
        Route::patch('/pengaturan/pengguna/{id}/aktifkan', [PengaturanController::class, 'aktifkan'])->name('pengaturan.aktifkan');
    });
});
