<?php

namespace app\components;

use RuntimeException;
use Yii;

class PermissionRegistry
{
    private static ?array $permissions = null;

    public static function all(): array
    {
        if (self::$permissions !== null) {
            return self::$permissions;
        }

        $permissions = require Yii::getAlias('@app/config/permissions.php');

        if (!is_array($permissions)) {
            throw new RuntimeException('The permissions.php file must return an array.');
        }

        self::$permissions = $permissions;

        return self::$permissions;
    }

    public static function exists(string $permission): bool
    {
        return in_array($permission, self::all(), true);
    }

    public static function clear(): void
    {
        self::$permissions = null;
    }
}
