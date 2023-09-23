<?php

namespace Tizix\Bitrix24Laravel\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tizix\Bitrix24Laravel\Enum\HeaderEnum;

final class BitrixAuthenticateMiddleware
{
    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $accessToken = $request->header(HeaderEnum::X_ACCESS_TOKEN->value);
        $refreshToken = $request->header(HeaderEnum::X_REFRESH_TOKEN->value);

        if (! $accessToken && ! $refreshToken) {
            $this->unauthenticated($request);
        }

        return $next($request);
    }

    /**
     * @throws AuthenticationException
     */
    private function unauthenticated(Request $request): void
    {
        throw new AuthenticationException('Не аутентифицированный пользователь');
    }
}
