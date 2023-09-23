<?php

namespace Tizix\Bitrix24Laravel\Model\RBAC\Queries;

use Illuminate\Database\Eloquent\Builder;

class RoleQuery extends Builder
{
    public function byKey($key): RoleQuery
    {
        return $this->where(['key' => $key]);
    }
}
