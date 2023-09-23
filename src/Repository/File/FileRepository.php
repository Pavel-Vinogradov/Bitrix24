<?php

use Illuminate\Database\Eloquent\Model;
use Tizix\Bitrix24Laravel\Model\Auth\Queries\ModelFile;

final class FileRepository implements FileRepositoryInterface
{
    public function getAllFilesData(Model $model): array
    {
        $modelFiles = ModelFile::where('model_class', '=', get_class($model))->where('model_id', '=', $model->getId())->get();
        $output = [];

        foreach ($modelFiles as $modelFile) {
            $file = $modelFile->getFile();
            $output[] = [
                'id' => $file->getId(),
                'name' => $file->getName(),
                'link' => $file->getLink(),
                'uploadedAt' => $modelFile->created_at->format('d.m.Y H:i:s'),
            ];
        }

        return $output;
    }

    public function modelHasFiles(Model $model): bool
    {
        return ModelFile::where('model_class', '=', get_class($model))->where('model_id', '=', $model->getId())->exists();

    }
}
