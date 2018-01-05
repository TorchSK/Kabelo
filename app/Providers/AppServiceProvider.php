<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cookie;
use View;
use Crypt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $cookie = Cookie::get('cart');

        if ($cookie)
        {
            $cookie = Crypt::decrypt($cookie);
        }
        else
        {
            $cookieData = [
                'number' => 0,
                'price' => 0,
                'items' => []
            ];

            $cookie = Cookie::queue('cart',$cookieData,0);
        }
        //dd($cookie);
        if ($cookie)
        {
            View::share('cartNumber', $cookie['number']);
            View::share('cartPrice', $cookie['price']);
            View::share('cartItems', $cookie['items']);
        }
        else
        {
            View::share('cartNumber', 0);
            View::share('cartPrice', 0);
            View::share('cartItems', []);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
