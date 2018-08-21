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
        $cart = Auth::user()->cart;

        if (Auth::check())
        {   
            $cart = $this->cartController->getCart($cart->id);
        }
        else
        {
            $cart = $this->cartController->getCart('undefined');
        }   

        //dd($cart);
        $appname = env('APP_NAME');

        if($appname == 'Laravel')
        {
            $appname = ucfirst(explode(".", Request::getHost())[0]);
        }
        

        $view->with('cart', $cart);
        $view->with('appname', $appname);
        $view->with('min_order_price', config('app.min_order_price'));
        $view->with('min_free_shipping_price', config('app.min_free_shipping_price'));
    }

}