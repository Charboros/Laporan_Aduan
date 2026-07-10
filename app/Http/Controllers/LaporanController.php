<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ------------------------------------------------------------------
        // 1. Inisialisasi Query Dasar
        // ------------------------------------------------------------------
        // Ambil data aduan beserta relasi 'petugas'
        $query = Aduan::with('petugas');

        // ------------------------------------------------------------------
        // 2. Terapkan Filter Berdasarkan Input (Request)
        // ------------------------------------------------------------------
        
        // Filter status penyelesaian
        if ($request->filled('status')) {
            $isSudahDirespon = ($request->status === 'sudah') ? true : false;
            $query->where('sudah_direspon', $isSudahDirespon);
        }

        // Filter kanal pengaduan
        if ($request->filled('kanal')) {
            if ($request->kanal === 'Lainnya') {
                $query->where('kanal', 'like', 'Lainnya%');
            } else {
                $query->where('kanal', $request->kanal);
            }
        }

        // Filter tahun pengaduan
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_aduan', $request->tahun);
        }

        // ------------------------------------------------------------------
        // 3. Eksekusi Query
        // ------------------------------------------------------------------
        // Urutkan berdasarkan tanggal aduan paling baru
        $aduans = $query->orderBy('tanggal_aduan', 'desc')->get();
        $listKanal = \App\Http\Controllers\AduanController::listKanal();
        $listTahun = Aduan::daftarTahun()->pluck('tahun');

        return view('laporan.index', compact('aduans', 'listKanal', 'listTahun'));
    }
}
