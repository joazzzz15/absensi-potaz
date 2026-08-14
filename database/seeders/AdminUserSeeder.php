<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat 1 akun admin default.
     * Jalankan: php artisan db:seed --class=AdminUserSeeder
     *
     * SILAKAN GANTI email & password di bawah ini sebelum dijalankan,
     * atau login lalu ganti password lewat tinker/DB langsung.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@potaz.test'],
            [
                'name' => 'Admin Potaz',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
