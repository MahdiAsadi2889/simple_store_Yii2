<?php

namespace app\services;

use app\models\Role;
use app\models\RolePermission;
use app\models\User;
use app\models\UserPermission;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class UserService
{
    public function __construct(private readonly RbacCacheService $rbacCacheService)
    {

    }

    public function getDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => User::find(),
        ]);
    }

    public function getUserById(int $userId): User
    {
        $user = User::findOne($userId);
        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }
        return $user;
    }

    public function updateUser(User $user): bool
    {
        if (!$user->validate()) {
            return false;
        }

        return $user->save(false);
    }

    public function getUserRoles(User $user): array
    {
        return Role::find()
            ->innerJoin(
                'user_role',
                'user_role.role_id = role.id'
            )
            ->where(['user_role.user_id' => $user->id])
            ->all();
    }

    public function getUserDirectPermissions(User $user): array
    {
        return UserPermission::find()
            ->select(['permission'])
            ->where(['user_id' => $user->id])
            ->column();
    }

    public function getUserEffectivePermissions(User $user): array
    {
        $permissions = $this->rbacCacheService->getCachedUserPermissions($user->id);

        if ($permissions !== null) {
            return $permissions;
        }

        $permissions = $this->getUserDirectPermissions($user);
        $rolePermissions = RolePermission::find()
            ->select('permission')
            ->innerJoin(
                'user_role',
                'user_role.role_id = role_permission.role_id'
            )
            ->where(['user_role.user_id' => $user->id])
            ->column();

        $permissions = array_values(
            array_unique(array_merge($permissions, $rolePermissions))
        );

        $this->rbacCacheService->cacheUserPermissions($user->id, $permissions);

        return $permissions;
    }
}
