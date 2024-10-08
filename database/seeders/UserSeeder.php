<?php

namespace Database\Seeders;

use App\Enums\UserEnums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole(RoleEnum::admin()->value);
        assignPermissionsTo($user, RoleEnum::admin()->value);
        $user = User::create([
            'email' => 'user@gmail.com',
            'name' => 'User',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole(RoleEnum::user()->value);
        assignPermissionsTo($user, RoleEnum::user()->value);
        $user = User::create([
            'email' => 'user1@gmail.com',
            'name' => 'User1',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole(RoleEnum::user()->value);
        assignPermissionsTo($user, RoleEnum::user()->value);

    }
}
