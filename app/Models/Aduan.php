<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_aduan',
        'nama_pelapor',
        'kontak_pelapor',
        'isi_aduan',
        'kategori',
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

    public function petugas()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function respon()
    {
        return $this->hasMany(ResponAduan::class);
    }
}
