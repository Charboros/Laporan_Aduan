<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Aduan extends Model
{
    // Daftar kolom tabel `aduans` yang diizinkan untuk diisi secara massal (Mass Assignment)
    // Field yang tidak ada di sini tidak akan bisa disimpan via fungsi create()
    protected $fillable = [
        'nomor_aduan',
        'kanal',
        'klasifikasi',
        'nama_akun',
        'isi_aduan',
        'caption',
        'tanggal_aduan',
        'waktu_aduan',
        'screenshot_path',
        'sudah_direspon',
        'isi_respon_awal',
        'created_by',
    ];

    protected $casts = [
        'sudah_direspon' => 'boolean',
        'tanggal_aduan'  => 'date',
    ];

    // =========================================================
    // Helpers
    // =========================================================

    protected static function datePartExpression(string $part): string
    {
        $driver = app('db')->connection()->getDriverName();
        return match ($driver) {
            'sqlite' => $part === 'month'
                ? "strftime('%m', tanggal_aduan)"
                : "strftime('%Y', tanggal_aduan)",
            'pgsql' => $part === 'month'
                ? 'EXTRACT(MONTH FROM DATE(tanggal_aduan))'
                : 'EXTRACT(YEAR FROM DATE(tanggal_aduan))',
            default => $part === 'month' ? 'MONTH(tanggal_aduan)' : 'YEAR(tanggal_aduan)',
        };
    }

    // =========================================================
    // 1. Relasi Antar Tabel (Relationships)
    // =========================================================

    // Menghubungkan aduan ini ke tabel User (Petugas yang mencatat aduan)
    // 1 Aduan hanya dimiliki/dicatat oleh 1 Petugas (belongsTo)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Menghubungkan aduan ini ke tabel ResponAduan
    // 1 Aduan bisa memiliki banyak Respon (hasMany)
    public function respon()
    {
        return $this->hasMany(ResponAduan::class);
    }

    // =========================================================
    // 2. Query Scopes (Fungsi Bantuan Pencarian)
    // =========================================================
    // Scope mempermudah kita membuat kondisi pencarian yang sering dipakai
    // sehingga controller kita terlihat lebih rapi. (Ditandai dengan awalan 'scope')

    /** 
     * Membatasi agar akun petugas hanya melihat aduan yang ia input sendiri. 
     * Penggunaan di Controller: Aduan::forUser($user)
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->role === 'petugas') {
            return $query->where('created_by', $user->id);
        }
        // Jika bukan petugas (misal admin), jangan batasi datanya
        return $query;
    }

    public function scopePerKanal(Builder $query, int $tahun): Builder
    {
        return $query
            ->selectRaw('COALESCE(kanal, "Tidak Diketahui") as kanal, COUNT(*) as jumlah')
            ->whereRaw(sprintf('%s = ?', self::datePartExpression('year')), [$tahun])
            ->groupBy('kanal')
            ->orderBy('jumlah', 'desc');
    }

    public function scopePerKlasifikasi(Builder $query, int $tahun): Builder
    {
        return $query
            ->selectRaw('COALESCE(klasifikasi, "Tidak Diketahui") as klasifikasi, COUNT(*) as jumlah')
            ->whereRaw(sprintf('%s = ?', self::datePartExpression('year')), [$tahun])
            ->groupBy('klasifikasi')
            ->orderBy('jumlah', 'desc');
    }

    public static function dataBulanFormatted(Builder $query, int $tahun): array
    {
        $raw = (clone $query)
            ->selectRaw(sprintf('%s as bulan, COUNT(*) as jumlah', self::datePartExpression('month')))
            ->whereRaw(sprintf('%s = ?', self::datePartExpression('year')), [$tahun])
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

    public function scopeTrenTahunan(Builder $query): Builder
    {
        return $query
            ->selectRaw(sprintf('%s as tahun, COUNT(*) as jumlah', self::datePartExpression('year')))
            ->whereNotNull('tanggal_aduan')
            ->groupBy('tahun')
            ->orderBy('tahun');
    }

    public function scopeDaftarTahun(Builder $query): Builder
    {
        return $query
            ->selectRaw(sprintf('%s as tahun', self::datePartExpression('year')))
            ->distinct()
            ->whereNotNull('tanggal_aduan')
            ->orderBy('tahun', 'desc');
    }

    public function scopeInYear(Builder $query, int $year): Builder
    {
        return $query->whereRaw(sprintf('%s = ?', self::datePartExpression('year')), [$year]);
    }
}
