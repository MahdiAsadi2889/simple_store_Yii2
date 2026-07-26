<?php

namespace app\services;

use app\components\PermissionRegistry;

class RbacService
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function can(int $userId, string $permission): bool
    {
        if (!PermissionRegistry::exists($permission)) {
            return false;
        }
        $user = $this->userService->getUserById($userId);

        return in_array(
            $permission,
            $this->userService->getUserEffectivePermissions($user),
            true
        );
    }
}
