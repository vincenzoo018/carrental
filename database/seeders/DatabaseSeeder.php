<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create([
            'employee' => 'admin',
            'customer' => null,
        ]);

        $customerRole = Role::create([
            'employee' => null,
            'customer' => 'customer',
        ]);

        $mechanicRole = Role::create([
            'employee' => 'mechanic',
            'customer' => null,
        ]);


        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@carrental.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone_number' => '1234567890',
            'address' => '123 Admin St',
            'role_id' => $adminRole->role_id,
        ]);

        // Create sample customer
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone_number' => '9876543210',
            'address' => '456 Customer Ave',
            'role_id' => $customerRole->role_id,
        ]);

        // Create employee
        Employee::create([
            'name' => 'Mechanic Mike',
            'position' => 'Senior Mechanic',
            'role_id' => $mechanicRole->role_id,
        ]);

        // Create sample cars
        Car::create([
            'brand' => 'Toyota',
            'model' => 'Camry',
            'year' => 2023,
            'plate_number' => 'ABC123',
            'price' => 75.00,
            'status' => 'available',
            'mileage' => 5000,
        ]);

        Car::create([
            'brand' => 'Honda',
            'model' => 'Accord',
            'year' => 2022,
            'plate_number' => 'DEF456',
            'price' => 80.00,
            'status' => 'available',
            'mileage' => 8000,
        ]);

        Car::create([
            'brand' => 'Ford',
            'model' => 'Mustang',
            'year' => 2021,
            'plate_number' => 'GHI789',
            'price' => 120.00,
            'status' => 'available',
            'mileage' => 12000,
        ]);

        // Create services
        Service::create([
            'service_name' => 'Premium Car Wash',
            'description' => 'Full exterior and interior cleaning with waxing and polishing',
            'price' => 45.00,
            'employee_id' => 1,
        ]);

        Service::create([
            'service_name' => 'Oil Change',
            'description' => 'Standard oil change with filter replacement',
            'price' => 65.00,
            'employee_id' => 1,
        ]);

        Service::create([
            'service_name' => 'Tire Rotation',
            'description' => 'Rotation and balancing of all four tires',
            'price' => 35.00,
            'employee_id' => 1,
        ]);
    }
}
