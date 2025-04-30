<?php

namespace Database\Seeders;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleMiddleware::class,
            AdminUserSeeder::class,
        ]);
    }
}
