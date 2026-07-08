<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'petugas') {
            $totalAduan         = Aduan::where('created_by', $user->id)->count();
            $aduanBelumDirespon = Aduan::where('created_by', $user->id)->where('sudah_direspon', false)->count();
            $aduanSudahDirespon = Aduan::where('created_by', $user->id)->where('sudah_direspon', true)->count();
        } else {
            $totalAduan         = Aduan::count();
            $aduanBelumDirespon = Aduan::where('sudah_direspon', false)->count();
            $aduanSudahDirespon = Aduan::where('sudah_direspon', true)->count();
        }

        return view('dashboard', compact('totalAduan', 'aduanBelumDirespon', 'aduanSudahDirespon'));
    }
}
