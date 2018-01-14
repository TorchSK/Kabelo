<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Product;
use App\Mail\NewOrder;

use App\Services\Contracts\CartServiceContract;

use Cookie;
use Auth;
use Mail;

class OrderController extends Controller
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

    public function store()
    {   
        if (Auth::check())
        {
            $orderData = Auth::user()->cart;
        }
        else
        {
            $orderData = Cookie::get('cart');
        }

    	$order = new Order();

    	if (Auth::check())
    	{
    		$order->user_id = Auth::user()->id;
    	}

    	$order->status_id = 0;


    	$order->delivery_method = $orderData['delivery_method'];
    	$order->payment_method = $orderData['payment_method'];


    	$order->invoice_name = $orderData['invoiceAddress']['name'];
	   	$order->invoice_phone = $orderData['invoiceAddress']['phone'];
		$order->invoice_email = $orderData['invoiceAddress']['email'];
		$order->invoice_address_street = $orderData['invoiceAddress']['street'];
		$order->invoice_address_zip = $orderData['invoiceAddress']['zip'];
		$order->invoice_address_city = $orderData['invoiceAddress']['city'];

		if ($orderData['deliveryAddressFlag'])
		{
			$order->delivery_address_name = $orderData['deliveryAddress']['name'];
			$order->delivery_address_street = $orderData['deliveryAddress']['street'];
			$order->delivery_address_zip = $orderData['deliveryAddress']['zip'];
			$order->delivery_address_city = $orderData['deliveryAddress']['city'];
			$order->delivery_address_phone = $orderData['deliveryAddress']['phone'];
		}
		else
		{
			$order->delivery_address_name = $orderData['invoiceAddress']['name'];
			$order->delivery_address_street = $orderData['invoiceAddress']['street'];
			$order->delivery_address_zip = $orderData['invoiceAddress']['zip'];
			$order->delivery_address_city = $orderData['invoiceAddress']['city'];
			$order->delivery_address_phone = $orderData['invoiceAddress']['phone'];
		}
		$order->invoice_first_additional = '';

        $price = 0;



        $order->price = $price;
        $order->save();

        foreach ($orderData['items'] as $productid)
        {
            $product = Product::find($productid);
            $price = $price + $product->price;
            $order->products()->attach($product);
        };

        $user = Auth::user();
        Mail::to($order->invoice_email)->queue(new NewOrder($order));

        //delete the cart
        $this->cartService->delete();  


    }

    public function success()
    {
    	return view('orders.success');
    }

    public function myhistory()
    {
    	return view('orders.myhistory');
    }
}
