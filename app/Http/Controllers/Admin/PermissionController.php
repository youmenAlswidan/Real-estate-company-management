<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Role_Permssion\StorePermissionRequest;
use App\Http\Requests\Role_Permssion\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
{
    $guardName = $this->detectGuardName($request->name);

    Permission::create([
        'name' => $request->name,
        'guard_name' => $guardName,
    ]);

    return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
}

    

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    
public function update(UpdatePermissionRequest $request, Permission $permission)
{
    $guardName = $this->detectGuardName($request->name);

    $permission->update([
        'name' => $request->name,
        'guard_name' => $guardName,
    ]);

    return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
}

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }

    private function detectGuardName($name)
    {
        if (stripos($name, 'admin') !== false || stripos($name, 'employee') !== false) {
            return 'web';
        }
        return 'api';
    }
}
