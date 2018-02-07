<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Contracts\ProductServiceContract;

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
    public function index(Request $request)
    {   
        if ($request->has('category'))
        {
            $data = $this->productService->list($request);
            return view('home', $data);
        }
        else
        {
            $data = [];
        }

        return view('home', $data);

    }

    public function welcome()
    {
        return view('welcome');
    }
}
