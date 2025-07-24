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
        'manage_property_type',
        'manage_property',
        'manage_service',
        'manage_user',
        'manage_role',
        'manage_permission',

    // تقارير (عرض فقط)
    'view_property_reports',
    'view_booking_reports',
        ];

        
        foreach (array_merge($adminPermissions) as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }


       
         $admin = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        $admin->syncPermissions($adminPermissions);
       
    
}
}