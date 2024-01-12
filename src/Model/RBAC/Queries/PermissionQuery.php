<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;
use Tizix\Bitrix24Laravel\Model\RBAC\RolePermission;

final class PermissionQuery extends Builder
{
    public function byKey($key): PermissionQuery
    {
        return $this->where(['key' => $key]);
    }

    public function byName($name): PermissionQuery
    {
        return $this->where(['name' => $name]);
    }

    public function byRoleId($roleId): PermissionQuery
    {
        return $this->where(['id' => RolePermission::select('permission_id')->byRoleId($roleId)]);
    }
}
