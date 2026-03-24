<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $timezone = cache()->remember('settings.timezone', 60, function() {
            return Setting::first()->timezone ?? config('app.timezone');
        });
        //config(['app.timezone' => $timezone]);
        Config::set('app.timezone', $timezone);

        return $next($request);
    }
}
