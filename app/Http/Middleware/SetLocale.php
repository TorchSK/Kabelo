<?php

namespace App\Http\Middleware;

use Closure;
use Cookie; 
use App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(Cookie::get());

        if ($lang = Cookie::get('language')) {
            App::setLocale($lang);
        }

        return $next($request);
    }
}
