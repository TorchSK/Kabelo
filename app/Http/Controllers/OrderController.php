<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Product;
use App\Setting;

use App\Mail\NewOrder;
use App\Mail\SentOrder;
use App\Mail\CancelOrder;

use App\Services\Contracts\CartServiceContract;
use App\Services\Contracts\ProductServiceContract;

use DB;
use Cookie;
use Auth;
use Mail;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        CartServiceContract $cartService,
        ProductServiceContract $productService
    )
    {
        $this->cartService = $cartService;
        $this->productService = $productService;

    }

    public function store()
    {   
        if (Auth::check())
        {
            $orderData = Auth::user()->cart;
            $orderData['items'] =  Auth::user()->cart->products->pluck('id');
            $orderCounts = [];

            foreach (Auth::user()->cart->products as $product)
            {
                $orderCounts[$product->id] =  $product->pivot->qty;
            }
        }
        else
        {
            $orderData = Cookie::get('cart');
            $orderCounts =  $orderData['counts'];

        }

    	$order = new Order();

    	if (Auth::check())
    	{
    		$order->user_id = Auth::user()->id;
    	}

    	$order->status_id = 0;


    	$order->delivery_method_id = $orderData['delivery_method'];
    	$order->payment_method_id = $orderData['payment_method'];
        $order->price = $orderData['price'];
        $order->shipping_price = $orderData['shipping_price'];


    	$order->invoice_address = $orderData['invoice_address'];


		if ($orderData['delivery_address_flag'])
		{
			$order->delivery_address = $orderData['delivery_address'];
		}

        $order->save();

        foreach($orderData['items'] as $key => $productid)
        {
            $order->products()->attach($productid, ['price' => $this->productService->getUserProductPrice($productid, $orderCounts[$productid]), 'qty' => $orderCounts[$productid]]);
        }
    

        $user = Auth::user();
        Mail::to(json_decode($order->invoice_address)->email)->queue(new NewOrder($order));
        
        if(Setting::whereName('order_email_1')->first()) {
            Mail::to(Setting::whereName('order_email_1')->first()->value)->queue(new NewOrder($order));
        }

        if(Setting::whereName('order_email_2')->first()) {
            Mail::to(Setting::whereName('order_email_2')->first()->value)->queue(new NewOrder($order));
        }

        //delete the cart
        $this->cartService->delete();  


    }

    public function update($id, Request $request)
    {
        $order = Order::find($id);

        foreach ($request->except('_token') as $key => $item) {
            $order[$key] = $item;
        }    

        $order->save();


        if($request->has('status_id') && $request->get('status_id')==1)
        {
            Mail::to(json_decode($order->invoice_address)->email)->queue(new SentOrder($order));
        }

        if($request->has('status_id') && $request->get('status_id')==4)
        {
            Mail::to(json_decode($order->invoice_address)->email)->queue(new CancelOrder($order));
        }
        
    }

    public function show($id)
    {
        $data['order'] = Order::find($id);

        $this->authorize('view', $data['order']);

        return view('orders.profile', $data);
    }

    public function success()
    {
    	return view('orders.success');
    }

    public function myhistory()
    {
    	return view('orders.myhistory');
    }

    public function countByDays($daysago)
    {
        $orders = Order::select(DB::raw('DATE_FORMAT(created_at, "%Y-%c-%e") as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->get();

        return $orders;
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
    }

}
