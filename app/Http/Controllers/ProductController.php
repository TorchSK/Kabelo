<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;


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
        $product = new Product();
        $product->name = $request->get('name');
        $product->desc = $request->get('desc');
        $product->price = $request->get('price');
        $product->price_unit = $request->get('unit');
        $product->code = $request->get('code');
        $product->maker = $request->get('maker');

        $product->save();


        foreach ($request->get('categories') as $category)
        {
            $product->categories()->attach($category);
        }

        foreach ($request->get('params') as $param)
        {
            $product->parameters()->attach($param->id);
        }

        return $product->id;
    }

    
    public function create()
    {
        $data = [
           'a' => 1
        ];

        return view('products.create', $data);
    }

    public function upload()
    {
        return 1;
    }

    public function profile($maker, $code)
    {

        $product = Product::where('maker',$maker)->where('code', $code)->first();
        
        $data = [
           'product' => $product
        ];

        return view('products.profile', $data);

    }
}
