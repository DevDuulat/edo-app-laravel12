<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSyncController extends Controller
{
    public function syncRolesPermissions(Request $request)
    {
        \Log::info('Sync started', ['payload' => $request->all()]);
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string',
            'email' => 'required|string',
            'roles' => 'required|array',
            'roles.*' => 'string',
            'permissions' => 'required|array',
            'permissions.*' => 'string',
        ]);

        foreach ($validated['roles'] as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        foreach ($validated['permissions'] as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $user = \App\Models\User::where('email', $validated['email'])->first();
          \Log::info($user);
        if ($user) {
            $user->syncRoles($validated['roles']);
            $user->syncPermissions($validated['permissions']);

            \Log::info('User roles & permissions synced', [
                'user_id' => $user->id,
                'roles' => $validated['roles'],
                'permissions' => $validated['permissions']
            ]);
        } else {
            \Log::warning('User not found for sync', ['email' => $validated['email']]);
        }

        return response()->json(['message' => 'Roles and permissions synced successfully']);
    }

    public function syncEmail(Request $request)
    {
        $validated = $request->validate([
            'old_email' => 'required|email',
            'new_email' => 'required|email',
            'new_password' => 'required|string|min:8',
            'name' => 'nullable|string',
        ]);

        $user = \App\Models\User::where('email', $validated['old_email'])->first();

        if ($user) {
            $user->update([
                'email' => $validated['new_email'],
                'name' => $validated['name'] ?? $user->name,
                'password' => Hash::make($validated['new_password']),
            ]);

            \Log::info('Email & password synced', [
                'user_id' => $user->id,
                'old_email' => $validated['old_email'],
                'new_email' => $validated['new_email'],
            ]);
        }

        return response()->json(['message' => 'Email synced successfully']);
    }

}
