<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\Oauth;

use Exception;
use Tizix\Bitrix24Laravel\Credentials\AccessTokenData;
use Tizix\Bitrix24Laravel\Credentials\UserData;
use Tizix\Bitrix24Laravel\Exception\UnauthenticatedException;
use Tizix\Bitrix24Laravel\Repository\Authentication\AuthenticationRepository;
use Tizix\Bitrix24Laravel\Services\Bitrix\OauthAuthorizeService;
use Tizix\Bitrix24Laravel\Services\User\BitrixUserServer;

final class BitrixOAuthService implements OAuthServiceInterface
{
    private AuthenticationRepository $repository;

    public function __construct(
        AuthenticationRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function refresh(?string $refreshToken): ?AccessTokenData
    {
        if (! $refreshToken) {
            return null;
        }

        $authenticationTokenPair = OauthAuthorizeService::refreshToken($refreshToken);
        $refreshTokenModel = $this->repository->getRefreshToken($refreshToken);
        if ($refreshTokenModel && ! $refreshTokenModel->kill()) {
            return null;
        }

        return $authenticationTokenPair;

    }

    /**
     * @throws UnauthenticatedException
     */
    public function getCurrentUserData(): ?UserData
    {
        return BitrixUserServer::getCurrentUserData();

    }
}
