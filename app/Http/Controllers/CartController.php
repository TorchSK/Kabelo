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

    public function index(){
        return view('cart.index');
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
