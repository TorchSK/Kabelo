<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;
use App\File as ProductFile;

use Image;
use File;
use Cookie;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function products(){
        return view('cart.products');
    }

    public function delivery(){
        return view('cart.delivery');
    }

    public function shipping(){
        return view('cart.shipping');
    }


   public function confirm(){
        return view('cart.confirm');
    }


    public function addItem($productId, Request $request)
    {
        $product = Product::find($productId);

        $data = [
            'price' => $product->price
        ];

        $cookie = Cookie::get('cart');

        $cartNumber = $cookie['number'];
        $cartPrice = $cookie['price'];
        $cartItems = $cookie['items'];

        array_push($cartItems,$product->id);

        $cookieData = [
            'number' => $cartNumber + 1,
            'price' => $cartPrice + $product->price,
            'items' => $cartItems
        ];
        
        Cookie::queue('cart', $cookieData, 0);
        
        return $data;
    }

    public function deleteItem($productId)
    {
        $product = Product::find($productId);

        $data = [
            'price' => $product->price
        ];

        $cookie = Cookie::get('cart');

        $cartNumber = $cookie['number'];
        $cartPrice = $cookie['price'];
        $cartItems = $cookie['items'];

        $itemCount = array_count_values($cartItems)[$productId];

        foreach (array_keys($cartItems, $productId) as $key) {
            unset($cartItems[$key]);
        }

        $cookieData = [
            'number' => $cartNumber - $itemCount,
            'price' => $cartPrice - $itemCount*$product->price,
            'items' => $cartItems
        ];
        
        Cookie::queue('cart', $cookieData, 0);
        
        return $data;
    }

    public function plusItem($productId)
    {
        $product = Product::find($productId);

        $data = [
            'price' => $product->price
        ];

        $cookie = Cookie::get('cart');

        $cartNumber = $cookie['number'];
        $cartPrice = $cookie['price'];
        $cartItems = $cookie['items'];

        array_push($cartItems,$product->id);

        $cookieData = [
            'number' => $cartNumber + 1,
            'price' => $cartPrice + $product->price,
            'items' => $cartItems
        ];
        
        Cookie::queue('cart', $cookieData, 0);
        
        return $data;
    }

    public function minusItem($productId)
    {
        $product = Product::find($productId);

        $data = [
            'price' => $product->price
        ];

        $cookie = Cookie::get('cart');

        $cartNumber = $cookie['number'];
        $cartPrice = $cookie['price'];
        $cartItems = $cookie['items'];

        
        $itemCount = array_count_values($cartItems)[$productId];

        $minusItemKey = array_keys($cartItems, $productId)[0];
        unset($cartItems[$minusItemKey]);

        $cookieData = [
            'number' => $cartNumber - 1,
            'price' => $cartPrice - $product->price,
            'items' => $cartItems
        ];
        
        Cookie::queue('cart', $cookieData, 0);
        
        return $data;
    }


    public function delete()
    {
        $cookieData = [
            'number' => 0,
            'price' => 0,
            'items' => []
        ];
        
        return Cookie::queue('cart', $cookieData, 0);  
    }
}
