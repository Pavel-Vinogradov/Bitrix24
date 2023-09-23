<?php

use Illuminate\Database\Eloquent\Model;

interface FileRepositoryInterface
{
    public function getAllFilesData(Model $model): array;

    public function modelHasFiles(Model $model): bool;
}
