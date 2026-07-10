<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponAduan extends Model
{
    // Daftar field yang boleh diisi pada database
    protected $fillable = [
        'aduan_id',
        'isi_respon',
        'tanggal_respon',
        'respon_by',
    ];

    // =========================================================
    // Relasi Antar Tabel (Relationships)
    // =========================================================

    // Menghubungkan respon ini dengan tabel Aduan
    // 1 Respon hanya dimiliki oleh 1 Aduan
    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    // Menghubungkan respon ini dengan tabel User (Pemberi respon)
    // 1 Respon ditulis oleh 1 User (Petugas/Admin/Kabid)
    public function user()
    {
        return $this->belongsTo(User::class, 'respon_by');
    }
}
