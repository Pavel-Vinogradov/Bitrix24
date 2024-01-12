<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\User\Queries;

use Illuminate\Database\Eloquent\Builder;
use Tizix\Bitrix24Laravel\Model\RBAC\RolePermission;
use Tizix\Bitrix24Laravel\Model\RBAC\UserRole;

final class UserQuery extends Builder
{
    public function byId($value): UserQuery
    {
        return $this->where(['id' => $value]);
    }

    public function byName($value): UserQuery
    {
        return $this->whereFullText('name', $value);
    }

    public function byActive($active): UserQuery
    {
        return $this->where(['is_active' => $active]);
    }

    public function byRoleId($roleId): UserQuery
    {
        return $this->where(['id' => UserRole::select('user_id')->byRoleId($roleId)]);
    }

    public function byPermissionId($permissionId): UserQuery
    {
        return $this->where(['id' => UserRole::select('user_id')->byRoleId(RolePermission::select('role_id')->byPermissionId($permissionId))]);
    }

    public function byUserId($userId): UserQuery
    {
        return $this->where(['user_id' => $userId]);
    }
    public function byQuery($query): UserQuery
    {
        if (is_numeric($query)) {
            return $this->where('id', $query);
        }

        return $this->where('name', 'like', '%' . $query . '%');
    }
}
