<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\Bitrix;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tizix\Bitrix24Laravel\Exception\UnauthenticatedException;
use Tizix\Bitrix24Laravel\Repository\Token\AuthenticationTokenRepositoryInterface;
use Tizix\Bitrix24Laravel\Services\Auth\AuthenticationServiceInterface;

final class BitrixRequest
{
    /**
     * @throws UnauthenticatedException
     */
    public static function get(string $endpoint, array $params = []): ?array
    {
        return self::callApi(static function () use ($endpoint, $params) {
            $response = Http::get(self::getUrl($endpoint), [
                    'auth' => self::getAuthenticationTokenRepository()->getAccessToken(),
                    'http_errors' => false
                ]+$params);

            return $response->json();
        });
    }

    /**
     * @throws UnauthenticatedException
     */
    private static function callApi(callable $callback): ?array
    {
        $try = static function () use ($callback) {
            $result = $callback();
            $error = $result['error'] ?? null;

            return $error === 'expired_token' ? null : $result;
        };

        if ($result = $try()) {
            return $result;
        }

        self::getAuthenticationService()->refresh(
            self::getAuthenticationTokenRepository()->getRefreshToken()
        );

        if ($result = $try()) {
            return $result;
        }

        throw new UnauthenticatedException();
    }

    public static function getUrl(string $endpoint): string
    {
        return config('bitrix24.host') . "/rest/{$endpoint}.json";
    }

    private static function getAuthenticationTokenRepository(): AuthenticationTokenRepositoryInterface
    {
        return App::make(AuthenticationTokenRepositoryInterface::class);
    }

    private static function getAuthenticationService(): AuthenticationServiceInterface
    {
        return App::make(AuthenticationServiceInterface::class);
    }
}
