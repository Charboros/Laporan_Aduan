<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ── Filter tahun ──────────────────────────────────────────
        $tahunDipilih = (int) $request->get('tahun', date('Y'));

        $daftarTahun = Aduan::daftarTahun()->pluck('tahun')->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [(int) date('Y')];
        }

        // ── Statistik keseluruhan ─────────────────────────────────
        $totalAduan         = Aduan::count();
        $totalSudahDirespon = Aduan::where('sudah_direspon', true)->count();
        $totalBelumDirespon = Aduan::where('sudah_direspon', false)->count();

        // ── Statistik tahun yang dipilih ──────────────────────────
        $totalTahunIni         = Aduan::whereYear('tanggal_aduan', $tahunDipilih)->count();
        $sudahDiresponTahunIni = Aduan::whereYear('tanggal_aduan', $tahunDipilih)->where('sudah_direspon', true)->count();
        $belumDiresponTahunIni = Aduan::whereYear('tanggal_aduan', $tahunDipilih)->where('sudah_direspon', false)->count();

        // ── Per kanal & klasifikasi ───────────────────────────────
        $perKanal       = Aduan::perKanal($tahunDipilih)->get();
        $perKlasifikasi = Aduan::perKlasifikasi($tahunDipilih)->get();

        // ── Per bulan (12 bulan penuh) ────────────────────────────
        $dataBulan = Aduan::dataBulanFormatted(Aduan::query(), $tahunDipilih);

        // ── Tren tahunan ──────────────────────────────────────────
        $trenTahunan = Aduan::trenTahunan()->get();

        return view('laporan.index', compact(
            'totalAduan',
            'totalSudahDirespon',
            'totalBelumDirespon',
            'perKanal',
            'perKlasifikasi',
            'dataBulan',
            'trenTahunan',
            'daftarTahun',
            'tahunDipilih',
            'totalTahunIni',
            'sudahDiresponTahunIni',
            'belumDiresponTahunIni',
        ));
    }
}
