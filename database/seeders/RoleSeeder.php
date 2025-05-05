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
            'created_at' => null,
            'updated_at' => null,
        ]);

        Role::create([
            'role_id' => '2',
            'position' => 'customer',
            'created_at' => null,
            'updated_at' => null,
        ]);
        

        
    }
}
