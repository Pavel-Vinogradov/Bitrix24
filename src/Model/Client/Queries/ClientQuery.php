<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Client\Queries;

use Illuminate\Database\Eloquent\Builder;

final class ClientQuery extends Builder
{
    public function byId($id): ClientQuery
    {
        return $this->where(['id' => $id]);
    }

    public function byName($value): ClientQuery
    {
        return $this->whereFullText('name', $value, ['language' => 'russian']);
    }

    public function bySearch($value): ClientQuery
    {
        return $this->where(function ($query) use ($value): void {
            $query->whereFullText('name', $value)
                ->orWhere(['tax_payer_id' => $value])
                ->orWhere(['tax_registration_reason_code' => $value]);
        });
    }
}
