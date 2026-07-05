<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }


    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    public function assignForm()
    {
        
        $permissions = Permission::all();
        return view('permissions.assign', compact('permissions'));
    }

    public function assignPermissions(Request $request)
    {
        
        $request->validate([
            'user_type' => 'required',
            'user_id' => 'required',
            'permissions' => 'required|array',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }

    public function getUsersByType(Request $request)
    {
        $userType = $request->user_type;
        $users = User::where('user_type', $userType)->get(['id', 'name']);
        return response()->json($users);
    }
}