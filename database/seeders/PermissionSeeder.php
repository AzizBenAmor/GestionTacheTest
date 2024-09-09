<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('authorizations.permissions');
                foreach ($permissions as $permission) {
                    Permission::firstOrCreate([
                        'name' => $permission['en'],
                        'guard_name' => 'web',
                    ]);
                }
    }
}
