<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; 
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      //The roles admin and employee use the web
        $admin=Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $employee=Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);

        $user=User::find(1);
        if($user) { $user->assignRole($admin); }

        $user=User::find(2);
        if($user) { $user->assignRole($employee); }

      // The customer and visitor roles use the API
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'visitor', 'guard_name' => 'api']);
    }
}
