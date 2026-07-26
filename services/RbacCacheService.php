<?php

namespace app\services;

use Yii;
use yii\redis\Connection;

class RbacCacheService
{

    private const USER_PERMISSION_TTL = 3600;

    public function __construct(private readonly Connection $redis)
    {

    }

    public function getCachedUserPermissions(int $userId): ?array
    {
        $cached = $this->redis->get($this->getUserPermissionCacheKey($userId));

        if ($cached === null) {
            return null;
        }

        $permissions = json_decode($cached, true);

        return is_array($permissions) ? $permissions : null;
    }

    public function cacheUserPermissions(int $userId, array $permissions): void
    {
        $this->redis->executeCommand('SET', [
            $this->getUserPermissionCacheKey($userId),
            json_encode($permissions, JSON_THROW_ON_ERROR),
            'EX',
            Yii::$app->params['rbac.permissionCacheTtl']
        ]);
    }

    public function clearUserPermissions(int $userId): void
    {
        $this->redis->del(
            $this->getUserPermissionCacheKey($userId)
        );
    }

    private function getUserPermissionCacheKey(int $userId): string
    {
        return "rbac:user:{$userId}:effective-permissions";
    }
}
