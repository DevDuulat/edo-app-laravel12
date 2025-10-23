<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SyncPermissions extends Command
{
    protected $signature = 'sync:permissions';
    protected $description = 'Синхронизация новых разрешений для всех пользователей';

    public function handle()
    {
        $this->info('=== Начало синхронизации разрешений ===');

        $roles = Role::with('permissions')->get();

        $users = User::with('roles')->get();

        foreach ($users as $user) {
            foreach ($user->roles as $role) {
                $rolePermissions = $roles->where('id', $role->id)->first()->permissions->pluck('name')->toArray();

                $user->givePermissionTo($rolePermissions);
            }
        }

        $this->info('=== Синхронизация разрешений завершена ===');
    }
}
