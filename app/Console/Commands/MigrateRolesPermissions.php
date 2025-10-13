<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

        $roleIdMap = $this->migrateRoles();
        $permIdMap = $this->migratePermissions();

        $this->migrateRolePermissions($roleIdMap, $permIdMap);

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

    protected function migrateRoles(): array
    {
        $oldRoles = DB::connection('mysql_old')->table('roles')->get();
        $roleIdMap = [];

        foreach ($oldRoles as $role) {
            $roleInDB = Role::firstOrCreate([
                'name' => $role->name,
                'guard_name' => $role->guard_name ?? 'web',
            ]);
            $roleIdMap[$role->id] = $roleInDB->id;
        }

        $this->info('Роли успешно перенесены.');
        return $roleIdMap;
    }

    protected function migratePermissions(): array
    {
        $oldPermissions = DB::connection('mysql_old')->table('permissions')->get();
        $permIdMap = [];

        foreach ($oldPermissions as $perm) {
            $permInDB = Permission::firstOrCreate([
                'name' => $perm->name,
                'guard_name' => $perm->guard_name ?? 'web',
            ]);
            $permIdMap[$perm->id] = $permInDB->id;
        }

        $this->info('Разрешения успешно перенесены.');
        return $permIdMap;
    }

    protected function migrateRolePermissions(array $roleIdMap, array $permIdMap): void
    {
        $oldRolePerms = DB::connection('mysql_old')->table('role_has_permissions')->get();

        foreach ($oldRolePerms as $rp) {
            $roleId = $roleIdMap[$rp->role_id] ?? null;
            $permissionId = $permIdMap[$rp->permission_id] ?? null;

            if (!$roleId || !$permissionId) {
                $this->warn("Пропущена привязка role_id={$rp->role_id}, permission_id={$rp->permission_id}");
                continue;
            }

            DB::table('role_has_permissions')->updateOrInsert([
                'role_id' => $roleId,
                'permission_id' => $permissionId,
            ]);
        }

        $this->info('Привязки разрешений к ролям перенесены.');
    }

}
