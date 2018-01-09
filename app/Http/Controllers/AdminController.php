<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

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
    public function index()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::all()
        ];

        return view('admin.index', $data);
    }



    public function products($category_id)
    {
        $category = Category::find($category_id);

        $data = [
            'products' => $category->products()->where('category_id',$category_id)->get(),
            'category' => $category,
            'categories' => Category::all()

        ];

        return view('admin.products', $data);
    }
}
