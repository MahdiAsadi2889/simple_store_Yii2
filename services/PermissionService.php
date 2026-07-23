<?php

namespace app\services;

use app\components\PermissionRegistry;
use app\models\Role;
use app\models\RolePermission;
use app\models\User;
use app\models\UserPermission;
use app\models\UserRole;

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

    public function getRolesByPermission(string $permissions): array
    {
        return Role::find()
            ->innerJoin('role_permission', 'role.id = role_permission.role_id')
            ->where(['role_permission.permission' => $permissions])
            ->all();
    }

    public function getUsersByPermission(string $permission): array
    {
        $directUsers = User::find()
            ->innerJoin(
                'user_permission',
                'user.id = user_permission.user_id'
            )
            ->where([
                'user_permission.permission' => $permission
            ])
            ->all();

        $roleUsers = User::find()
            ->innerJoin(
                'user_role',
                'user.id = user_role.user_id'
            )
            ->innerJoin(
                'role_permission',
                'user_role.role_id = role_permission.role_id'
            )
            ->where([
                'role_permission.permission' => $permission
            ])
            ->all();

        $users = [];

        foreach (array_merge($directUsers, $roleUsers) as $user) {
            $users[$user->id] = $user;
        }

        return array_values($users);
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

    public function getRoleCountByPermissions(string $permissions): int
    {
        return RolePermission::find()
            ->where(['permission' => $permissions])
            ->count();
    }

    public function getUserCountByPermissions(string $permissions): int
    {
        $directUsers = UserPermission::find()
            ->select('user_id')
            ->where(['permission' => $permissions])
            ->column();

        $roleUsers = UserRole::find()
            ->select('user_role.user_id')
            ->innerJoin(
                'role_permission',
                'role_permission.role_id = user_role.role_id'
            )
            ->where([
                'role_permission.permission' => $permissions
            ])
            ->column();
        return count(array_unique(array_merge($directUsers, $roleUsers)));
    }

    public function getPermissionDetails(string $permission): array
    {
        return [
            'roles' => $this->getRolesByPermission($permission),
            'users' => $this->getUsersByPermission($permission),
        ];
    }

}
