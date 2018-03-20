<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ProductServiceContract;

use Cookie;
use Crypt;
use App\User;
use App\Cart;
use App\Setting;

class GlobalComposer {

    public function __construct(ProductServiceContract $productService)
    {        
        $this->productService = $productService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check())
        {   
            //if user is authenticated, get cart from DB
            $cart = Auth::user()->cart;

            if (!$cart)
            {
                $cart = new Cart();
                $cart->user_id = Auth::user()->id;
                $cart->price  = 0;
                $cart->delivery_method = '';
                $cart->payment_method = '';
                $cart->invoice_address = '{}';
                $cart->delivery_address = '{}';
                $cart->delivery_address_flag = 0;

                $cart->save();
            }
            $cart['number'] = $cart->products->count();
            $cart['price'] = $cart->products->sum('price');
            $cart['items'] = $cart->products->pluck('id')->toArray();

        }
        else
        {
            //if user is in guest mode, get cart from Cookie
            $cart = Cookie::get('cart');
        }   

        //dd($cart);
        
        $view->with('cart', $cart);
        if(Setting::where('key','layout')->count())
        {
            $view->with('layout', Setting::where('key','layout')->first()->value);
        }
    }

}