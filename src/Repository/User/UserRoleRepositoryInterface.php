<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\User;

use Tizix\Bitrix24Laravel\Model\RBAC\UserRole;

interface UserRoleRepositoryInterface
{
    public function create(int $userId, int $roleId): UserRole;
}
