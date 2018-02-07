<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;
use App\Cart;
use App\File as ProductFile;

use App\Services\Contracts\CartServiceContract;

use Image;
use File;
use Cookie;
use Auth;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        CartServiceContract $cartService
    )
    {
        $this->cartService = $cartService;
    }

    public function products(){
        return view('cart.products');
    }

    public function delivery(){
        $cookie = Cookie::get('cart');

        if (isset($cookie['delivery']))
        {
            $delivery =  $cookie['delivery'];
        }
        else
        {
            $delivery =  -1;
        }

        if (isset($cookie['payment']))
        {
            $payment =  $cookie['payment'];
        }
        else
        {
            $payment =  -1;
        }


        $data = [
            'delivery' => $delivery,
            'payment' => $payment
        ];

        return view('cart.delivery', $data);
    }

    public function shipping(){
   

        return view('cart.shipping');
    }


   public function confirm(){

        return view('cart.confirm');
    }

    function getCart()
    {
        if (Auth::check())
        {
            $cart = Auth::user()->cart;
            $cart['number'] = $cart->products->count();
            $cart['price'] = $cart->products->sum('price');
            $cart['items'] = $cart->products->pluck('id')->toArray();
        }
        else
        {
            $cart = Cookie::get('cart');
        }

        return $cart;
    }

    public function set(Request $request)
    {        
        $cart = $this->getCart();

        foreach ($request->except('_token') as $key => $item) {
          $cart[$key] = $item;
        }        

        if (Auth::check())
        {
            unset($cart['number']);
            unset($cart['price']);
            unset($cart['items']);
            $cart->save();
        }
        else
        {
            Cookie::queue('cart', $cart, 0);
        }
    }

    public function addItem($productId, Request $request)
    {
        $product = Product::find($productId);

        $cart = $this->getCart();

        $cartNumber = $cart['number'];
        $cartPrice = $cart['price'];
        $cartItems = $cart['items'];

        array_push($cartItems,$product->id);

        $cartData = $cart;

        $cartData['number'] = $cartNumber + 1;
        $cartData['price'] = $cartPrice + $product->price;
        $cartData['items'] = $cartItems;
        
        if (Auth::check())
        {
            $cart->products()->attach($product);
        }
        else
        {
            Cookie::queue('cart', $cartData, 0);
        }

        // return price for FE
        $data['price'] = $product->price;
        return $data;
    }

    public function deleteItem($productId)
    {
        $product = Product::find($productId);
        
        $cart = $this->getCart();

        $cartNumber = $cart['number'];
        $cartPrice = $cart['price'];
        $cartItems = $cart['items'];

        $itemCount = array_count_values($cartItems)[$productId];

        foreach (array_keys($cartItems, $productId) as $key) {
            unset($cartItems[$key]);
        }

        $cartData =  $cart ;
        $cartData['number'] = $cartNumber - $itemCount;
        $cartData['price'] = $cartPrice - $itemCount*$product->price;
        $cartData['items'] = $cartItems;
        
        if (Auth::check())
        {
            $cart->products()->detach($product);
        }
        else
        {
            Cookie::queue('cart', $cartData, 0);
        }

        // return price for FE
        $data['price'] = $product->price;
        return $data;
    }


    public function minusItem($productId)
    {
        $product = Product::find($productId);

        $cart = $this->getCart();

        $cartNumber = $cart['number'];
        $cartPrice = $cart['price'];
        $cartItems = $cart['items'];
        
        $itemCount = array_count_values($cartItems)[$productId];

        $minusItemKey = array_keys($cartItems, $productId)[0];
        unset($cartItems[$minusItemKey]);

        $cartData = $cart;

        $cartData['number'] = $cartNumber - 1;
        $cartData['price'] = $cartPrice - $product->price;
        $cartData['items'] = $cartItems;
        
        if (Auth::check())
        {
            $cart->products()->sync([]);
            foreach ($cartData['items'] as $item)
            {
                $cart->products()->attach($item);
            }
        }
        else
        {
            Cookie::queue('cart', $cartData, 0);
        }

        // return price for FE
        $data['price'] = $product->price;
        return $data;
    }


    public function delete()
    {
        return $this->cartService->delete();  
    }
}
