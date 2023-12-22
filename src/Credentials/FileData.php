<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Credentials;

use Tizix\Bitrix24Laravel\Enum\FileType;

class FileData
{
    public function __construct(
        private readonly string $path,
        private readonly string $name,
        private readonly string $mimeType
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHash(): string
    {
        return md5_file($this->getPath());
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        return @filesize($this->getPath());
    }

    public function getFileTypeId(): int
    {
        return match ($this->getMimeType()) {
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => FileType::DOCX->value,
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => FileType::XLSX->value,
            'application/pdf' => FileType::PDF->value,
            default => FileType::OTHER->value
        };
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
