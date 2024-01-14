<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\Token;

final class CookieAuthenticationTokenRepository implements AuthenticationTokenRepositoryInterface
{
    private const ACCESS_TOKEN_KEY = 'tokens_access';
    private const REFRESH_TOKEN_KEY = 'tokens_refresh';
    public function getAccessToken(): ?string
    {
        return $this->get(self::ACCESS_TOKEN_KEY);
    }

    public function getRefreshToken(): ?string
    {
        return $this->get(self::REFRESH_TOKEN_KEY);
    }

    public function setAccessToken(string $value): string
    {

        return $this->set(self::ACCESS_TOKEN_KEY, $value, config('bitrix24.authentication.ttl.accessToken'));
    }

    public function setRefreshToken(string $value): string
    {
        return $this->set(self::REFRESH_TOKEN_KEY, $value, config('bitrix24.authentication.ttl.refreshToken'));
    }
    private function get(string $name)
    {
        return $_COOKIE[$name] ?? null;
    }
    private function set(string $name, string $value, int $ttl): string
    {
        $this->removeCookie($name);

        setcookie($name, $value, [
            'expires' => strtotime("+{$ttl} seconds"),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None'
        ]);
        $_COOKIE[$name] = $value;
        return $value;
    }
    private function removeCookie(string $name): void
    {
        setcookie($name, '', 1, '/');
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
        }
    }

}
