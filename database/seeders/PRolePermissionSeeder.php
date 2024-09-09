<?php

namespace Database\Seeders;

use App\Models\PRolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();

        $permissions = config('authorizations.rolePermissions');

        foreach ($roles as $role) {

            if (
                isset($permissions[$role->name])
            ) {
                foreach ($permissions[$role->name] as $permission) {
                    $permission = Permission::where('name', $permission)->first();
                    if (! $permission) {
                        continue;
                    }
                    PRolePermission::firstOrCreate([
                        'role_id' => $role->id,
                        'permission_id' => $permission->id,
                    ]);
                }
            }
        }
    }
}
