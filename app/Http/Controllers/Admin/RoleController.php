<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role_Permssion\StoreRoleRequest;
use App\Http\Requests\Role_Permssion\UpdateRoleRequest;
use App\Http\Requests\Role_Permssion\UpdateRolePermissionsRequest;
use App\Services\Admin\RoleService;
use App\Traits\Admin\ResponseTrait;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ResponseTrait;

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAll();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $guardName = in_array($request->name, ['admin', 'employee']) ? 'web' : 'api';

        $success = $this->roleService->store([
            'name' => $request->name,
            'guard_name' => $guardName,
        ]);

        return $success
            ? $this->successResponse('Role created successfully.', 'admin.roles.index')
            : $this->errorResponse('Failed to create role.', 'admin.roles.index');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $guardName = in_array($request->name, ['admin', 'employee']) ? 'web' : 'api';

        $success = $this->roleService->update($role, [
            'name' => $request->name,
            'guard_name' => $guardName,
        ]);

        return $success
            ? $this->successResponse('Role updated successfully.', 'admin.roles.index')
            : $this->errorResponse('Failed to update role.', 'admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $success = $this->roleService->destroy($role);

        return $success
            ? $this->successResponse('Role deleted successfully.', 'admin.roles.index')
            : $this->errorResponse('Failed to delete role.', 'admin.roles.index');
    }

    public function editPermissions($roleId)
    {
        $role = $this->roleService->get($roleId);
        $permissions = $this->roleService->getPermissions();
        $rolePermissions = $role?->permissions->pluck('id')->toArray() ?? [];

        return view('admin.roles.edit_permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    public function updatePermissions(UpdateRolePermissionsRequest $request, $roleId)
    {
        $role = $this->roleService->get($roleId);

        $success = $this->roleService->updatePermissions($role, $request->permissions ?? []);

        return $success
            ? $this->successResponse('Permissions updated successfully.', 'admin.roles.index')
            : $this->errorResponse('Failed to update permissions.', 'admin.roles.index');
    }
}
