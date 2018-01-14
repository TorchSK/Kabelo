<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class CategoryController extends Controller
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

    public function edit($id)
    {
        $category = Category::find($id);

        $data = [
            'category' => $category
        ];

        return view('categories.edit', $data);
    }

    public function update($id, Request $request)
    {
        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->save();

        return '/admin/products';
    }

    public function makers($categoryid){

        $category = Category::find($categoryid);

        $data = [
            'makers' => $category->products()->get(['maker'])->unique()
        ];

        return view('makers', $data);
    }

}
