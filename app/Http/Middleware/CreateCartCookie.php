<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Cookie;

class CreateCartCookie
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
        if (!Auth::guard($guard)->check()) 
        {
            $cart = Cookie::get('cart');

            if(!$cart)
            {
                $cookieData = [
                    'number' => 0,
                    'price' => 0,
                    'items' => [],
                    'delivery_method' => '',
                    'payment_method' => '',
                    'invoiceAddress' => '',
                    'deliveryAddress' => '',
                    'deliveryAddressFlag' => 0,
                ];

                // create cookie
                $cookie = Cookie::queue('cart',$cookieData,0);
            }
        }

        return $next($request);
    }
}
