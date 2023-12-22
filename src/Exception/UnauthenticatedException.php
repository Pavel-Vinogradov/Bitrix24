<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Exception;

use Throwable;
use Exception;

final class UnauthenticatedException extends Exception
{
    protected $code = 401;

    public function __construct($message = 'Ваша авторизация недействительна.', $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
