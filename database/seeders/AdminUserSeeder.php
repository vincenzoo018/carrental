<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@carrental.com',
            'phone_number' => '1234567890',
            'address' => '123 Admin Street',
            'license' => 'ADMIN123',
            'password' => Hash::make('password123'), // Use a secure password
            'role_id' => 1,
        ]);
    }
}
