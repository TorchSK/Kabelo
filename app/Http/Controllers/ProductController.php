<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->get('name');

        $category->save();

        return 1;
    }

    
    public function create()
    {
        $data = [
           
        ];

        return view('products.create', $data);
    }

    public function upload()
    {
        return 1;
    }
}
