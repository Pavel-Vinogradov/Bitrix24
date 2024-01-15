<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\User;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tizix\Bitrix24Laravel\Model\User\User;
use Tizix\Bitrix24Laravel\Repository\User\UserDataRepositoryInterface;

final class UserService implements UserServiceInterface
{
    private UserDataRepositoryInterface $userDataRepository;

    public function __construct(
        UserDataRepositoryInterface $userDataRepository
    )
    {
        $this->userDataRepository = $userDataRepository;
    }

    /**
     * @throws Exception
     */
    public function getOrCreate(int $userId): User
    {
        $userData = $this->userDataRepository->getById($userId);
        if (!$userData) {
            throw new ModelNotFoundException('Такого пользователя не существует');
        }

        try {
            $user = User::updateOrCreate(
                ['bitrix_id' => $userData->getId()],
                [
                    'name' => $userData->getName(),
                    'email' => $userData->getEmail(),
                    'phone' => $userData->getPhone(),
                    'work_position' => $userData->getWorkPosition(),
                    'is_active' => $userData->getIsActive(),
                    'is_bitrix24_user' => true
                ]
            );
        } catch (Exception $e) {
            throw new \RuntimeException('Ошибка сохранения пользователя: ' . $e->getMessage());
        }

        return $user;
    }
}
