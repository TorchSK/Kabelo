<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Contracts\ProductServiceContract;

use App\Category;

class HomeController extends Controller
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
    public function index($category=null, Request $request)
    {   
        if (isset($category))
        {
            $cat = Category::whereUrl($category)->first();
            $request['category'] = $cat->id;
            $data = $this->productService->list($request);

            return view('home/home', $data);
        }
        else
        {
            $data['categoryCounts'] = $this->productService->categoryCounts();
        }

        return view('home/home', $data);

    }

    public function makerProducts($maker, Request $request)
    {   

            $request['maker'] = $maker;
            $data = $this->productService->makerList($request);

            return view('home/makerProducts', $data);

    }

    public function welcome()
    {
        return view('home/welcome');
    }
}
