<?php

namespace app\services;

use app\components\PermissionRegistry;
use app\models\Role;
use app\models\RolePermission;
use app\models\User;
use app\models\UserPermission;

class PermissionService
{
    public function assignPermissionsToRole(Role $role, array $permissions): bool
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

    public function removePermissionFromRole(Role $role, string $permission): bool
    {
        if (!PermissionRegistry::exists($permission)) {
            return false;
        }
        $rolePermission = RolePermission::find()
            ->where(['role_id' => $role->id, 'permission' => $permission])
            ->one();

        if ($rolePermission === null) {
            return false;
        }
        return $rolePermission->delete() !== false;
    }

    public function assignPermissionsToUser(User $user, array $permissions): bool
    {
        $permissions = array_unique($permissions);
        foreach ($permissions as $permission) {
            if (!PermissionRegistry::exists($permission)) {
                return false;
            }
        }
        $currentPermissions = RolePermission::find()
            ->select('permission')
            ->where(['role_id' => $user->id])
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


    public function removePermissionFromUser(User $user, string $permission): bool
    {
        if (!PermissionRegistry::exists($permission)) {
            return false;
        }

        $userPermission = UserPermission::find()
            ->where(['user_id' => $user->id, 'permission' => $permission])
            ->one();

        if ($userPermission === null) {
            return false;
        }
        return $userPermission->delete() !== false;
    }
}
