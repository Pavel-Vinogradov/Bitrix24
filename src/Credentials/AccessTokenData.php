<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Credentials;

final class AccessTokenData
{
    private string $accessToken;

    private string $refreshToken;

    public function __construct(
        string $accessToken,
        string $refreshToken
    ) {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
