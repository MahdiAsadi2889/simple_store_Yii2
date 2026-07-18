<?php

namespace app\services;

use app\models\RolePermission;
use app\models\UserPermission;
use app\models\UserRole;
use Yii;

class RbacService
{
    public function can(int $userId, string $permission): bool
    {
        if (!$this->permissionExists($permission)) {
            return false;
        }
        if (UserPermission::find()->where(['user_id' => $userId, 'permission' => $permission])->exists()) {
            return true;
        }
        $roleIds = UserRole::find()->select('role_id')->where(['user_id' => $userId])->column();
        if (empty($roleIds)) {
            return false;
        }

        return RolePermission::find()->where(['permission' => $permission])->andWhere(['role_id', $roleIds])->exists();
    }

    private function getPermissions(): array
    {
        return require Yii::getAlias('@app/config/permissions.php');
    }

    private function permissionExists(string $permission): bool
    {
        return in_array(
            $permission,
            $this->getPermissions(),
            true
        );
    }
}
