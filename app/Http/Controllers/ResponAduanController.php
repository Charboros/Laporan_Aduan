<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\ResponAduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponAduanController extends Controller
{
    public function store(Request $request, Aduan $aduan)
    {
        $request->validate([
            'isi_respon' => 'required|string',
        ]);

        ResponAduan::create([
            'aduan_id'       => $aduan->id,
            'isi_respon'     => $request->isi_respon,
            'tanggal_respon' => date('Y-m-d'),
            'respon_by'      => Auth::id(),
        ]);

        $aduan->update([
            'sudah_direspon'  => true,
        ]);

        return back()->with('success', 'Respon untuk aduan ' . $aduan->nomor_aduan . ' berhasil dikirim.');
    }
}
