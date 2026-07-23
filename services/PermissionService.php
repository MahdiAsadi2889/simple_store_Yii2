<?php

namespace app\services;

use app\components\PermissionRegistry;
use app\models\Role;
use app\models\RolePermission;
use app\models\User;
use app\models\UserPermission;

class PermissionService
{
    public function syncPermissionsToRole(Role $role, array $permissions): bool
    {
        $permissions = array_unique($permissions);

        foreach ($permissions as $permission) {
            if (!PermissionRegistry::exists($permission)) {
                return false;
            }
        }

        $currentPermissions = RolePermission::find()
            ->select('permission')
            ->where(['role_id' => $role->id])
            ->column();

        $permissionsToAdd = array_diff($permissions, $currentPermissions);
        $permissionsToRemove = array_diff($currentPermissions, $permissions);

        if (!empty($permissionsToRemove)) {
            RolePermission::deleteAll([
                'and',
                ['role_id' => $role->id],
                ['IN', 'permission', $permissionsToRemove],
            ]);
        }

        foreach ($permissionsToAdd as $permission) {
            $rolePermission = new RolePermission();
            $rolePermission->role_id = $role->id;
            $rolePermission->permission = $permission;

            if (!$rolePermission->validate()) {
                return false;
            }

            $rolePermission->save(false);
        }

        return true;
    }


    public function syncPermissionsToUser(User $user, array $permissions): bool
    {
        $permissions = array_unique($permissions);
        foreach ($permissions as $permission) {
            if (!PermissionRegistry::exists($permission)) {
                return false;
            }
        }
        $currentPermissions = UserPermission::find()
            ->select('permission')
            ->where(['user_id' => $user->id])
            ->column();
        $permissionsToAdd = array_diff($permissions, $currentPermissions);
        $permissionsToRemove = array_diff($currentPermissions, $permissions);

        if (!empty($permissionsToRemove)) {
            UserPermission::deleteAll([
                'and',
                ['user_id' => $user->id],
                ['IN', 'permission', $permissionsToRemove],
            ]);
        }

        foreach ($permissionsToAdd as $permission) {

            $userPermission = new UserPermission();
            $userPermission->user_id = $user->id;
            $userPermission->permission = $permission;

            if (!$userPermission->validate()) {
                return false;
            }

            $userPermission->save(false);
        }

        return true;
    }

    public function getUserPermissions(int $userId): array
    {
        return UserPermission::find()
            ->select('permission')
            ->where(['user_id' => $userId])
            ->column();
    }

    public function getRolePermissions(int $roleId): array
    {
        return RolePermission::find()
            ->select('permission')
            ->where(['role_id' => $roleId])
            ->column();
    }

}
