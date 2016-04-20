<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SocietyInstalledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! app('society.isInstalled')) {
            throw new \Exception('SocietyCMS is not yet installed');
        }

        return $next($request);
    }
}
