<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter tahun (default: tahun sekarang)
        $tahunDipilih = $request->get('tahun', date('Y'));

        // Daftar tahun yang tersedia
        $daftarTahun = Aduan::selectRaw('YEAR(tanggal_aduan) as tahun')
            ->distinct()
            ->whereNotNull('tanggal_aduan')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [(int) date('Y')];
        }

        // === STATISTIK KESELURUHAN ===
        $totalAduan         = Aduan::count();
        $totalSudahDirespon = Aduan::where('sudah_direspon', true)->count();
        $totalBelumDirespon = Aduan::where('sudah_direspon', false)->count();

        // === PER TAHUN PER KANAL ===
        $perKanal = Aduan::selectRaw('COALESCE(kanal, "Tidak Diketahui") as kanal, COUNT(*) as jumlah')
            ->whereYear('tanggal_aduan', $tahunDipilih)
            ->groupBy('kanal')
            ->orderBy('jumlah', 'desc')
            ->get();

        // === PER TAHUN PER KLASIFIKASI ===
        $perKlasifikasi = Aduan::selectRaw('COALESCE(klasifikasi, "Tidak Diketahui") as klasifikasi, COUNT(*) as jumlah')
            ->whereYear('tanggal_aduan', $tahunDipilih)
            ->groupBy('klasifikasi')
            ->orderBy('jumlah', 'desc')
            ->get();

        // === PER BULAN (tahun yang dipilih) ===
        $perBulanRaw = Aduan::selectRaw('MONTH(tanggal_aduan) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_aduan', $tahunDipilih)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agt',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $dataBulan = [];
        for ($b = 1; $b <= 12; $b++) {
            $dataBulan[] = [
                'bulan'  => $namaBulan[$b],
                'jumlah' => isset($perBulanRaw[$b]) ? (int) $perBulanRaw[$b]->jumlah : 0,
            ];
        }

        // === TREN TAHUNAN ===
        $trenTahunan = Aduan::selectRaw('YEAR(tanggal_aduan) as tahun, COUNT(*) as jumlah')
            ->whereNotNull('tanggal_aduan')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Total aduan tahun yang dipilih
        $totalTahunIni = Aduan::whereYear('tanggal_aduan', $tahunDipilih)->count();
        $sudahDiresponTahunIni = Aduan::whereYear('tanggal_aduan', $tahunDipilih)->where('sudah_direspon', true)->count();
        $belumDiresponTahunIni = Aduan::whereYear('tanggal_aduan', $tahunDipilih)->where('sudah_direspon', false)->count();

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
            'belumDiresponTahunIni'
        ));
    }
}
