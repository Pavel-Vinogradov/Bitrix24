<?php

namespace Tizix\Bitrix24Laravel\Model\File;

use Illuminate\Database\Eloquent\Model;

final class File extends Model
{
    protected $table = 'file.files';

    protected $fillable = [
        'external_id',
        'type_id',
        'hash',
        'link',
        'size',
        'name',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLink()
    {
        return $this->link;
    }
}
