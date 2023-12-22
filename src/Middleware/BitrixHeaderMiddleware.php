<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Middleware;

use Closure;
use Illuminate\Http\Request;

final class BitrixHeaderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->add([
            'X-Access-Token' => '',
            'X-Refresh-Token' => '',
        ]);

        return $next($request);
    }
}
