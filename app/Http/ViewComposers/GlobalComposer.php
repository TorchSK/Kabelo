<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\ServiceProvider;

use Cookie;
use Crypt;
use App\User;
use App\Cart;

class GlobalComposer {

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
                $cart->invoice_address = '';
                $cart->delivery_address = '';
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
        
        $view->with('cartNumber', $cart['number']);
        $view->with('cartPrice', $cart['price']);
        $view->with('cartItems', $cart['items']);
        $view->with('cartDeliveryMethod', $cart['delivery_method']);
        $view->with('cartPaymentMethod', $cart['payment_method']);
        $view->with('cartInvoiceAddress', $cart['invoiceAddress']);
        $view->with('cartDeliveryAddress', $cart['deliveryAddress']);
        $view->with('cartDeliveryAddressFlag', $cart['deliveryAddressFlag']);

    
    }

}