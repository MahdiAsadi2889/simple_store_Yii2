<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use Yii;
use app\models\Role;
use RuntimeException;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class RoleService
{
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
        if (UserRole::find()->where([
            'user_id' => $user->id,
            'role_id' => $role->id
        ])->exists()) {
            return false;
        }

        $userRole = new UserRole();
        $userRole->user_id = $user->id;
        $userRole->role_id = $role->id;
        if (!$userRole->validate()) {
            return false;
        }
        return $userRole->save(false);
    }

    public function removeRoleFromUser(User $user, Role $role): bool
    {
        $userRole = UserRole::find()->where(['user_id' => $user->id, 'role_id' => $role->id])->one();
        if ($userRole === null) {
            return false;
        }
        return $userRole->delete() !== false;
    }

    //    public function deleteRole(int $roleId): bool
//    {
//
//    }
}
