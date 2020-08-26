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

        catch(ErrorException  $e) {
          Cookie::forget('cart');
        }

        $app = env('APP_NAME');

        if($app == 'Laravel')
        {
            $app = 'Dedra';
        }

        Config::set('database.default', strtolower($app));
    
        return $next($request);
    }
}
