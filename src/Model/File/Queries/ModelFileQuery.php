<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\File\Queries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


final class ModelFileQuery extends Builder
{
    public function byModel(Model $model): ModelFileQuery
    {
        return $this
            ->byModelClass($model::class)
            ->byModelId($model->id);
    }

    public function byModelClass($modelClass): ModelFileQuery
    {
        return $this->where(['model_class' => $modelClass]);
    }

    public function byModelId($modelId): ModelFileQuery
    {

        return $this->where(['model_id' => $modelId]);
    }

    public function byFileId($fileId): ModelFileQuery
    {
        return $this->whereIn('file_id' ,$fileId);
    }
}
