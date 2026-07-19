<?php

namespace app\services;

use app\models\User;
use app\models\UserRole;
use Yii;
use app\models\Role;
use RuntimeException;

class RoleService
{
    public function createRole(Role $role): bool
    {
        if (!$role->validate()) {
            return false;
        }

        return $role->save(false);
    }

    public function deleteRole(int $roleId): bool
    {

    }

    public function assignRoleToUser(User $user, Role $role): bool
    {
        if(UserRole::find()->where([
            'user_id' => $user->id,
            'role_id' => $role->id
        ])->exists()){
            return false;
        }

        $userRole = new UserRole();
        $userRole->user_id = $user->id;
        $userRole->role_id = $role->id;
        if(!$userRole->validate()){
            return false;
        }
        return $userRole->save(false);
    }

    public function removeRoleFromUser(User $user, Role $role): bool
    {
        $userRole = UserRole::find()->where(['user_id' => $user->id, 'role_id' => $role->id])->one();
        if($userRole === null){
            return false;
        }
        return $userRole->delete() !== false;
    }
}
