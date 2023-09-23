<?php

namespace Tizix\Bitrix24Laravel\Model\User\Queries;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    public function byId(int|null|Builder $value): UserQuery
    {
        return $this->where(['id' => $value]);
    }

    public function byName(string|null|Builder $value): UserQuery
    {
        return $this->whereFullText('name', $value);
    }
}
