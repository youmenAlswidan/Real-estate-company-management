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

    /**
     * Inject the RoleService into the controller.
     *
     * @param  \App\Services\Admin\0RoleService  $roleService  The service responsible for role-related operations.
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of all roles.
     *
     * This method:
     * - Retrieves all roles using the RoleService.
     * - Returns the view for displaying the roles in the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = $this->roleService->getAll();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Display the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created role in storage.
     *
     * Determines the appropriate guard name based on the role name,
     * then delegates the role creation to the RoleService.
     * Returns a success or error response based on the outcome.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Show the form for editing the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }


    /**
     * Update the specified role in storage.
     *
     * Determines the appropriate guard name based on the role name,
     * then updates the role using the RoleService.
     * Returns a success or error response based on the outcome.
     *
     * @param  \App\Http\Requests\Role_Permssion\UpdateRoleRequest  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
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


    /**
     * Remove the specified role from storage.
     *
     * Delegates the deletion process to the RoleService.   
     * Returns a success or error response based on the outcome.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $success = $this->roleService->destroy($role);

        return $success
            ? $this->successResponse('Role deleted successfully.', 'admin.roles.index')
            : $this->errorResponse('Failed to delete role.', 'admin.roles.index');
    }


    /**
     * Show the form for editing the permissions of a specific role.
     *
     * Retrieves the role, all available permissions, and the role's current permissions,
     * then returns the view for editing them.
     *
     * @param  int  $roleId
     * @return \Illuminate\View\View
     */
    public function editPermissions($roleId)
    {
        $role = $this->roleService->get($roleId);
        $permissions = $this->roleService->getPermissions();
        $rolePermissions = $role?->permissions->pluck('id')->toArray() ?? [];

        return view('admin.roles.edit_permissions', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the permissions assigned to a specific role.
     *
     * Retrieves the role by its ID, then updates its permissions using the RoleService.
     * Returns a success or error response based on the outcome.
     *
     * @param  \App\Http\Requests\Role_Permssion\UpdateRolePermissionsRequest  $request
     * @param  int  $roleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermissions(UpdateRolePermissionsRequest $request, $roleId)
    {
        $role = $this->roleService->get($roleId);

        $success = $this->roleService->updatePermissions($role, $request->permissions ?? []);

        return $success
            ? $this->successResponse('Permissions updated successfully.', 'admin.roles.index')
            : $this->errorResponse('Failed to update permissions.', 'admin.roles.index');
    }
}
