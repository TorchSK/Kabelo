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
use Request;
use App\Setting;

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
         $cart = Auth::user()->cart;
            $cart = $this->cartController->getCart($cart->id);
        }
        else
        {
            $cart = $this->cartController->getCart('undefined');
        }   

        //dd($cart);
        
        $layout = Setting::whereName('layout')->first()->value;

        $view->with('cart', $cart);
        $view->with('layout', $layout);
        $view->with('min_order_price', config('app.min_order_price'));
        $view->with('min_free_shipping_price', config('app.min_free_shipping_price'));
    }

}