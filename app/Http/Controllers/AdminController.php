<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use Auth;
use Excel;

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
}
