<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Console\Commands;

use Illuminate\Console\Command;
use Tizix\Bitrix24Laravel\Repository\Token\AuthenticationTokenRepositoryInterface;
use Tizix\Bitrix24Laravel\Services\Auth\AuthenticationServiceInterface;

final class AuthCommand extends Command
{
    protected $signature = 'regen:auth';

    protected $description = 'Refreshes and saves authentication token';

    protected AuthenticationServiceInterface $authService;

    protected AuthenticationTokenRepositoryInterface $tokenRepository;

    public function __construct(
        AuthenticationServiceInterface $authService,
        AuthenticationTokenRepositoryInterface $tokenRepository
    ) {
        parent::__construct();

        $this->authService = $authService;
        $this->tokenRepository = $tokenRepository;
    }

    public function handle(): void
    {
        $refreshToken = $this->authService->refresh(
            $this->tokenRepository->getRefreshToken()
        );

        if ($refreshToken) {
            $this->info('Refresh token saved');
        } else {
            $this->error('Refresh token not saved');
        }
    }
}
