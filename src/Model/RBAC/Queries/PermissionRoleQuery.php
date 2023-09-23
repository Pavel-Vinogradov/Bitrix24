<?php

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;

class PermissionRoleQuery extends Builder
{
    public function byRoleId($roleId): PermissionRoleQuery
    {
        return $this->where(['role_id' => $roleId]);
    }

    public function byPermissionId($permissionId): PermissionRoleQuery
    {
        return $this->where(['permission_id' => $permissionId]);
    }
}
