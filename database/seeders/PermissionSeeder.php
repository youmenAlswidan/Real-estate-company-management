<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
       app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        
        $adminPermissions = [
         'permission.view',
         'reports.view',
         'customer.view',
         'property.view',
         'property_service.view',
         'property_type.view',
         'role.view',
         'employees.view',
        ];
         $employeePermissions = [
            'employee.reservation.view',
            'employee.reservation.confirmed.view',
            'employee.reservation.cancelled.view',
            'reviews.view',

           
        ];
 


      
        $webPermissions = array_merge($adminPermissions, $employeePermissions);

      
        foreach ($webPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

       

      
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])->syncPermissions($adminPermissions);
        Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web'])->syncPermissions($employeePermissions);
       
    }
}