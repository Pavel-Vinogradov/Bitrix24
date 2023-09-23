<?php

namespace Tizix\Bitrix24Laravel\Model\Auth\Queries;

use Illuminate\Database\Eloquent\Builder;

class RefreshTokenQuery extends Builder
{
    public function byValue($value): RefreshTokenQuery
    {
        return $this->where(['value' => $value]);
    }

    public function active(): RefreshTokenQuery
    {
        return $this->where(['active', '>', date('Y-m-d H:i:s', time())]);
    }

    public function byAccessTokenId($value): RefreshTokenQuery
    {
        return $this->where(['access_token_id' => $value]);
    }
}
