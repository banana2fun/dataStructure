<?php

namespace Api\Http\Middleware;

use Closure;

/**
 * Class ForceJsonResponse
 * Необходима для возвращения пользователю ошибок валидации в json формате
 * @package Api\Http\Middleware
 */
class ForceJsonResponse
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Request-Headers', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
