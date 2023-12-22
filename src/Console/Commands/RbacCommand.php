<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Tizix\Bitrix24Laravel\Model\RBAC\Role;
use Tizix\Bitrix24Laravel\Services\Oauth\OAuthServiceInterface;
use Tizix\Bitrix24Laravel\Services\User\UserRoleService;

final class RbacCommand extends Command
{
    protected $signature = 'rbac:create-role {name}';

    protected $description = 'Создание роли администратора для текущего пользователя через консоль';

    private OAuthServiceInterface $oauthService;

    private UserRoleService $userRoleService;

    public function __construct(OAuthServiceInterface $oauthService, UserRoleService $userRoleService)
    {
        parent::__construct();
        $this->oauthService = $oauthService;
        $this->userRoleService = $userRoleService;
    }

    public function handle(): int
    {
        $name = $this->argument('name');

        $currentUserData = $this->oauthService->getCurrentUserData();

        if (! $currentUserData) {
            $this->error('Не удается получить текущего пользователя');

            return CommandAlias::FAILURE;
        }

        $role = Role::byKey($name)->first();

        if (! $role) {
            $this->error('Роль с названием \'' . $name . '\' не найдена');

            return CommandAlias::FAILURE;
        }

        $this->userRoleService->create(
            $currentUserData->getId(),
            $role->getId()
        );

        $this->info('Роль \'' . $name . '\' успешно добавлена текущему пользователю');

        return CommandAlias::SUCCESS;
    }
}
