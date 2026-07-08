<?php

namespace App\Http\Controllers;

use App\Models\ResponAduan;
use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponAduanController extends Controller
{
    public function store(Request $request, Aduan $aduan)
    {
        // Hanya kepala_bidang yang boleh merespon
        if (Auth::user()->role !== 'kepala_bidang') {
            abort(403, 'Hanya Kepala Bidang yang dapat memberikan respon.');
        }

        $request->validate([
            'isi_respon'     => 'required|string',
            'sudah_direspon' => 'required|in:0,1',
        ]);

        ResponAduan::create([
            'aduan_id'       => $aduan->id,
            'isi_respon'     => $request->isi_respon,
            'tanggal_respon' => date('Y-m-d'),
            'respon_by'      => Auth::id(),
        ]);

        // Update status sudah_direspon pada aduan
        $aduan->update([
            'sudah_direspon'  => (bool) $request->sudah_direspon,
            'isi_respon_awal' => $request->isi_respon,
        ]);

        return redirect()->route('aduan.show', $aduan->id)->with('success', 'Tanggapan berhasil diberikan');
    }
}
