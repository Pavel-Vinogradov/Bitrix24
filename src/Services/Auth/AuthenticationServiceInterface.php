<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\Auth;

use Tizix\Bitrix24Laravel\Credentials\AccessTokenData;
use Tizix\Bitrix24Laravel\Model\User\User;

interface AuthenticationServiceInterface
{
    public function login(?AccessTokenData $accessTokenData): ?User;

    public function getCurrentUser(): ?User;

    public function verify(): bool;

    public function refresh(?string $refreshToken);
}
