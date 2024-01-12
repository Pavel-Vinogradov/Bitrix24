<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;
use Tizix\Bitrix24Laravel\Model\RBAC\RolePermission;
use Tizix\Bitrix24Laravel\Model\RBAC\UserRole;

final class RoleQuery extends Builder
{
    public function byKey($key): RoleQuery
    {
        return $this->where(['key' => $key]);
    }

    public function byName($name): RoleQuery
    {
        return $this->where(['name' => $name]);
    }

    public function byPermissionId($permissionId): RoleQuery
    {
        return $this->where(['id' => RolePermission::select('role_id')->byPermissionId($permissionId)]);
    }

    public function byUserid($userid): RoleQuery
    {
        return $this->where(['id' => UserRole::select('role_id')->byUserid($userid)]);
    }
}
