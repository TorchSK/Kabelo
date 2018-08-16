<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Contracts\ProductServiceContract;
use App\Mail\NewOrder;

use App\Category;
use App\Order;
use App\Product;
use App\User;

use Mail;

class UtilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductServiceContract $productService)
    {
        $this->productService = $productService;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function connectorsGuide()
    {       
        return view('pages/connectorsguide');
    }

    public function cookiesInfo()
    {       
        return view('utils/cookiesinfo');
    }

    public function sendOrderEmail()
    {       
        $order = Order::find(1);
        Mail::to(json_decode($order->invoice_address)->email)->queue(new NewOrder($order));
    }

     public function setConfig(Request $request)
    {      
        foreach ($request->all() as $key => $value)
        {
        config(['app.'.$key => $value]);
        }
    }

    public function searchAll($query)
    {
        $data['products'] = Product::where('name', 'like', '%'.$query.'%')->take(5)->get();
        return response()->json(['products'=>view('search.products', $data)->render()]);
    }
}
