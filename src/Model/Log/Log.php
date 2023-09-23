<?php

namespace Tizix\Bitrix24Laravel\Model\Log;

use Illuminate\Database\Eloquent\Model;

final class Log extends Model
{
    protected $fillable = [
        'user_id',
        'model_class',
        'model_id',
        'previous_value',
        'new_value',
    ];
}
