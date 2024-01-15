<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\User;

use Tizix\Bitrix24Laravel\Credentials\UserData;
use Tizix\Bitrix24Laravel\Exception\UnauthenticatedException;
use Tizix\Bitrix24Laravel\Model\User\User;
use Tizix\Bitrix24Laravel\Services\User\BitrixUserServer;

final class UserDataRepository implements UserDataRepositoryInterface
{
    private const USER_SEARCH_LIMIT = 10;

    /**
     * @throws UnauthenticatedException
     */
    public function getById(int $value): ?UserData
    {
        if ($user = User::firstWhere('bitrix_id',$value)) {
            return new UserData(
                id: $user->getId(),
                name: $user->getName(),
                email: $user->getEmail(),
                phone: $user->getPhone(),
                workPosition: $user->getWorkPosition(),
                isActive: $user->getIsActive(),
            );
        }

        return BitrixUserServer::getUserById($value);
    }

    /**
     * @throws UnauthenticatedException
     */
    public function search(string $query, array $additionalFilter = [], ?bool $isActive = null): array
    {
        $users = User::byName($query)
            ->byActive($isActive)
            ->limit(self::USER_SEARCH_LIMIT)
            ->get()->all();
        $output = array_map(
            static fn (User $user) => new UserData(
                id: $user->getId(),
                name: $user->getName(),
                email: $user->getEmail(),
                phone: $user->getPhone(),
                workPosition: $user->getWorkPosition(),
                isActive: $user->getIsActive(),
            ),
            $users
        );
         if ($moreUsersToFetch = self::USER_SEARCH_LIMIT - count($users)) {
            $bitrixUsers = array_slice(BitrixUserServer::userSearch($query, $isActive), 0, $moreUsersToFetch);
            $output = array_merge($output, $bitrixUsers);
        }
        return array_values(array_unique($output, SORT_REGULAR));

    }
}
