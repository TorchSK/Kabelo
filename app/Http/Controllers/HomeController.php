<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ProductServiceContract;

use App\Category;
use Illuminate\Http\Request;
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
 public function index($category=null, Request $request)
    {   
        Category::fixTree();

        if (isset($category))
        {
            $cat = Category::whereUrl($category)->first();
            $request['category'] = $cat->id;
            $data = $this->productService->list($request);

            $data['requestCategory'] = Category::find($request->get('category'));

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
