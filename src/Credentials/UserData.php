<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Credentials;

final class UserData
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly ?string $email,
        private readonly ?string $phone,
        private readonly ?string $workPosition,
        private readonly ?bool $isActive = true
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'workPosition' => $this->getWorkPosition(),
            'isActive' => $this->getIsActive(),
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function getWorkPosition(): string
    {
        return $this->workPosition ?? '';
    }

    public function getPhone(): string
    {
        return $this->phone ?? '';
    }

    public function getIsActive(): bool
    {
        return $this->isActive ?? true;
    }
}
