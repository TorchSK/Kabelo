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
                'items' => [],
                'delivery' => '',
                'payment' => '',
                'invoiceAddress' => '',
                'deliveryAddress' => '',
                'deliveryAddressFlag' => 0,
            ];

            $cookie = Cookie::queue('cart',$cookieData,0);
        }
        //dd($cookie);

        if (!isset($cookie['number'])) {$cookie['number']=0;}
        if (!isset($cookie['price'])) {$cookie['price']=0;}
        if (!isset($cookie['items'])) {$cookie['items']=[];}
        if (!isset($cookie['delivery'])) {$cookie['delivery']='';}
        if (!isset($cookie['payment'])) {$cookie['payment']='';}
        if (!isset($cookie['invoiceAddress'])) {$cookie['invoiceAddress']='';}
        if (!isset($cookie['deliveryAddress'])) {$cookie['deliveryAddress']='';}
        if (!isset($cookie['deliveryAddressFlag'])) {$cookie['deliveryAddressFlag']=0;}

        View::share('cartNumber', $cookie['number']);
        View::share('cartPrice', $cookie['price']);
        View::share('cartItems', $cookie['items']);
        View::share('cartDelivery', $cookie['delivery']);
        View::share('cartPayment', $cookie['payment']);
        View::share('cartInvoiceAddress', $cookie['invoiceAddress']);
        View::share('cartDeliveryAddress', $cookie['deliveryAddress']);
        View::share('cartDeliveryAddressFlag', $cookie['deliveryAddressFlag']);

    
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
