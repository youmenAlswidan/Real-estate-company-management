<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Log;

class PermissionService
{
    /**
     * Retrieve all permissions.
     *
     * This method:
     * - Attempts to fetch all Permission records.
     * - Logs any exception that occurs during the process.
     * - Returns an empty collection if an error occurs.
     *
     * @return \Illuminate\Support\Collection  A collection of permissions or an empty collection on failure.
     */
    public function getAll()
    {
        try {
            return Permission::all();
        } catch (Exception $e) {
            Log::error('Error fetching permissions: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Retrieve a specific permission instance.
     *
     * This method:
     * - Returns the given Permission model instance.
     * - Logs any exception that may occur during the process.
     * - Returns null if an error occurs.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission  The permission instance to retrieve.
     *
     * @return \Spatie\Permission\Models\Permission|null
     */
    public function get(Permission $permission)
    {
        try {
            return $permission;
        } catch (Exception $e) {
            Log::error('Error fetching single permission: ' . $e->getMessage());
            return null;
        }
    }
}
