<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\User;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Tizix\Bitrix24Laravel\Model\RBAC\Role;
use Tizix\Bitrix24Laravel\Model\RBAC\UserRole;
use Tizix\Bitrix24Laravel\Repository\User\UserRoleRepositoryInterface;

final class UserRoleService
{
    private UserRoleRepositoryInterface $userRoleRepository;

    public function __construct()
    {
        $this->userRoleRepository = App::make(UserRoleRepositoryInterface::class);
    }

    private function validate(int $userId, int $roleId): \Illuminate\Validation\Validator
    {
        return Validator::make([
            'userId' => $userId,
            'roleId' => $roleId,
        ], [
            'userId' => [
                'required',
                'integer',
                Rule::unique(UserRole::class, 'user_id')->where('role_id', $roleId)->ignore($userId),
            ],
            'roleId' => [
                'required',
                'integer',
                Rule::exists(Role::class, 'id'),
            ],
        ], [
            'userId.required' => 'User ID обязательно для заполнения',
            'userId.integer' => 'User ID должно быть целым числом',
            'userId.unique' => 'У пользователя уже есть эта роль',
            'roleId.required' => 'Role ID обязательно для заполнения',
            'roleId.integer' => 'Role ID должно быть целым числом',
            'roleId.exists' => 'Такой роли не существует',
        ]);
    }

    public function create(int $userId, int $roleId): UserRole
    {
        $validationResult = $this->validate($userId, $roleId);
        if (!$validationResult) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'errors' => [
                        'type' => 'validation',
                        'message' => $validationResult->errors()->first()[0] ?? '',
                        'attribute' => $validationResult->errors()->keys()->first() ?? '',
                    ],
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        if (!App::make(UserServiceInterface::class)->getOrCreate($userId)) {
            throw new HttpResponseException(
                response()->json(
                    [
                        'status' => false,
                        'errors' => [
                            'type' => 'logic',
                            'message' => "Ошибка получения данных о пользователе #{$userId}",
                        ],
                    ],
                )
            );
        }

        return $this->userRoleRepository->create($userId, $roleId);

    }
}
