<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\User;

use Tizix\Bitrix24Laravel\Model\User\User;

interface UserServiceInterface
{
    public function getOrCreate(int $userId): ?User;
}
