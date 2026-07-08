<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponAduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'aduan_id',
        'isi_respon',
        'tanggal_respon',
        'respon_by',
    ];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'respon_by');
    }
}
