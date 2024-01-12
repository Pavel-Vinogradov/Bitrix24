<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\File;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tizix\Bitrix24Laravel\Model\File\Queries\ModelFileQuery;

/**
 * @property int $id
 * @property int $file_id
 * @property string $model_class
 * @property int $model_id
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 */
class ModelFile extends Model
{
    use HasFactory;
    protected $table = 'file.model_files';

    protected $fillable = [
        'file_id',
        'model_class',
        'model_id',
        'created_at',
    ];
    protected $dateFormat='Y-m-d H:i:s';

    protected function serializeDate($date): bool|int|string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getFile(): File
    {
        return File::find($this->file_id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getModelClass(): string
    {
        return $this->model_class;
    }

    public function getModelId(): int
    {
        return $this->model_id;
    }

    public function getCreatedAt(): Carbon|string
    {
        return $this->created_at;
    }

    public function newEloquentBuilder($query): ModelFileQuery
    {
        return new ModelFileQuery($query);
    }
}
