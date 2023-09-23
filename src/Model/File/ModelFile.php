<?php

namespace Tizix\Bitrix24Laravel\Model\File;

use Illuminate\Database\Eloquent\Model;

final class ModelFile extends Model
{
    protected $table = 'file.model_files';

    protected $fillable = [
        'file_id',
        'model_class',
        'model_id',
        'created_at',
    ];

    public function getFile(): File
    {
        return File::find($this->file_id);
    }
}
