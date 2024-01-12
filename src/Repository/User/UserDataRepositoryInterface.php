<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\User;

use Tizix\Bitrix24Laravel\Credentials\UserData;

interface UserDataRepositoryInterface
{
    public function getById(int $value): ?UserData;

    public function search(string $query, array $additionalFilter = []): array;
}
