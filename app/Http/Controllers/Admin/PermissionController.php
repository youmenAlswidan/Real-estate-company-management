<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\Admin\ResponseTrait;
use App\Services\Admin\PermissionService;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use ResponseTrait;

    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->getAll();
        return view('admin.permissions.index', compact('permissions'));
    }

   /* public function show(Permission $permission)
    {
        $permissionData = $this->permissionService->get($permission);

        if (!$permissionData) {
            return $this->errorResponse('Permission not found', 'admin.permissions.index');
        }

        return view('admin.permissions.show', compact('permissionData'));
    }*/
}
