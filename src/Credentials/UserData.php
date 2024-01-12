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
        private readonly ?string $work_position,
        private readonly ?bool $is_active = true
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'work_position' => $this->getWorkPosition(),
            'is_active' => $this->getIsActive(),
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
        return $this->work_position ?? '';
    }

    public function getPhone(): string
    {
        return $this->phone ?? '';
    }

    public function getIsActive(): bool
    {
        return $this->is_active ?? true;
    }
}
