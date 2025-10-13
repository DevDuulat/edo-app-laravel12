<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MigrateRolesPermissions extends Command
{
    protected $signature = 'migrate:roles-permissions';
    protected $description = 'Перенос ролей и разрешений из Laravel 10 в Laravel 12';

    public function handle()
    {
        $this->info('=== Начало миграции ролей и разрешений ===');

        if (!$this->checkDB()) {
            return;
        }

        $this->migrateRoles();
        $this->migratePermissions();
        $this->migrateRolePermissions();
        $this->migrateUserRoles();
        $this->migrateUserPermissions();

        $this->call('permission:cache-reset');

        $this->info('=== Миграция завершена успешно! ===');
    }

    protected function checkDB(): bool
    {
        try {
            DB::connection('mysql_old')->getPdo();
            $this->info("Подключение к старой базе успешно!");
            return true;
        } catch (\Exception $e) {
            $this->error("Ошибка подключения: " . $e->getMessage());
            return false;
        }
    }

    protected function migrateRoles(): void
    {
        $oldRoles = DB::connection('mysql_old')->table('roles')->get();
        foreach ($oldRoles as $role) {
            Role::firstOrCreate([
                'name' => $role->name,
                'guard_name' => $role->guard_name ?? 'web',
            ]);
        }
        $this->info('Роли успешно перенесены.');
    }

    protected function migratePermissions(): void
    {
        $oldPermissions = DB::connection('mysql_old')->table('permissions')->get();
        foreach ($oldPermissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm->name,
                'guard_name' => $perm->guard_name ?? 'web',
            ]);
        }
        $this->info('Разрешения успешно перенесены.');
    }

    protected function migrateRolePermissions(array $roleIdMap, array $permIdMap): void
    {
        $oldRolePerms = DB::connection('mysql_old')->table('role_has_permissions')->get();

        foreach ($oldRolePerms as $rp) {
            $perm = DB::table('permissions')->where('id', $permIdMap[$rp->permission_id] ?? 0)->first();
            if (!$perm) {
                $this->error("Пропущено permission_id {$rp->permission_id} — нет в новой базе!");
                continue; // пропускаем, чтобы не ломать FK
            }

            $roleId = $roleIdMap[$rp->role_id] ?? null;
            if (!$roleId) {
                $this->error("Пропущено role_id {$rp->role_id} — нет в новой базе!");
                continue;
            }

            DB::table('role_has_permissions')->updateOrInsert([
                'role_id' => $roleId,
                'permission_id' => $perm->id,
            ]);
        }

        $this->info('Привязки разрешений к ролям перенесены.');
    }

    protected function migrateUserRoles(): void
    {
        $oldUserRoles = DB::connection('mysql_old')->table('model_has_roles')->get();
        foreach ($oldUserRoles as $ur) {
            DB::table('model_has_roles')->updateOrInsert([
                'role_id' => $ur->role_id,
                'model_type' => $ur->model_type,
                'model_id' => $ur->model_id,
            ]);
        }
        $this->info('Привязки ролей к пользователям перенесены.');
    }

    protected function migrateUserPermissions(): void
    {
        $oldUserPerms = DB::connection('mysql_old')->table('model_has_permissions')->get();
        foreach ($oldUserPerms as $up) {
            DB::table('model_has_permissions')->updateOrInsert([
                'permission_id' => $up->permission_id,
                'model_type' => $up->model_type,
                'model_id' => $up->model_id,
            ]);
        }
        $this->info('Привязки разрешений к пользователям перенесены.');
    }


}
