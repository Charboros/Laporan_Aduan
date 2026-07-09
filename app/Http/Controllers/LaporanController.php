<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $aduans = Aduan::with('petugas')
            ->orderBy('tanggal_aduan', 'desc')
            ->get();

        return view('laporan.index', compact('aduans'));
    }
}
