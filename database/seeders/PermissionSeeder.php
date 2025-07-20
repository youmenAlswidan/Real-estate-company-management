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
            'create_property_type',
            'edit_property_type',
            'delete_property_type',
            'create_property',
            'edit_property',
            'delete_property',
            'create_service',
            'edit_service',
            'delete_service',
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_reports',
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