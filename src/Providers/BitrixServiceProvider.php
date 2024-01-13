<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Tizix\Bitrix24Laravel\Console\Commands\AuthCommand;
use Tizix\Bitrix24Laravel\Console\Commands\RbacCommand;
use Tizix\Bitrix24Laravel\Repository\Authentication\AuthenticationRepository;
use Tizix\Bitrix24Laravel\Repository\Token\AuthenticationTokenRepositoryInterface;
use Tizix\Bitrix24Laravel\Repository\Token\JsonAuthenticationTokenRepository;
use Tizix\Bitrix24Laravel\Repository\User\UserDataRepository;
use Tizix\Bitrix24Laravel\Repository\User\UserDataRepositoryInterface;
use Tizix\Bitrix24Laravel\Repository\User\UserRoleRepository;
use Tizix\Bitrix24Laravel\Repository\User\UserRoleRepositoryInterface;
use Tizix\Bitrix24Laravel\Services\Auth\AuthenticationService;
use Tizix\Bitrix24Laravel\Services\Auth\AuthenticationServiceInterface;
use Tizix\Bitrix24Laravel\Services\Oauth\BitrixOAuthService;
use Tizix\Bitrix24Laravel\Services\Oauth\OAuthServiceInterface;
use Tizix\Bitrix24Laravel\Services\User\UserService;
use Tizix\Bitrix24Laravel\Services\User\UserServiceInterface;

final class BitrixServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(OAuthServiceInterface::class, BitrixOAuthService::class);
        $this->app->bind(UserDataRepositoryInterface::class, UserDataRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuthenticationRepository::class, AuthenticationRepository::class);
        $this->app->bind(UserRoleRepositoryInterface::class, UserRoleRepository::class);
        $this->app->when(AuthCommand::class)
            ->needs(AuthenticationTokenRepositoryInterface::class)
            ->give(fn () => new JsonAuthenticationTokenRepository());
        $this->commands(
            [
                AuthCommand::class,
                RbacCommand::class,
            ]
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/bitrix24.php' => config_path('bitrix24.php'),
        ], 'bitrix24-config');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
