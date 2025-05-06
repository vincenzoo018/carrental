<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'role_id' => '1',
            'position' => 'admin',

        ]);

        Role::create([
            'role_id' => '2',
            'position' => 'customer',

        ]);
    }
}
