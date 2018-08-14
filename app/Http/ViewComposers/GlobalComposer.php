<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ProductServiceContract;

use App\Http\Controllers\CartController;


use Cookie;
use Crypt;
use App\User;
use App\Cart;
use Config;

class GlobalComposer {

    public function __construct(ProductServiceContract $productService, CartController $cartController)
    {        
        $this->productService = $productService;
        $this->cartController = $cartController;
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
                try { 
                $cart = new Cart();
                $cart->user_id = Auth::user()->id;
                $cart->price  = 0;
                $cart->delivery_method = '';
                $cart->payment_method = '';
                $cart->invoice_address = '{}';
                $cart->delivery_address = '{}';
                $cart->delivery_address_flag = 0;

                $cart->save();
                } catch(\Illuminate\Database\QueryException $ex){ 
                  // do nothing
                }
            }

            $cart = $this->cartController->getCart($cart->id);
            

        }
        else
        {
            //if user is in guest mode, get cart from Cookie
            $cart = Cookie::get('cart');
        }   

        //dd($cart);
        
        $view->with('cart', $cart);
        $view->with('min_order_price', config('app.min_order_price'));
        $view->with('min_free_shipping_price', config('app.min_free_shipping_price'));
    }

}