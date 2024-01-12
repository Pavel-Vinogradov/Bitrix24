<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Services\User;

use Tizix\Bitrix24Laravel\Credentials\UserData;
use Tizix\Bitrix24Laravel\Exception\UnauthenticatedException;
use Tizix\Bitrix24Laravel\Services\Bitrix\BitrixRequest;

final class BitrixUserServer
{
    /**
     * @throws UnauthenticatedException
     */
    public static function getCurrentUserData(): ?UserData
    {
        $result = BitrixRequest::get('user.current');

        return self::createUserDTOFromArray($result['result'] ?? null);
    }

    /**
     * @throws UnauthenticatedException
     */
    public static function getUserById(int $value): ?UserData
    {
        $result = BitrixRequest::get('user.get', ['ID' => $value]);

        return self::createUserDTOFromArray($result['result'][0] ?? null);
    }

    private static function createUserDTOFromArray(?array $data): ?UserData
    {
        if (! $data) {
            return null;
        }

        return new UserData(
            id:(int) $data['ID'],
            name: implode(' ', array_filter([$data['LAST_NAME'] ?? null, $data['NAME'] ?? null, $data['SECOND_NAME'] ?? null])),
            email: $data['EMAIL'] ?? null,
            phone: $data['PERSONAL_PHONE'] ?? $data['WORK_PHONE'] ?? null,
            work_position: $data['WORK_POSITION'] ?? null
        );
    }

    /**
     * @throws UnauthenticatedException
     */
    public static function userSearch(string $query, ?bool $getOnlyActive = true): array
    {
        $ids = [];
        $filterByActive = $getOnlyActive || null === $getOnlyActive ? ['ACTIVE' => true] : [];

        foreach (explode(' ', $query) as $namePart) {
            $rows = BitrixRequest::get('user.search', [
                'FILTER' => array_filter(['FIND' => $namePart, 'ID' => $ids] + $filterByActive),
            ])['result'] ?? [];
            if (! $rows) {
                break;
            }

            $ids = array_column($rows, 'ID');
        }

        if (! $ids) {
            return [];
        }

        $rows = BitrixRequest::get('user.search', [
            'FILTER' => ['ID' => $ids],
        ])['result'] ?? [];

        return array_map(static fn (array $row) => new UserData(
            id: (int)$row['ID'],
            name: implode(' ', array_filter([$row['LAST_NAME'] ?? null, $row['NAME'] ?? null, $row['SECOND_NAME'] ?? null])),
            email: $row['EMAIL'],
            phone: $row['WORK_PHONE'] ?? null,
            work_position: $row['WORK_POSITION'] ?? null
        ), $rows);
    }
}
