<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Config;
use App;
use Request;

class SetDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $app = env('APP_NAME');

        if($app == 'Laravel')
        {
            $app = ucfirst(explode(".", Request::getHost())[0]);
        }

        if($app == 'Kabelo')
        {
            Config::set('database.default', 'kabelo');
        }
        elseif($app == 'Dedra')
        {
            Config::set('database.default', 'dedra');
        }

        return $next($request);
    }
}
