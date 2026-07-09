<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Petugas',
            'password' => Hash::make('password123'),
            'role'     => 'petugas',
        ]);

        User::create([
            'name'     => 'Kabid',
            'password' => Hash::make('password123'),
            'role'     => 'kabid',
        ]);
    }
}