<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Auth\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Tizix\Bitrix24Laravel\Model\Auth\AccessToken;

/**@mixin  AccessToken */
final class AccessTokenQuery extends Builder
{
    public function byAccessToken($value): AccessTokenQuery
    {
        return $this->where(['access_token' => $value]);
    }

    public function active(): AccessTokenQuery
    {
        return $this->where('expires_at', '>', Carbon::now());
    }
}
