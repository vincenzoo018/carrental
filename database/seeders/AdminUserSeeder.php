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
        User::create([
            'name' => 'Christian Kerby Navallo',
            'email' => 'navallo@gmail.com',
            'phone_number' => '1234567890',
            'address' => '123 User Street',
            'license' => 'User123',
            'password' => Hash::make('password123'), // Use a secure password
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'Vincent Ray Toylo',
            'email' => 'toylo@gmail.com',
            'phone_number' => '1234567890',
            'address' => '123 User Street',
            'license' => 'User123',
            'password' => Hash::make('password123'), // Use a secure password
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'Benz Carl Vale',
            'email' => 'vale@gmail.com',
            'phone_number' => '1234567890',
            'address' => '123 User Street',
            'license' => 'User123',
            'password' => Hash::make('password123'), // Use a secure password
            'role_id' => 2,
        ]);
    }
}
