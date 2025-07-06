<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@spup.edu.ph'],
            [
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'name' => 'System Administrator',
                'id_number' => 'admin123',
                'email' => 'admin@spup.edu.ph',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department_id' => 1, // CCS
                'is_active' => true,
            ]
        );
    }
}
