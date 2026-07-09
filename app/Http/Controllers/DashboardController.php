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
        $statsGlobal = (clone $base)->selectRaw('
            count(*) as total,
            sum(case when sudah_direspon = 1 then 1 else 0 end) as sudah,
            sum(case when sudah_direspon = 0 then 1 else 0 end) as belum
        ')->first();

        $totalAduan         = (int) ($statsGlobal->total ?? 0);
        $aduanSudahDirespon = (int) ($statsGlobal->sudah ?? 0);
        $aduanBelumDirespon = (int) ($statsGlobal->belum ?? 0);

        // ── Filter tahun ──────────────────────────────────────────
        $tahunDipilih = (int) $request->get('tahun', date('Y'));

        $daftarTahun = (clone $base)->daftarTahun()->pluck('tahun')->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [(int) date('Y')];
        }

        // ── Statistik tahun yang dipilih ──────────────────────────
        $statsTahunIni = (clone $base)->inYear($tahunDipilih)->selectRaw('
            count(*) as total,
            sum(case when sudah_direspon = 1 then 1 else 0 end) as sudah,
            sum(case when sudah_direspon = 0 then 1 else 0 end) as belum
        ')->first();

        $totalTahunIni         = (int) ($statsTahunIni->total ?? 0);
        $sudahDiresponTahunIni = (int) ($statsTahunIni->sudah ?? 0);
        $belumDiresponTahunIni = (int) ($statsTahunIni->belum ?? 0);

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
