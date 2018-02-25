<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use Auth;
use Excel;

use App\DeliveryMethod;
use App\PaymentMethod;

use App\Services\Contracts\ProductServiceContract;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductServiceContract $productService)
    {        
        $this->middleware('auth');
        $this->productService = $productService;
    }


    public function dashboard()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts()

        ];

        return view('admin.dashboard', $data);
    }

    
    public function manageProducts()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts()

        ];

        return view('admin.index', $data);
    }

    public function manageUsers()
    {
        $data = [
            'users' => User::all(),
        ];

        return view('admin.users', $data);
    }


    public function categoryProducts($category, Request $request)
    {
        $cat = Category::where('url',$category)->first();

        if($category != 'unknown')
        {
            $data = [
                'products' => $cat->products,
                'category' => $cat,
                'categories' => Category::orderBy('order','asc')->get(),
                'categoryCounts' => $this->productService->categoryCounts()
            ];

            $request['category'] = $cat->id;

        }
        else
        {
            $data = [
                'products' => Product::doesntHave('categories')->get(),
                'categories' => Category::orderBy('order','asc')->get(),
                'category' => 'unknown',
                'categoryCounts' => $this->productService->categoryCounts()

            ];
        }

        return view('admin.products', $data);
    }

    public function cookie(){
        $cart = Auth::user()->cart;
        $cart['items'] = $cart->products->pluck('id');
        dd($cart);
    }

    
    public function manageOrders()
    {
        $data = [
            'orders' => Order::all()
        ];

        return view('admin.orders', $data);
    }


    public function orderDetail($id)
    {
        $data = [
            'order' => Order::find($id)
        ];

        return view('admin.orderdetail', $data);
    }


    public function settings()
    {
        $data = [
            'orders' => Order::all()
        ];

        return view('admin.settings', $data);
    }


    public function import()
    {
        $data = [
        ];

        return view('admin.import', $data);
    }

    public function postImport(Request $request)
    {
        $file = $request->file('file');

        $results  = Excel::load($file, function($reader) {
            
        })->get();  

        // check the results, and add valid flag at the end
        
        return $results;
    }

    public function addDeliveryMethod(Request $request)
    {
        $delivery = new DeliveryMethod();
        $delivery->name = $request->get('name');
        $delivery->key = $request->get('key');
        $delivery->save();

        return $delivery;
    }

    public function editDeliveryMethod($id, Request $request)
    {
        $delivery = DeliveryMethod::find($id);
        $delivery->name = $request->get('name');
        $delivery->key = $request->get('key');
        $delivery->desc = $request->get('desc');
        $delivery->icon = $request->get('icon');
        $delivery->save();

        return $delivery;
    }

    public function addPaymentMethod(Request $request)
    {
        $payment = new PaymentMethod();
        $payment->name = $request->get('name');
        $payment->key = $request->get('key');
        $payment->save();

        return $payment;
    }

    public function editPaymentMethod($id, Request $request)
    {
        $payment = PaymentMethod::find($id);
        $payment->name = $request->get('name');
        $payment->key = $request->get('key');
        $payment->desc = $request->get('desc');
        $payment->icon = $request->get('icon');
        $payment->save();

        return $payment;
    }

}
