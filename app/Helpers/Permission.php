<?php

use App\Enums\DOperatorEnums\DOperatorGeneralPermissionEnum;
use App\Enums\UserEnums\RoleEnum;
use App\Models\DClientPass;
use App\Models\DTask;
use App\Models\PRolePermission;
use App\Services\PGeneralPermissionServices\PGeneralPermissionService;
use Spatie\Permission\Models\Role;

function assignPermissionsTo($user, $roleString)
{
    $role = Role::whereName($roleString)->first();

    PRolePermission::where('role_id', $role?->id)
        ->get()
        ->each(
            fn ($rolePermission) => $user->givePermissionTo($rolePermission->permission)
        );
}

function revokePermissionsTo($user)
{
    $user->permissions->each(function ($permission) use ($user) {

        $user->revokePermissionTo($permission->name);
    });
}
function canAccessOnlyHisOwn($user, $permission, $currentRole, $modelToCheck)
{
    $isHolder = $user->hasRole($currentRole)
        && $user->id == $modelToCheck->id;

    $anotherCurrentUser = ! $user->hasRole($currentRole)
        && $user->hasAnyDirectPermission($permission);

    return $isHolder || $anotherCurrentUser;
}

function canViewEditOnlyHisOwn($user, $permission, $model)
{

    if ($user->hasRole('admin')) {
        return true;
    }

    return $user->hasAnyDirectPermission($permission) && $user->id == $model->user_id;
}

function getRoles()
{
    return Role::all()->pluck('name');
}

function permissionsByResource($user, $resource)
{
    return $user->permissionList
        ->where('resource_name_en', $resource)
        ->flatMap(function ($item) {
            return $item['permissions'];
        });
}

function filterRolesByPermissions($user, $resource = 'users')
{
    return permissionsByResource($user, $resource)->where('authorized', true)
        ->map(function ($permission) use ($user) {
            foreach (methods() as $method) {
                if (
                    str_contains($permission['name'], $method) &&
                    str_contains($permission['name'], $user->profile)
                ) {
                    return rtrim(ltrim(str_replace($method, '', $permission['name'])), 's');
                }
            }
        })->unique()->values()->toArray();
}

function syncPermissions($user, $role)
{
    revokePermissionsTo($user);
    $roleSpatie = Role::where('guard_name', 'web')->first();
    $user->syncRoles([$roleSpatie]);
    assignPermissionsTo($user, $roleSpatie);
}


function methods()
{
    return [
        'create',
        'view',
        'update',
        'delete',
        'disable',
        'validate',
    ];
}


function canViewAny($user,$permission,$generalPermission){

    return $user->can($permission);
}

function canDeleteTask($user,DTask $dTask){
    
    return $dTask->user_id == $user->id;

}
