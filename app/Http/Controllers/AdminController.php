<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use Auth;
use Excel;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageProducts()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::all()
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


    public function categoryProducts($category_id)
    {
        $category = Category::find($category_id);

        if ($category_id != 'unknown')
        {
            $data = [
                'products' => $category->products()->where('category_id',$category_id)->get(),
                'category' => $category,
                'categories' => Category::all()

            ];
        }
        else
        {
            $data = [
                'products' => Product::doesntHave('categories')->get(),
                'categories' => Category::all()

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

        return view('orders.manage', $data);
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

        Excel::load($file, function($reader) {
            $results = $reader->all();
            
        });

    }
}
