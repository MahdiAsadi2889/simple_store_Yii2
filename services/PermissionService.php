<?php

namespace app\services;

use app\components\PermissionRegistry;
use app\models\Role;
use app\models\RolePermission;
use app\models\User;
use app\models\UserPermission;

class PermissionService
{
    public function assignPermissionToRole(Role $role, string $permission)
    {
        if (!PermissionRegistry::exists($permission)) {
            return false;
        }

        if (RolePermission::find()->where(['role_id' => $role->id, 'permission' => $permission])->exists()) {
            return false;
        }
        $rolePermission = new RolePermission();
        $rolePermission->role_id = $role->id;
        $rolePermission->permission = $permission;

        if (!$rolePermission->validate()) {
            return false;
        }
        return $rolePermission->save(false);
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

    public function assignPermissionToUser(User $user, string $permission)
    {
        if (!PermissionRegistry::exists($permission)) {
            return false;
        }
        if (UserPermission::find()->where(['user_id' => $user->id, 'permission' => $permission])->exists()) {
            return false;
        }

        $userPermission = new UserPermission();
        $userPermission->user_id = $user->id;
        $userPermission->permission = $permission;

        if (!$userPermission->validate()) {
            return false;
        }
        return $userPermission->save(false);
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
