<?php

use Tizix\Bitrix24Laravel\DTO\FileDTO;

class BitrixCloudUploadService implements UploadServiceInterface
{
    public function upload(FileDTO $fileDTO): mixed
    {
        return $fileDTO;
    }
}
