<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Role_Permssion\StoreRoleRequest;
use App\Http\Requests\Role_Permssion\UpdateRoleRequest;
use App\Http\Requests\Role_Permssion\UpdateRolePermissionsRequest;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

   public function store(StoreRoleRequest $request)
{
    $guardName = in_array($request->name, ['admin', 'employee']) ? 'web' : 'api';

    Role::create([
        'name' => $request->name,
        'guard_name' => $guardName,
    ]);

    return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
}

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
{
    $guardName = in_array($request->name, ['admin', 'employee']) ? 'web' : 'api';

    $role->update([
        'name' => $request->name,
        'guard_name' => $guardName,
    ]);

    return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
}


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    
    public function editPermissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit_permissions', compact('role', 'permissions', 'rolePermissions'));
    }
public function updatePermissions(UpdateRolePermissionsRequest $request, $roleId)
{
    $role = Role::findOrFail($roleId);

   
    $permissions = Permission::whereIn('id', $request->permissions ?? [])
        ->where('guard_name', $role->guard_name)
        ->get();

    $role->syncPermissions($permissions);

    return redirect()->route('admin.roles.index')->with('success', 'Permissions updated successfully.');
}

}
