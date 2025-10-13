<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class SsoService
{
    public function handleCallback(string $token): User
    {
        $data = $this->verifyToken($token);

        $user = $this->findOrCreateUser($data);

        $this->syncRolesAndPermissions($user, $data);

        return $user;
    }

    protected function verifyToken(string $token): array
    {
        $response = Http::get(config('services.sso.verify_url'), ['token' => $token]);

        if ($response->failed()) {
            abort(403, 'Invalid SSO token.');
        }

        return $response->json();
    }

    protected function findOrCreateUser(array $data): User
    {
        return User::firstOrCreate(
            ['base_id' => $data['base_id']],
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt(Str::random(16)),
            ]
        );
    }

    protected function syncRolesAndPermissions(User $user, array $data): void
    {
        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        if (!empty($data['permissions'])) {
            foreach ($data['permissions'] as $permName) {
                Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
            }

            $user->syncPermissions($data['permissions']);
        }
    }
}
