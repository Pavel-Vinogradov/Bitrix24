<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\Authentication;

use Carbon\Carbon;
use Exception;
use Tizix\Bitrix24Laravel\Model\Auth\AccessToken;
use Tizix\Bitrix24Laravel\Model\Auth\RefreshToken;
use Tizix\Bitrix24Laravel\Model\User\User;
use RuntimeException;

final class AuthenticationRepository
{
    private AccessToken $accessToken;

    private RefreshToken $refreshToken;

    public function __construct()
    {
        $this->accessToken = new AccessToken();
        $this->refreshToken = new RefreshToken();
    }

    public function getAccessToken(?string $value): ?AccessToken
    {
        return $this->accessToken->byAccessToken($value)->active()->first();
    }
    public function getRefreshToken(?string $value): ?RefreshToken
    {
        return $this->refreshToken->byRefreshToken($value)->active()->first();
    }
    /**
     * @throws Exception
     */
    public function createAccessToken(?User $user, string $value): ?AccessToken
    {
        if (null === $user) {
            return null;
        }
        try {
            return $this->accessToken->create([
                'user_id' => $user->getId(),
                'access_token' => $value,
                'expires_at' => Carbon::now()->addSeconds(config('bitrix24.authentication.ttl.accessToken')),
                'created_at' => Carbon::now()
            ]);
        } catch (Exception $exception) {
            throw new RuntimeException('Ошибка сохранения токена доступа ' . $exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function createRefreshToken(?User $user, ?AccessToken $accessToken, string $getRefreshToken): ?RefreshToken
    {
        if (null === $user || null === $accessToken) {
            return null;
        }
        try {
            return $this->refreshToken->create([
                'user_id' => $user->getId(),
                'access_token_id' => $accessToken->getId(),
                'refresh_token' => $getRefreshToken,
                'expires_at' => Carbon::now()->addSeconds(config('bitrix24.authentication.ttl.refreshToken')),
                'created_at' => Carbon::now()
            ]);
        } catch (Exception $exception) {
            throw new RuntimeException('Ошибка сохранения токена обновления ' . $exception->getMessage());
        }
    }
}
