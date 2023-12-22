<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\Token;

use Illuminate\Http\Request;
use Tizix\Bitrix24Laravel\Enum\HeaderEnum;

final class HeaderAuthenticationTokenRepository implements AuthenticationTokenRepositoryInterface
{
    private ?string $accessToken = null;

    private ?string $refreshToken = null;

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getAccessToken(): ?string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }
        $accessToken = $this->request->header(HeaderEnum::X_ACCESS_TOKEN->value) ?: null;
        if (null === $accessToken) {
            $accessToken = $this->request->query('AUTH_ID') ?: null;
        }

        return $accessToken;
    }

    public function getRefreshToken(): ?string
    {
        if ($this->refreshToken) {
            return $this->refreshToken;
        }
        $refreshToken = $this->request->header(HeaderEnum::X_REFRESH_TOKEN->value) ?: null;
        if (null === $refreshToken) {
            $refreshToken = $this->request->query('REFRESH_ID') ?: null;
        }

        return $refreshToken;
    }

    public function setAccessToken(string $value): string
    {
        return $this->accessToken = $value;
    }

    public function setRefreshToken(string $value): string
    {
        return $this->refreshToken = $value;
    }
}
