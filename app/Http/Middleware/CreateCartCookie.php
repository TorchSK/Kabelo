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
    
            if($cart == null)
            {
                $cookieData = [
                    'number' => 0,
                    'price' => 0,
                    'shipping_price' => 0,
                    'items' => [],
                    'counts' => [],
                    'price_levels' => [], 
                    'sizes' => [], 
                    'delivery_method' => '',
                    'payment_method' => '',
                    'invoice_address' => '{}',
                    'delivery_address' => '{}',
                    'delivery_address_flag' => 0,
                    'ico_flag' => 0
                ];

                // create cookie
                $cookie = Cookie::queue('cart',$cookieData,555555);
                $cart = Cookie::get('cart');
            }

            if(is_array($cart) && !array_key_exists('sizes', $cart))
            {
                $cookieData = $cart;
                $cookieData['sizes'] = [];
                $cookie = Cookie::queue('cart',$cookieData,555555);
                $cart = Cookie::get('cart');
            } 
        }

        return $next($request);
    }
}
