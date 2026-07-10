<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\System\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Role::create($data);

        return back()->with('success', 'Role created.');
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $role->update($data);

        return back()->with('success', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return back()->with('error', 'This role is protected and cannot be deleted.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted.');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $data = $request->validate([
            'permission_ids' => 'nullable|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($data['permission_ids'] ?? []);

        return back()->with('success', 'Permissions updated for '.$role->name.'.');
    }
}
