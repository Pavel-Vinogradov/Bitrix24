<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Repository\Token;

use InvalidArgumentException;

final class JsonAuthenticationTokenRepository implements AuthenticationTokenRepositoryInterface
{
    private const ACCESS_TOKEN = 'access';

    private const REFRESH_TOKEN = 'refresh';

    /**
     * @throws \JsonException
     */
    public function getAccessToken(): ?string
    {
        return $this->getToken(self::ACCESS_TOKEN);
    }

    /**
     * @throws \JsonException
     */
    private function getToken(string $tokenName): ?string
    {
        $json = file_get_contents($this->getFilePath());
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return $data["{$tokenName}Token"] ?? null;
    }

    private function getFilePath(): string
    {
        return base_path('tokens.json');
    }

    /**
     * @throws \JsonException
     */
    public function getRefreshToken(): ?string
    {
        return $this->getToken(self::REFRESH_TOKEN);
    }

    public function setAccessToken(string $value): string
    {
        return $this->setToken(self::ACCESS_TOKEN, $value);
    }

    /**
     * @throws \JsonException
     */
    private function setToken(string $tokenName, string $value): string
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Missing value for {$tokenName} token");
        }

        $json = file_get_contents($this->getFilePath());
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $data["{$tokenName}Token"] = $value;
        file_put_contents($this->getFilePath(), json_encode($data, JSON_THROW_ON_ERROR));

        return $value;
    }

    /**
     * @throws \JsonException
     */
    public function setRefreshToken(string $value): string
    {
        return $this->setToken(self::REFRESH_TOKEN, $value);
    }
}
