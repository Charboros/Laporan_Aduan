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

        // Akun 1: Admin
        User::create([
            'name'     => 'admin',
            'password' => Hash::make('admin3328'),
            'role'     => 'admin',
        ]);

        // Akun 2: Petugas
        User::create([
            'name'     => 'petugas',
            'password' => Hash::make('petugas3328'),
            'role'     => 'petugas',
        ]);

        // Akun 3: Kabid PIAK
        User::create([
            'name'     => 'kabid_piak',
            'password' => Hash::make('kabid33281'),
            'role'     => 'pimpinan',
        ]);

        // Akun 4: Kabid Capil
        User::create([
            'name'     => 'kabid_capil',
            'password' => Hash::make('kabid33282'),
            'role'     => 'pimpinan',
        ]);

        // Akun 5: Kabid Dafduk
        User::create([
            'name'     => 'kabid_dafduk',
            'password' => Hash::make('kabid33283'),
            'role'     => 'pimpinan',
        ]);

        // Akun 6: Kadis
        User::create([
            'name'     => 'kadis',
            'password' => Hash::make('kadis3328'),
            'role'     => 'pimpinan',
        ]);
    }
}