<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Credentials;

use Tizix\Bitrix24Laravel\Model\Client\Client;

final class ClientData
{
    private int $id;

    private string $name;

    private ?string $taxPayerId;

    private ?string $taxRegistrationReasonCode;

    public function __construct(
        int $id,
        string $name,
        ?string $taxPayerId,
        ?string $taxRegistrationReasonCode,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->taxPayerId = $taxPayerId;
        $this->taxRegistrationReasonCode = $taxRegistrationReasonCode;
    }

    public static function fromClient(Client $client): ClientData
    {
        return new self(
            id: $client->getId(),
            name: $client->getName(),
            taxPayerId: $client->getTaxPayerId(),
            taxRegistrationReasonCode: $client->getTaxRegistrationReasonCode()
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTaxPayerId(): ?string
    {
        return $this->taxPayerId;
    }

    public function getTaxRegistrationReasonCode(): ?string
    {
        return $this->taxRegistrationReasonCode;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'taxPayerId' => $this->getTaxPayerId(),
            'taxRegistrationReasonCode' => $this->getTaxRegistrationReasonCode(),
        ];
    }
}
