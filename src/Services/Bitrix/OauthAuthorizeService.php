<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\Bitrix;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tizix\Bitrix24Laravel\Credentials\AccessTokenData;
use Tizix\Bitrix24Laravel\Exception\UndefinedOauthDataException;
use RuntimeException;

final class OauthAuthorizeService
{
    private const OAUTH_DATA_CACHE_KEY = 'bitrix:oauth-data';

    /**
     * @throws Exception
     */
    public static function refreshToken(string $token): AccessTokenData
    {

        $response = Http::get(config('bitrix24.oauthUrl'), [
            'client_id' => config('bitrix24.client_id'),
            'grant_type' => 'refresh_token',
            'client_secret' => config('bitrix24.client_secret'),
            'refresh_token' => $token,
            'http_errors' => false,
        ]);
        $json = $response->json() ?: '[]';
        $data = $json;
        if ($error = ($data['error'] ?? null)) {
            Log::error("Ошибка обновления токенов доступа: {$error}");
            throw new RuntimeException("Необработанная ошибка обновления токенов доступа: {$error}");
        }

        return new AccessTokenData(
            accessToken: $data['access_token'],
            refreshToken: $data['refresh_token'],
        );
    }

    private static function saveOauthToken(array $data): void
    {
        Cache::forget(self::OAUTH_DATA_CACHE_KEY, $data);
    }

    /**
     * @throws UndefinedOauthDataException
     */
    private static function getCachedToken(): AccessTokenData
    {
        $oauthData = Cache::get(self::OAUTH_DATA_CACHE_KEY);
        if ($oauthData === null) {
            throw new UndefinedOauthDataException('Токен доступа не определен');
        }

        return new AccessTokenData(
            accessToken: Arr::get($oauthData, 'access_token'),
            refreshToken: Arr::get($oauthData, 'refresh_token')
        );

    }
}
