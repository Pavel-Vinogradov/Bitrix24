<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Client;

use Illuminate\Database\Eloquent\Model;
use Tizix\Bitrix24Laravel\Model\Client\Queries\ClientQuery;

/**
 * @property int $id
 * @property string $name
 * @property string|null $tax_payer_id
 * @property string|null $tax_registration_reason_code
 */
final class Client extends Model
{
    protected $table = 'client.clients';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'tax_payer_id',
        'tax_registration_reason_code',
    ];

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
        return $this->tax_payer_id;
    }

    public function getTaxRegistrationReasonCode(): ?string
    {
        return $this->tax_registration_reason_code;
    }

    public function newEloquentBuilder($query): ClientQuery
    {
        return new ClientQuery($query);
    }
}
