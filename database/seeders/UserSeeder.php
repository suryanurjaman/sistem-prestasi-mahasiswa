<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // PASTIKAN ini User, bukan Pengguna

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin Sistem',
            'email' => 'admin@sistem.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Mahasiswa Satu',
            'email' => 'mahasiswa@mahasiswa.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
    }
}
