<?php

namespace Tizix\Bitrix24Laravel\Model\Client\Queries;

use Illuminate\Database\Eloquent\Builder;

class ClientQuery extends Builder
{
    public function byId($value): ClientQuery
    {
        return $this->where(['id' => $value]);
    }

    public function byName($value): ClientQuery
    {
        return $this->whereFullText('name', $value);
    }

    public function bySearch($value): ClientQuery
    {
        return $this->where(function ($query) use ($value) {
            $query->whereFullText('name', $value)
                ->orWhere(['tax_payer_id' => $value])
                ->orWhere(['tax_registration_reason_code' => $value]);
        });
    }
}
