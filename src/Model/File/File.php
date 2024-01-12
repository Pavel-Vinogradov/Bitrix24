<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Model\File;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $external_id
 * @property int $type_id
 * @property string $hash
 * @property string $link
 * @property int $size
 * @property string $name
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 */
class File extends Model
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

    protected function serializeDate($date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $dateFormat='Y-m-d H:i:s';

    public function getId(): int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function getType(): FileType
    {
        return (new FileType())->find($this->getTypeId());
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): Carbon|string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon|string
    {
        return $this->updated_at;
    }
}
