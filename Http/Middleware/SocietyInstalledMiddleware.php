<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
        if (!file_exists(base_path('.env')) || !Schema::hasTable('users')) {
            throw new \Exception('SocietyCMS is not yet installed');
        }

        return $next($request);
    }
}
