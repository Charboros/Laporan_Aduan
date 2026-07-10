<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\ResponAduanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // ------------------------------------------------------------------
    // A. Halaman Dashboard
    // ------------------------------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ------------------------------------------------------------------
    // B. Manajemen Aduan (Laporan Baru & Data Laporan)
    // ------------------------------------------------------------------
    
    // Menampilkan halaman form untuk membuat aduan baru
    Route::get('/aduan/input', [AduanController::class, 'create'])->name('aduan.create');
    // Menyimpan data aduan baru dari form ke database
    Route::post('/aduan/input', [AduanController::class, 'store'])->name('aduan.store');

    // Menampilkan halaman tabel/daftar aduan (bisa difilter)
    Route::get('/aduan/data', [AduanController::class, 'data'])->name('aduan.data');

    // Menampilkan halaman detail spesifik untuk satu aduan (read-only)
    Route::get('/aduan/{aduan}', [AduanController::class, 'show'])->name('aduan.show');

    // Menghapus aduan dari database (Hanya boleh diakses oleh Admin)
    Route::delete('/aduan/{aduan}', [AduanController::class, 'destroy'])->name('aduan.destroy');

    // ------------------------------------------------------------------
    // C. Manajemen Respon / Tanggapan
    // ------------------------------------------------------------------
    // Menyimpan respon dari petugas/admin untuk suatu aduan
    Route::post('/aduan/{aduan}/respon', [ResponAduanController::class, 'store'])->name('aduan.respon.store');

    // ------------------------------------------------------------------
    // D. Laporan / Rekapitulasi Data
    // ------------------------------------------------------------------
    // Menampilkan halaman laporan untuk rekap
    Route::get('/rekap', [LaporanController::class, 'index'])->name('laporan.index');
    // Mengunduh / export data aduan ke dalam format Excel
    Route::get('/rekap/export', [AduanController::class, 'export'])->name('aduan.export');
});

require __DIR__ . '/auth.php';
