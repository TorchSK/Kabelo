<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;

use App\Category;
use App\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public $app_name;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductServiceContract $productService, CategoryServiceContract $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }
    
    public function index($category=null, Request $request)
    {   
        if (isset($category))
        {
            $cat = Category::whereUrl($category)->first();
            $request['category'] = $cat->id;
            $data = $this->productService->list($request);

            $data['requestCategory'] = Category::find($request->get('category'));
            $data['categories'] = $this->categoryService->getCategories();

            return view('home/home', $data);
        }
        else
        {
            $data['categoryCounts'] = $this->productService->categoryCounts();
            $data['bestsellerCategory'] = $this->categoryService->getBestsellerCategory();

            if($data['bestsellerCategory']){
                $request = new Request(['categories'=>[$data['bestsellerCategory']->id], 'active_only'=> true]);
                $count = $this->productService->filter($request)->count();
                $data['bestsellerProducts'] = $this->productService->filter($request)->random($count)->slice(0, 20);
                
                $manualBestsellers = Product::whereBestseller(1)->whereHas('categories', function($query) use($data){
                    $query->where('category_id', $data['bestsellerCategory']->id);
                })->get();

                $data['bestsellerProducts'] = $data['bestsellerProducts']->merge($manualBestsellers)->reverse();
            }

        }
        
        $data['categories'] = $this->categoryService->getCategories();

        return view('home/home', $data);

    }

    public function makerProducts($maker, Request $request)
    {   

        $request['maker'] = $maker;
        $data = $this->productService->makerList($request);
        $data['categories'] = $this->categoryService->getCategories();

        return view('home/makerProducts', $data);

    }

    public function welcome()
    {
        return view('home/welcome');
    }
}
