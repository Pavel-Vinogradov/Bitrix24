<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Tests\Unit;

use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tizix\Bitrix24Laravel\Credentials\AccessTokenData;
use Tizix\Bitrix24Laravel\Credentials\UserData;
use Tizix\Bitrix24Laravel\Model\User\User;
use Tizix\Bitrix24Laravel\Repository\Authentication\AuthenticationRepository;
use Tizix\Bitrix24Laravel\Repository\Token\AuthenticationTokenRepositoryInterface;
use Tizix\Bitrix24Laravel\Repository\Token\JsonAuthenticationTokenRepository;
use Tizix\Bitrix24Laravel\Repository\User\UserDataRepository;
use Tizix\Bitrix24Laravel\Services\Auth\AuthenticationService;
use Tizix\Bitrix24Laravel\Services\Oauth\BitrixOAuthService;
use Tizix\Bitrix24Laravel\Services\Oauth\OAuthServiceInterface;
use Tizix\Bitrix24Laravel\Services\User\UserService;
use Tizix\Bitrix24Laravel\Services\User\UserServiceInterface;

final class AuthenticationServiceTest extends TestCase
{
    protected Filesystem $filesystem;

    private AuthenticationService $authenticationService;

    private OAuthServiceInterface $OAuthService;

    private UserServiceInterface $userService;

    private AuthenticationTokenRepositoryInterface $tokenRepository;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $authenticationRepository = $this->createMock(AuthenticationRepository::class);
        $this->tokenRepository = $this->createMock(AuthenticationTokenRepositoryInterface::class);
        $this->OAuthService = $this->createMock(OAuthServiceInterface::class);
        $this->userService = $this->createMock(UserServiceInterface::class);

        $this->authenticationService = new AuthenticationService(
            $authenticationRepository,
            $this->tokenRepository,
            $this->OAuthService,
            $this->userService
        );
        $this->filesystem = new Filesystem();
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testIsNullLogin(): void
    {
        $accessTokenData = $this->createMock(AccessTokenData::class);
        $accessTokenData->method('getRefreshToken')->willReturn('some_refresh_token');
        $accessTokenData->method('getAccessToken')->willReturn('some_access_token');
        $userData = $this->createMock(UserData::class);
        $userData->method('getId')->willReturn(1);
        $this->OAuthService->method('getCurrentUserData')->willReturn($userData);
        $user = $this->createMock(User::class);
        $this->userService->method('getOrCreate')->willReturn(null);
        $result = $this->authenticationService->login($accessTokenData);
        $this->assertNull($result);
    }

    /**
     * @throws \Exception
     */
    public function testGetCurrentUser(): void
    {
        $authenticationTokenRepository = new JsonAuthenticationTokenRepository();
        $tokens = $this->filesystem->get(__DIR__ . '/../token.json');
        $tokens = json_decode($tokens, true);
        $authenticationTokenRepository->setAccessToken($tokens['accessToken']);
        $authenticationTokenRepository->setRefreshToken($tokens['refreshToken']);
        $userData = new AccessTokenData($tokens['accessToken'], $tokens['refreshToken']);
        $authenticationRepository = new AuthenticationRepository();
        $OAuthService = new BitrixOAuthService($authenticationRepository);
        $userDataRepository = new UserDataRepository();
        $userService = new UserService($userDataRepository);
        $authenticationService = new AuthenticationService(
            $authenticationRepository,
            $authenticationTokenRepository,
            $OAuthService,
            $userService
        );

        $user = $authenticationService->login($userData);
        $this->assertInstanceOf(User::class, $user);
        $currentUser = $this->authenticationService->getCurrentUser();
        $this->assertInstanceOf(User::class, $currentUser);
        $this->assertEquals($user, $currentUser);
    }
}
