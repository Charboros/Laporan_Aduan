<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// ------------------------------------------------------------------
// Rute untuk Pengunjung (Belum Login)
// ------------------------------------------------------------------
// Middleware 'guest' memastikan rute di bawah ini hanya bisa diakses 
// oleh pengguna yang belum login ke dalam sistem.
Route::middleware('guest')->group(function () {
    // Menampilkan halaman formulir login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    
    // Memproses data yang dikirim dari form login (cek email & password)
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ------------------------------------------------------------------
// Rute untuk Pengguna Terdaftar (Sudah Login)
// ------------------------------------------------------------------
// Middleware 'auth' memastikan rute di bawah ini HANYA bisa diakses 
// oleh pengguna yang sudah memiliki sesi login aktif.
Route::middleware('auth')->group(function () {
    // Menghapus sesi login pengguna (proses logout)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
