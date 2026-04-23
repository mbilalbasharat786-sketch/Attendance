<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    // Roles ki list show karna
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    // Naya Role banane ka form
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    // Naya Role database mein save karna
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'VIP Role created successfully!');
    }

    // Role ko edit karne ka form
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    // Edit kiya hua Role update karna
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    // Role delete karna
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        if($role->name === 'Admin') {
            return redirect()->back()->with('error', 'Super Admin role delete nahi ho sakta!');
        }
        
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }

    // Student/User ko role assign karna
    public function assignRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles($request->role); // Purane roles hata kar naya lagayega
        
        return redirect()->back()->with('success', 'Role assigned successfully to ' . $user->name);
    }
}