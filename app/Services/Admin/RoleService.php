<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleService
{
    public function getAll()
    {
        try {
            return Role::all();
        } catch (Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return collect();
        }
    }

    public function get(int $id): ?Role
    {
        try {
            return Role::findOrFail($id);
        } catch (Exception $e) {
            Log::error('Error fetching role: ' . $e->getMessage());
            return null;
        }
    }

    public function store(array $data): bool
    {
        try {
            Role::create($data);
            return true;
        } catch (Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return false;
        }
    }

    public function update(Role $role, array $data): bool
    {
        try {
            $role->update($data);
            return true;
        } catch (Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return false;
        }
    }

    public function destroy(Role $role): bool
    {
        try {
            $role->delete();
            return true;
        } catch (Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return false;
        }
    }

    public function getPermissions()
    {
        return Permission::all();
    }

    public function updatePermissions(Role $role, array $permissionIds): bool
    {
        try {
            $permissions = Permission::whereIn('id', $permissionIds)
                ->where('guard_name', $role->guard_name)
                ->get();

            $role->syncPermissions($permissions);
            return true;
        } catch (Exception $e) {
            Log::error('Error syncing permissions: ' . $e->getMessage());
            return false;
        }
    }
}
