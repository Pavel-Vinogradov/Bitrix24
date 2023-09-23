<?php

namespace Tizix\Bitrix24Laravel\Model\Auth\Queries;

use Illuminate\Database\Eloquent\Builder;

class AccessTokenQuery extends Builder
{
    public function byValue($value): AccessTokenQuery
    {
        return $this->where(['value' => $value]);
    }

    public function active(): AccessTokenQuery
    {
        return $this->where(['active', '>', date('Y-m-d H:i:s', time())]);
    }
}
