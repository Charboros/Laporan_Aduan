<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Exports\AduanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AduanController extends Controller
{
    public static function listKanal(): array
    {
        return ['Instagram', 'Facebook', 'Google Review', 'WhatsApp', 'Langsung', 'Lainnya'];
    }

    public static function listKlasifikasi(): array
    {
        return ['Akta', 'KK', 'KTP', 'Infrastruktur', 'SDM', 'Pelayanan', 'Lainnya'];
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'petugas') {
            $aduans = Aduan::where('created_by', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            $aduans = Aduan::orderBy('created_at', 'desc')->get();
        }

        return view('aduan.index', compact('aduans'));
    }

    public function create()
    {
        $listKanal       = self::listKanal();
        $listKlasifikasi = self::listKlasifikasi();
        return view('aduan.create', compact('listKanal', 'listKlasifikasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor'    => 'required|string|max:255',
            'kontak_pelapor'  => 'nullable|string',
            'kanal'           => 'required|string',
            'klasifikasi'     => 'required|string',
            'nama_akun'       => 'nullable|string|max:255',
            'isi_aduan'       => 'required|string',
            'tanggal_aduan'   => 'required|date',
            'screenshot'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sudah_direspon'  => 'nullable|boolean',
            'isi_respon_awal' => 'nullable|string',
        ]);

        $lastAduan  = Aduan::latest()->first();
        $nextId     = $lastAduan ? $lastAduan->id + 1 : 1;
        $nomorAduan = 'ADU-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
        }

        Aduan::create([
            'nomor_aduan'     => $nomorAduan,
            'nama_pelapor'    => $request->nama_pelapor,
            'kontak_pelapor'  => $request->kontak_pelapor,
            'kanal'           => $request->kanal,
            'klasifikasi'     => $request->klasifikasi,
            'nama_akun'       => $request->nama_akun,
            'isi_aduan'       => $request->isi_aduan,
            'tanggal_aduan'   => $request->tanggal_aduan,
            'screenshot_path' => $screenshotPath,
            'sudah_direspon'  => $request->boolean('sudah_direspon'),
            'isi_respon_awal' => $request->isi_respon_awal,
            'created_by'      => Auth::id(),
        ]);

        return redirect()->route('aduan.index')->with('success', 'Aduan berhasil ditambahkan');
    }

    public function show(Aduan $aduan)
    {
        return view('aduan.show', compact('aduan'));
    }

    public function edit(Aduan $aduan)
    {
        $listKanal       = self::listKanal();
        $listKlasifikasi = self::listKlasifikasi();
        return view('aduan.edit', compact('aduan', 'listKanal', 'listKlasifikasi'));
    }

    public function update(Request $request, Aduan $aduan)
    {
        $request->validate([
            'nama_pelapor'    => 'required|string|max:255',
            'kontak_pelapor'  => 'nullable|string',
            'kanal'           => 'required|string',
            'klasifikasi'     => 'required|string',
            'nama_akun'       => 'nullable|string|max:255',
            'isi_aduan'       => 'required|string',
            'tanggal_aduan'   => 'required|date',
            'screenshot'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sudah_direspon'  => 'nullable|boolean',
            'isi_respon_awal' => 'nullable|string',
        ]);

        $screenshotPath = $aduan->screenshot_path;
        if ($request->hasFile('screenshot')) {
            if ($screenshotPath) {
                Storage::disk('public')->delete($screenshotPath);
            }
            $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
        }

        $aduan->update([
            'nama_pelapor'    => $request->nama_pelapor,
            'kontak_pelapor'  => $request->kontak_pelapor,
            'kanal'           => $request->kanal,
            'klasifikasi'     => $request->klasifikasi,
            'nama_akun'       => $request->nama_akun,
            'isi_aduan'       => $request->isi_aduan,
            'tanggal_aduan'   => $request->tanggal_aduan,
            'screenshot_path' => $screenshotPath,
            'sudah_direspon'  => $request->boolean('sudah_direspon'),
            'isi_respon_awal' => $request->isi_respon_awal,
        ]);

        return redirect()->route('aduan.index')->with('success', 'Aduan berhasil diupdate');
    }

    public function destroy(Aduan $aduan)
    {
        if ($aduan->screenshot_path) {
            Storage::disk('public')->delete($aduan->screenshot_path);
        }
        $aduan->delete();
        return redirect()->route('aduan.index')->with('success', 'Aduan berhasil dihapus');
    }

    public function export()
    {
        $filename = 'Laporan_Aduan_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new AduanExport(), $filename);
    }
}
