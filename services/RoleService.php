<?php

namespace app\services;

use app\models\RolePermission;
use app\models\User;
use app\models\UserRole;
use app\models\Role;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class RoleService
{

    public function __construct(private readonly RbacCacheService $rbacCacheService)
    {

    }

    public function createRole(Role $role): bool
    {
        if (!$role->validate()) {
            return false;
        }

        return $role->save(false);
    }

    public function updateRole(Role $role): bool
    {
        if (!$role->validate()) {
            return false;
        }

        return $role->save(false);
    }

    public function getDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Role::find(),
        ]);
    }

    public function findById(int $id): Role
    {
        $role = Role::findOne($id);
        if ($role === null) {
            throw new NotFoundHttpException('Role not found');
        }
        return $role;
    }

    public function assignRoleToUser(User $user, Role $role): bool
    {
        if (
            UserRole::find()->where([
                'user_id' => $user->id,
                'role_id' => $role->id
            ])->exists()
        ) {
            return false;
        }

        $userRole = new UserRole();
        $userRole->user_id = $user->id;
        $userRole->role_id = $role->id;
        if (!$userRole->validate()) {
            return false;
        }
        if (!$userRole->save(false)) {
            return false;
        }
        $this->rbacCacheService->clearUserPermissions($user->id);
        return true;
    }

    public function removeRoleFromUser(User $user, Role $role): bool
    {
        $userRole = UserRole::find()->where(['user_id' => $user->id, 'role_id' => $role->id])->one();
        if ($userRole === null) {
            return false;
        }
        $result = $userRole->delete() !== false;
        if ($result) {
            $this->rbacCacheService->clearUserPermissions($user->id);
        }
        return $result;
    }

    public function getRoleUsers(Role $role): array
    {
        return User::find()
            ->innerJoin(
                'user_role',
                'user.id = user_role.user_id'
            )
            ->where([
                'user_role.role_id' => $role->id
            ])
            ->all();
    }

    public function getRolePermissions(Role $role): array
    {
        return RolePermission::find()
            ->select(['permission'])
            ->where([
                'role_id' => $role->id
            ])
            ->column();
    }

    public function deleteRole(Role $role): bool
    {
        $users = $this->getRoleUsers($role);

        $result = $role->delete() !== false;

        if (!$result) {
            return false;
        }

        foreach ($users as $user) {
            $this->rbacCacheService->clearUserPermissions($user->id);
        }

        return true;
    }
}
