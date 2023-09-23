<?php

use Tizix\Bitrix24Laravel\DTO\FileDTO;

interface FileServiceInterface
{
    public function uploadFile(FileDTO $fileDTO): mixed;
}
