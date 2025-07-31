<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Log;

class PermissionService
{
    public function getAll()
    {
        try {
            return Permission::all();
        } catch (Exception $e) {
            Log::error('Error fetching permissions: ' . $e->getMessage());
            return collect();
        }
    }

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
