<?php

namespace Tizix\Bitrix24Laravel\Enum;

enum FileType: int
{
    case DOCX = 10;
    case XLSX = 20;
    case PDF = 30;
    case OTHER = 999;

}
