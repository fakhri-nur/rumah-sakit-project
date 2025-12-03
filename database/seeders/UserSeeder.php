<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
        ]);

        $dokter2 = User::create([
            'name' => 'Dokter 2',
            'email' => 'dokter2@gmail.com',
            'password' => Hash::make('dokter1234'),
            'role' => 'dokter',
            'photo' => 'doctor1.jpg',
            'specialty' => 'Umum',
        ]);

        \App\Models\Dokter::create([
            'user_id' => $dokter2->id,
            'photo' => 'doctor1.jpg',
            'specialty' => 'Umum',
        ]);

        $dokter3 = User::create([
            'name' => 'Dokter 3',
            'email' => 'dokter3@gmail.com',
            'password' => Hash::make('dokter1234'),
            'role' => 'dokter',
            'photo' => 'doctor2.jpg',
            'specialty' => 'Spesialis',
        ]);

        \App\Models\Dokter::create([
            'user_id' => $dokter3->id,
            'photo' => 'doctor2.jpg',
            'specialty' => 'Spesialis',
        ]);

    }
}
