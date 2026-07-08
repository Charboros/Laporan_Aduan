<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query sesuai role (petugas hanya data miliknya sendiri)
        $base = Aduan::forUser($user);

        // ── Statistik keseluruhan ─────────────────────────────────
        $totalAduan         = (clone $base)->count();
        $aduanSudahDirespon = (clone $base)->where('sudah_direspon', true)->count();
        $aduanBelumDirespon = (clone $base)->where('sudah_direspon', false)->count();

        // ── Filter tahun ──────────────────────────────────────────
        $tahunDipilih = (int) $request->get('tahun', date('Y'));

        $daftarTahun = (clone $base)->daftarTahun()->pluck('tahun')->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [(int) date('Y')];
        }

        // ── Statistik tahun yang dipilih ──────────────────────────
        $totalTahunIni         = (clone $base)->whereYear('tanggal_aduan', $tahunDipilih)->count();
        $sudahDiresponTahunIni = (clone $base)->whereYear('tanggal_aduan', $tahunDipilih)->where('sudah_direspon', true)->count();
        $belumDiresponTahunIni = (clone $base)->whereYear('tanggal_aduan', $tahunDipilih)->where('sudah_direspon', false)->count();

        // ── Per kanal & klasifikasi ───────────────────────────────
        $perKanal      = (clone $base)->perKanal($tahunDipilih)->get();
        $perKlasifikasi = (clone $base)->perKlasifikasi($tahunDipilih)->get();

        // ── Per bulan (12 bulan penuh) ────────────────────────────
        $dataBulan = Aduan::dataBulanFormatted(clone $base, $tahunDipilih);

        // ── Tren tahunan ──────────────────────────────────────────
        $trenTahunan = (clone $base)->trenTahunan()->get();

        return view('dashboard', compact(
            'totalAduan',
            'aduanSudahDirespon',
            'aduanBelumDirespon',
            'tahunDipilih',
            'daftarTahun',
            'totalTahunIni',
            'sudahDiresponTahunIni',
            'belumDiresponTahunIni',
            'perKanal',
            'perKlasifikasi',
            'dataBulan',
            'trenTahunan',
        ));
    }
}
