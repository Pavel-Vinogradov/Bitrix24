<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Exception;

use Exception;
use Throwable;

final class ForbiddenException extends Exception
{
    protected $code = 403;

    public function __construct($message = 'У вас нет прав для выполнения этого действия.', $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
