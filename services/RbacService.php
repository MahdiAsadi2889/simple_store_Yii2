<?php

namespace app\services;

use app\models\RolePermission;
use app\models\UserPermission;
use app\models\UserRole;
use app\components\PermissionRegistry;
use Yii;

class RbacService
{
    public function can(int $userId, string $permission): bool
    {
        if (!PermissionRegistry::exists($permission)) {
            return false;
        }
        if (UserPermission::find()->where(['user_id' => $userId, 'permission' => $permission])->exists()) {
            return true;
        }
        $roleIds = UserRole::find()->select('role_id')->where(['user_id' => $userId])->column();
        if (empty($roleIds)) {
            return false;
        }

        return RolePermission::find()->where(['permission' => $permission])->andWhere(['IN', 'role_id', $roleIds])->exists();
    }
}
