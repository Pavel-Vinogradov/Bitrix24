<?php

use Tizix\Bitrix24Laravel\DTO\FileDTO;

interface UploadServiceInterface
{
    public function upload(FileDTO $fileDTO): mixed;
}
