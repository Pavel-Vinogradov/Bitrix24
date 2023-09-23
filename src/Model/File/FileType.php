<?php

namespace Tizix\Bitrix24Laravel\Model\File;

use Illuminate\Database\Eloquent\Model;

final class FileType extends Model
{
    protected $table = 'file.file_types';

    protected $fillable = [
        'name',
    ];
}
