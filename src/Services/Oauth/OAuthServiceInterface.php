<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\Oauth;

use Tizix\Bitrix24Laravel\Credentials\AccessTokenData;
use Tizix\Bitrix24Laravel\Credentials\UserData;

interface OAuthServiceInterface
{
    public function refresh(?string $refreshToken): ?AccessTokenData;

    public function getCurrentUserData(): ?UserData;
}
