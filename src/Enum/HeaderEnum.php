<?php

namespace Tizix\Bitrix24Laravel\Enum;

enum HeaderEnum: string
{
    case X_ACCESS_TOKEN = 'X-Access-Token';
    case X_REFRESH_TOKEN = 'X-Refresh-Token';
}
