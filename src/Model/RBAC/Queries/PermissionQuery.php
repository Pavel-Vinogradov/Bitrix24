<?php

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;

class PermissionQuery extends Builder
{
    public function byKey($key): PermissionQuery
    {
        return $this->where(['key' => $key]);
    }
}
