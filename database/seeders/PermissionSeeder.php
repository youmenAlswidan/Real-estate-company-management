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

    'property.view',
    'property.create',
    'property.edit',
    'property.delete',
    'property.show',
    'property.image.delete',

    'property_service.view',
    'property_service.create',
    'property_service.edit',
    'property_service.delete',
    'property_service.show',

    'property_type.view',
    'property_type.create',
    'property_type.edit',
    'property_type.delete',
    'property_type.show',

    'role.view',
    'role.create',
    'role.edit',
    'role.delete',
    'role.permissions.edit',
    'role.permissions.update',
        ];
         $employeePermissions = [
            'employee.reservation.view',
            'employee.reservation.update_status',
        ];
 $customerPermissions = [
            'customer.reservation.view',
            'customer.reservation.create',
            'customer.reservation.show',
            'customer.reservation.update',
            'customer.reservation.delete',
        ];


        
        foreach (array_merge($adminPermissions) as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }


       
            $webPermissions = array_merge($adminPermissions, $employeePermissions);
        foreach ($webPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /** إنشاء صلاحيات الكوستمر (guard: api) */
        foreach ($customerPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

        // ربط الصلاحيات بالأدوار
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])->syncPermissions($adminPermissions);
        Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web'])->syncPermissions($employeePermissions);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'api'])->syncPermissions($customerPermissions);
    
    
}
}