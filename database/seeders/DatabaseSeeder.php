<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $users = [
            [
                'id' => 2,
                'username' => 'siswa',
                'kelas' => 'XII RPL 2',
                'nis' => "0091991",
                'role' => 'student',
                'password' => Hash::make('siswa123'),
                'created_at' => '2024-01-01 08:00:01',
            ],
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => '2024-01-01 08:00:01',
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}