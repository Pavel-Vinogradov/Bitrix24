<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\Util;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $model_class
 * @property int $model_id
 * @property string|null $action
 * @property string|null $previous_value
 * @property string|null $new_value
 * @property Carbon|string $created_at
 */
final class ModelChangeLog extends Model
{
    protected $table = 'util.model_change_log';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'model_class',
        'model_id',
        'previous_value',
        'new_value',
        'action'
    ];

    protected function serializeDate($date): bool|int|string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getId(): int
    {
        return $this->id;
    }


}
