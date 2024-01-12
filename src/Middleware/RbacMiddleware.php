<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tizix\Bitrix24Laravel\Exception\ForbiddenException;

final class RbacMiddleware
{
    /**
     * @throws ForbiddenException
     */
    public function handle(Request $request, Closure $next)
    {
        $permission = $request->route()?->getName();
        if (! auth()->user()?->hasPermission($permission)) {
            throw new ForbiddenException();
        }

        return $next($request);
    }
}
