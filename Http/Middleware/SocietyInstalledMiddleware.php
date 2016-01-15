<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
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
        $society_installed = Cache::remember('society_installed', 5, function () {
            return
                file_exists(base_path('.env')) &&
                Schema::hasTable('user__users');
        });

        if (!$society_installed) {
            throw new \Exception('SocietyCMS is not yet installed');
        }

        return $next($request);
    }
}
