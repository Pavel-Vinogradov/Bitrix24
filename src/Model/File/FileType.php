<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\File;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
final class FileType extends Model
{
    protected $table = 'file.file_types';

    protected $fillable = [
        'name',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
