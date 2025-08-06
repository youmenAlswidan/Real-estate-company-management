<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create employee user if not exists, with hashed password
        $employee = User::firstOrCreate(
            ['email' => 'youmen@gmail.com'],
            [
                'name' => 'youmen',
                'password' => Hash::make('youmen1234567'),
            ]
        );

        // Assign the 'employee' role to the user
        $role = Role::findByName('employee', 'web');
        $employee->assignRole($role);

    }
}
