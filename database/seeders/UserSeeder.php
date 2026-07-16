<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------------------------------------------------
        // Buat Akun Dasar untuk Sistem (Default Users)
        // ------------------------------------------------------------------

        // Akun 1: Admin (Akses Penuh)
        User::create([
            'name'     => 'Admin',
            'password' => Hash::make('12345678'), // Password harus di-hash (enkripsi)
            'role'     => 'admin',
        ]);

        // Akun 2: Petugas (Bisa membuat aduan dan melihat aduannya sendiri)
        User::create([
            'name'     => 'Petugas',
            'password' => Hash::make('12345678'),
            'role'     => 'petugas',
        ]);

        // Akun 3: Kadis
        User::create([
            'name'     => 'kadis',
            'password' => Hash::make('12345678'),
            'role'     => 'pimpinan',
        ]);

        // Akun 4: Kabid
        User::create([
            'name'     => 'kabid',
            'password' => Hash::make('12345678'),
            'role'     => 'pimpinan',
        ]);
    }
}