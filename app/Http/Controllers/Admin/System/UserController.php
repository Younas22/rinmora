<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\System\Permission;
use App\Models\System\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::staff()->with('role');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleId = $request->get('role')) {
            $query->where('role_id', $roleId);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $roles = Role::withCount('users')->with('permissions')->orderBy('id')->get();
        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');

        return view('admin.system.users.index', compact('users', 'roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:255',
            'user_type' => 'required|in:admin,agent',
            'role_id' => 'nullable|exists:roles,id',
            'password' => 'required|string|min:8',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['status'] = 'active';

        User::create($data);

        return back()->with('success', 'Staff user added.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:255',
            'user_type' => 'required|in:admin,agent',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($data);

        return back()->with('success', 'Staff user updated.');
    }

    public function destroy(User $user)
    {
        if (!$user->isStaff()) {
            abort(404);
        }

        $user->delete();

        return back()->with('success', 'Staff user removed.');
    }
}
