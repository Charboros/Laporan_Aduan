<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Aduan::with('petugas');

        if ($request->filled('status')) {
            $status = $request->status === 'sudah' ? true : false;
            $query->where('sudah_direspon', $status);
        }
        if ($request->filled('kanal')) {
            $query->where('kanal', $request->kanal);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_aduan', $request->tahun);
        }

        $aduans = $query->orderBy('tanggal_aduan', 'desc')->get();
        $listKanal = \App\Http\Controllers\AduanController::listKanal();
        $listTahun = Aduan::daftarTahun()->pluck('tahun');

        return view('laporan.index', compact('aduans', 'listKanal', 'listTahun'));
    }
}
