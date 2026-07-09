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
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Input Aduan (form)
    Route::get('/aduan/input', [AduanController::class, 'create'])->name('aduan.create');
    Route::post('/aduan/input', [AduanController::class, 'store'])->name('aduan.store');

    // Data Aduan (daftar + respon inline)
    Route::get('/aduan/data', [AduanController::class, 'data'])->name('aduan.data');

    // Detail Aduan (read-only)
    Route::get('/aduan/{aduan}', [AduanController::class, 'show'])->name('aduan.show');

    // Hapus Aduan (admin only)
    Route::delete('/aduan/{aduan}', [AduanController::class, 'destroy'])->name('aduan.destroy');

    // Respon Aduan
    Route::post('/aduan/{aduan}/respon', [ResponAduanController::class, 'store'])->name('aduan.respon.store');

    // Rekap / Laporan
    Route::get('/rekap', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/rekap/export', [AduanController::class, 'export'])->name('aduan.export');
});

require __DIR__ . '/auth.php';
