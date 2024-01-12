<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Auth\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

final class RefreshTokenQuery extends Builder
{
    public function byRefreshToken($value): RefreshTokenQuery
    {
        return $this->where(['refresh_token' => $value]);
    }

    public function active(): RefreshTokenQuery
    {
        return $this->where('expires_at', '>', Carbon::now());
    }

    public function byAccessTokenId($accessTokenId): RefreshTokenQuery
    {
        return $this->where(['access_token_id' => $accessTokenId]);
    }
}
