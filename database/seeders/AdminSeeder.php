<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Create admin user if not exists, with hashed password
           $admin = User::firstOrCreate(
            ['email' => 'Tuka@gmail.com'],
            [
                'name' => 'Tuka',
                'password' => Hash::make('tuka1234567'),
            ]
        );
            // Assign the 'admin' role to the user
        $admin->assignRole('admin');
    
    }
}
