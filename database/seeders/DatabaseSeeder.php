<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $dokterUser = User::create([
            'name' => 'Dokter',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('dokter123'),
            'role' => 'dokter',
            'specialty' => 'Umum',
        ]);

        \App\Models\Dokter::create([
            'user_id' => $dokterUser->id,
            'specialty' => 'Umum',
        ]);
    }
}
