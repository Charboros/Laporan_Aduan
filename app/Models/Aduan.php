<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Aduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_aduan',
        'nama_pelapor',
        'kontak_pelapor',
        'isi_aduan',
        'kanal',
        'klasifikasi',
        'nama_akun',
        'screenshot_path',
        'sudah_direspon',
        'isi_respon_awal',
        'tanggal_aduan',
        'created_by',
    ];

    protected $casts = [
        'sudah_direspon' => 'boolean',
        'tanggal_aduan'  => 'date',
    ];

    // =========================================================
    // Relationships
    // =========================================================

    public function petugas()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function respon()
    {
        return $this->hasMany(ResponAduan::class);
    }

    // =========================================================
    // Query Scopes
    // =========================================================

    /**
     * Filter aduan berdasarkan role user.
     * Petugas hanya melihat aduan yang ia buat sendiri.
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->role === 'petugas') {
            return $query->where('created_by', $user->id);
        }

        return $query;
    }

    /**
     * Statistik per kanal untuk tahun tertentu.
     */
    public function scopePerKanal(Builder $query, int $tahun): Builder
    {
        return $query
            ->selectRaw('COALESCE(kanal, "Tidak Diketahui") as kanal, COUNT(*) as jumlah')
            ->whereYear('tanggal_aduan', $tahun)
            ->groupBy('kanal')
            ->orderBy('jumlah', 'desc');
    }

    /**
     * Statistik per klasifikasi untuk tahun tertentu.
     */
    public function scopePerKlasifikasi(Builder $query, int $tahun): Builder
    {
        return $query
            ->selectRaw('COALESCE(klasifikasi, "Tidak Diketahui") as klasifikasi, COUNT(*) as jumlah')
            ->whereYear('tanggal_aduan', $tahun)
            ->groupBy('klasifikasi')
            ->orderBy('jumlah', 'desc');
    }

    /**
     * Statistik per bulan (sudah diformat ke 12 bulan penuh) untuk tahun tertentu.
     * Mengembalikan array [['bulan' => 'Jan', 'jumlah' => 5], ...]
     */
    public static function dataBulanFormatted(Builder $query, int $tahun): array
    {
        $raw = (clone $query)
            ->selectRaw('MONTH(tanggal_aduan) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_aduan', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4  => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8  => 'Agt',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $result = [];
        for ($b = 1; $b <= 12; $b++) {
            $result[] = [
                'bulan'  => $namaBulan[$b],
                'jumlah' => isset($raw[$b]) ? (int) $raw[$b]->jumlah : 0,
            ];
        }

        return $result;
    }

    /**
     * Tren jumlah aduan per tahun.
     */
    public function scopeTrenTahunan(Builder $query): Builder
    {
        return $query
            ->selectRaw('YEAR(tanggal_aduan) as tahun, COUNT(*) as jumlah')
            ->whereNotNull('tanggal_aduan')
            ->groupBy('tahun')
            ->orderBy('tahun');
    }

    /**
     * Daftar tahun yang tersedia.
     */
    public function scopeDaftarTahun(Builder $query): Builder
    {
        return $query
            ->selectRaw('YEAR(tanggal_aduan) as tahun')
            ->distinct()
            ->whereNotNull('tanggal_aduan')
            ->orderBy('tahun', 'desc');
    }
}
