<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;

final class UserRoleQuery extends Builder
{
    public function byUserId($userId): UserRoleQuery
    {
        return $this->where(['user_id' => $userId]);
    }

    public function byRoleId($roleId): UserRoleQuery
    {
        return $this->where(['role_id' => $roleId]);
    }
}
