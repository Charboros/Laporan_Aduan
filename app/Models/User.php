<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // =========================================================
    // Helpers
    // =========================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKabid(): bool
    {
        return $this->role === 'kabid';
    }

    // =========================================================
    // Relationships
    // =========================================================

    public function aduans()
    {
        return $this->hasMany(Aduan::class, 'created_by');
    }

    public function responAduans()
    {
        return $this->hasMany(ResponAduan::class, 'respon_by');
    }
}
