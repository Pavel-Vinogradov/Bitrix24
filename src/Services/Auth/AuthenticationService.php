<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\Auth;

use Exception;
use RuntimeException;
use Tizix\Bitrix24Laravel\Credentials\AccessTokenData;
use Tizix\Bitrix24Laravel\Exception\UnauthenticatedException;
use Tizix\Bitrix24Laravel\Model\Auth\AccessToken;
use Tizix\Bitrix24Laravel\Model\Auth\RefreshToken;
use Tizix\Bitrix24Laravel\Model\User\User;
use Tizix\Bitrix24Laravel\Repository\Authentication\AuthenticationRepository;
use Tizix\Bitrix24Laravel\Repository\Token\AuthenticationTokenRepositoryInterface;
use Tizix\Bitrix24Laravel\Services\Oauth\OAuthServiceInterface;
use Tizix\Bitrix24Laravel\Services\User\UserServiceInterface;


final class AuthenticationService implements AuthenticationServiceInterface
{
    private AuthenticationRepository $authenticationRepository;

    private AuthenticationTokenRepositoryInterface $authenticationTokenRepository;

    private OAuthServiceInterface $OAuthService;

    private UserServiceInterface $userService;

    public function __construct(
        AuthenticationRepository $authenticationRepository,
        AuthenticationTokenRepositoryInterface $authenticationTokenRepository,
        OAuthServiceInterface $OAuthService,
        UserServiceInterface $userService
    ) {
        $this->authenticationRepository = $authenticationRepository;
        $this->authenticationTokenRepository = $authenticationTokenRepository;
        $this->OAuthService = $OAuthService;
        $this->userService = $userService;
    }

    /**
     * @throws Exception|UnauthenticatedException
     */
    public function login(?AccessTokenData $accessTokenData): ?User
    {
        if (! $accessTokenData) {
            throw new RuntimeException('Отсутствуют данные для авторизации');
        }
        $result = $this->authenticationTokenRepository->setRefreshToken($accessTokenData->getRefreshToken());
        if (empty($result)) {
            throw new UnauthenticatedException('Ошибка авторизации');
        }
        $userData = $this->OAuthService->getCurrentUserData();
        if (! $userData) {
            throw new RuntimeException('Ошибка получения данных пользователя');
        }

        $user = $this->userService->getOrCreate($userData->getId());
        $accessToken = $this->createAccessTokenModel($user, $accessTokenData->getAccessToken());
        $refreshToken = $this->createRefreshTokenModel($user, $accessToken, $accessTokenData->getRefreshToken());

        return $user;
    }

    /**
     * @throws UnauthenticatedException
     */
    public function getCurrentUser(): ?User
    {
        return $this->getAccessToken()->getUser();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function verify(): bool
    {
        $this->getAccessToken();

        return true;
    }

    /**
     * @throws Exception
     */
    public function refresh(?string $refreshToken): ?User
    {
        return $this->login($this->OAuthService->refresh($refreshToken));
    }

    /**
     * @throws Exception
     */
    private function createAccessTokenModel(?User $user, string $accessToken): ?AccessToken
    {
        return $this->authenticationRepository->createAccessToken($user, $accessToken);
    }

    /**
     * @throws Exception
     */
    private function createRefreshTokenModel(?User $user, ?AccessToken $accessToken, string $getRefreshToken): ?RefreshToken
    {
        return $this->authenticationRepository->createRefreshToken($user, $accessToken, $getRefreshToken);
    }

    /**
     * @throws UnauthenticatedException
     * @throws Exception
     */
    private function getAccessToken(): AccessToken
    {
        $accessTokenModel = $this->authenticationRepository
            ->getAccessToken($this->authenticationTokenRepository->getAccessToken());

        if (null === $accessTokenModel) {
            throw new UnauthenticatedException();
        }

        $refreshToken = $this->authenticationTokenRepository->getRefreshToken();
        if ($this->refresh($refreshToken)) {
            throw new UnauthenticatedException();
        }

        return $accessTokenModel;
    }
}
