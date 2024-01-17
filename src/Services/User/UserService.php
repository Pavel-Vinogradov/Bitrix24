<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\User;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Tizix\Bitrix24Laravel\Model\User\User;
use Tizix\Bitrix24Laravel\Repository\User\UserDataRepositoryInterface;
use RuntimeException;

final class UserService implements UserServiceInterface
{
    private UserDataRepositoryInterface $userDataRepository;

    public function __construct(
        UserDataRepositoryInterface $userDataRepository
    ) {
        $this->userDataRepository = $userDataRepository;
    }

    /**
     * @throws Exception
     */
    public function getOrCreate(int $userId): User
    {
        $userDataFromRepo = $this->userDataRepository->getById($userId);
        if (!$userDataFromRepo) {
            throw new ModelNotFoundException('Такого пользователя не существует');
        }

        $attributes = [
            'name' => $userDataFromRepo->getName(),
            'email' => $userDataFromRepo->getEmail(),
            'phone' => $userDataFromRepo->getPhone(),
            'work_position' => $userDataFromRepo->getWorkPosition(),
            'is_active' => $userDataFromRepo->getIsActive(),
        ];

        try {
            $user = (new User())->firstWhere('bitrix24_id', $userId);
            if ($user === null) {
                $attributes['bitrix24_id'] = $userId;
                $user = (new User())->create($attributes);
            } else {
                $user->fill($attributes)->save();
            }
        } catch (QueryException $e) {
            Log::error("Ошибка сохранения пользователя: {$e->getMessage()}");
            throw new RuntimeException('Ошибка сохранения пользователя: ' . $e->getMessage());
        }

        return $user;
    }


}
