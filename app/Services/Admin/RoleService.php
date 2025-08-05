<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleService
{
    /**
     * Retrieve all roles from the database.
     *
     * Attempts to fetch all roles. In case of an exception, logs the error
     * and returns an empty collection.
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        try {
            return Role::all();
        } catch (Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Retrieve a specific role by its ID.
     *
     * Attempts to find the role using the given ID.
     * If not found or an error occurs, logs the exception and returns null.
     *
     * @param  int  $id
     * @return \Spatie\Permission\Models\Role|null
     */
    public function get(int $id): ?Role
    {
        try {
            return Role::findOrFail($id);
        } catch (Exception $e) {
            Log::error('Error fetching role: ' . $e->getMessage());
            return null;
        }
    }


    /**
     * Store a new role in the database.
     *
     * Attempts to create a new role using the provided data.
     * Logs any exception that occurs and returns false if the operation fails.
     *
     * @param  array  $data
     * @return bool
     */
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


    /**
     * Update the given role with the provided data.
     *
     * Attempts to update the specified role.
     * Logs any exception that occurs and returns false if the update fails.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @param  array  $data
     * @return bool
     */
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

    /**
     * Delete the specified role from the database.
     *
     * Attempts to delete the given role instance.
     * Logs any exception that occurs and returns false if the deletion fails.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return bool
     */
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

    /**
     * Retrieve all available permissions.
     *
     * Returns a collection of all permissions from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions()
    {
        return Permission::all();
    }

    /**
     * Sync the specified permissions with the given role.
     *
     * Retrieves the permissions by their IDs and ensures they match the role's guard name.
     * Uses syncPermissions to update the role's permissions accordingly.
     * Logs any exceptions and returns false on failure.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @param  array  $permissionIds
     * @return bool
     */
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
