<?php 

namespace App\Services;

use App\Services\Contracts\CartServiceContract;

use Hash;
use Session;
use Auth;
use Cookie;

class CartService implements CartServiceContract {


  public function __construct ()
  {
  }

  public function delete()
  {
    if (Auth::check())
    {
      $cart = Auth::user()->cart;

      $cart->price  = 0;
      $cart->delivery_method = '';
      $cart->payment_method = '';
      $cart->invoice_address = '{}';
      $cart->delivery_address = '{}';
      $cart->delivery_address_flag = 0;
      $cart->ico_flag = 0;
      $cart->shipping_price  = 0;
      unset($cart['items']);

      $cart->save();
      
      foreach ($cart->products as $product)
      {
        $cart->products()->detach($product);
      }

    }
    else
    {
      $cookieData = [
        'number' => 0,
        'price' => 0,
        'shipping_price' => 0,
        'items' => [],
        'counts' => [],
        'price_levels' => [], 
        'delivery_method' => '',
        'payment_method' => '',
        'invoice_address' => '{}',
        'delivery_address' => '{}',
        'delivery_address_flag' => 0,
        'ico_flag' => 0
      ];

      Cookie::queue('cart', $cookieData, 0);  

    }
  
  }
 
}