<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;

final class RolePermissionQuery extends Builder
{
    public function byRoleId($roleId): RolePermissionQuery
    {
        return $this->where(['role_id' => $roleId]);
    }

    public function byPermissionId($permissionId): RolePermissionQuery
    {
        return $this->where(['permission_id' => $permissionId]);
    }
}
