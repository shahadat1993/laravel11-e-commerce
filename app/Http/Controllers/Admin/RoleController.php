<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles=Role::paginate(10);
        return view('admin.role&permission.roleList',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions=Permission::all();
        return view('admin.role&permission.createRole',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Role created successfully!');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
    $permissions = Permission::all();

    $rolePermissions = $role->permissions->pluck('name')->toArray();

    return view('admin.role&permission.editRole', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $role = Role::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:roles,name,' . $id,
        'permissions' => 'required|array'
    ]);

    $role->update(['name' => $request->name]);


    $role->syncPermissions($request->permissions);

    return redirect()->route('admin.roles')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);



    $role->delete();
    return back()->with('success', 'Role deleted successfully!');
    }
}
