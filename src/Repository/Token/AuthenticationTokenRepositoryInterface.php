<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\Token;

interface AuthenticationTokenRepositoryInterface
{
    public function getAccessToken(): ?string;

    public function getRefreshToken(): ?string;

    public function setAccessToken(string $value): string;

    public function setRefreshToken(string $value): string;
}
