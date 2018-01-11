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
use Auth;

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
        $cookie = Cookie::get('cart');

        if (isset($cookie['invoiceAddress']))
        {
            $invoiceAddress =  $cookie['invoiceAddress'];
        }
        else
        {   
            if(Auth::check())
            {
                $invoiceAddress = Auth::user()->invoiceAddress;
                $invoiceAddress['name'] = $invoiceAddress['first_name'].' '.$invoiceAddress['last_name'];
            }
            else
            {
                $invoiceAddress = false;
            }
        }

        if (isset($cookie['deliveryAddress']))
        {
            $deliveryAddress =  $cookie['deliveryAddress'];
        }
        else
        {
            $deliveryAddress =  false;
        }



        $data = [
            'invoiceAddress' => $invoiceAddress,
            'deliveryAddress' => $deliveryAddress,
        ];

        return view('cart.shipping', $data);
    }


   public function confirm(){
        $cookie = Cookie::get('cart');

        $data = [
            'products' => $cookie['items'],
            'delivery' => $cookie['delivery'],
            'payment' => $cookie['payment'],
            'invoiceAddress' => $cookie['invoiceAddress'],
            'deliveryAddress' => $cookie['deliveryAddress']

        ];

        return view('cart.confirm', $data);
    }

    public function set(Request $request)
    {        
        $cookieData = Cookie::get('cart');

        foreach ($request->except('_token') as $key => $item) {
          $cookieData[$key] = $item;
        }        

        Cookie::queue('cart', $cookieData, 0);

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


        $cookieData = $cookie;

        $cookieData['number'] = $cartNumber + 1;
        $cookieData['price'] = $cartPrice + $product->price;
        $cookieData['items'] = $cartItems;
        
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

        $cookieData =  $cookie ;
        $cookieData['number'] = $cartNumber - $itemCount;
        $cookieData['price'] = $cartPrice - $itemCount*$product->price;
        $cookieData['items'] = $cartItems;
        
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

        $cookieData = $cookie;

        $cookieData['number'] = $cartNumber + 1;
        $cookieData['price'] = $cartPrice + $product->price;
        $cookieData['items'] = $cartItems;
        
        
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

        $cookieData = $cookie;

        $cookieData['number'] = $cartNumber - 1;
        $cookieData['price'] = $cartPrice - $product->price;
        $cookieData['items'] = $cartItems;
        
        Cookie::queue('cart', $cookieData, 0);
        
        return $data;
    }


    public function delete()
    {
        $cookieData = [
                'number' => 0,
                'price' => 0,
                'items' => [],
                'delivery' => '',
                'payment' => '',
                'invoiceAddress' => '',
                'deliveryAddress' => '',
                'deliveryAddressFlag' => 0

        ];
        
        return Cookie::queue('cart', $cookieData, 0);  
    }
}
