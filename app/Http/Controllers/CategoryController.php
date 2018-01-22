<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\CategoryParameter;

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
            'makers' => $category->products()->get(['maker'])->unique(),
            'filters' => $category->parameters,
        ];

        return view('makers', $data);
    }

    public function addParameter(Request $request)
    {
        foreach ($request->get('keys') as $index => $key)
        {
            $param = new CategoryParameter();
            $param->category_id = $request->get('category_id');
            $param->key = $key;
            $param->display_key = $request->get('dkeys')[$index];
            $param->is_filter = 1;

        }

        $param->save();

        return redirect('/admin/category/'.$request->get('category_id').'/products');

    }

    public function editParameter($id, Request $request)
    {
        $data = [
            'param' => CategoryParameter::find($id)
        ];

       return view ('categories.editparam', $data);

    }

    public function updateParam($id, Request $request)
    {
        $param = CategoryParameter::find($id);
        $param->key = $request->get('key');
        $param->display_key = $request->get('display_key');

        $param->save();

        return redirect('/admin/category/'.$param->category_id.'/products');
    }

}
