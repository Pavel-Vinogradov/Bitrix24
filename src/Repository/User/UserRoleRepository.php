<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\User;

use Tizix\Bitrix24Laravel\Model\RBAC\UserRole;

final class UserRoleRepository implements UserRoleRepositoryInterface
{
    private UserRole $userRole;

    public function __construct()
    {
        $this->userRole = new UserRole();
    }

    public function create(int $userId, int $roleId): UserRole
    {
        return $this->userRole->create([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
