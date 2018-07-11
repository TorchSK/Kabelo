<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\CategoryParameter;

use Session;
use Image;

use App\Services\Contracts\ProductServiceContract;

class CategoryController extends Controller
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


    public function all()
    {
        $data = [
            'categoryCounts' => $this->productService->categoryCounts()
        ];

        return view('categories.all', $data);
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
        $category->url = str_slug($request->get('name'));
        $category->parent_id = $request->get('parent_id');

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
        $category->url = $request->get('url');

        $category->save();

        return '/admin/products';
    }


    public function addParameter(Request $request)
    {   
        if($request->get('keys')[0]){
        foreach ($request->get('keys') as $index => $key)
        {
            $param = new CategoryParameter();
            $param->category_id = $request->get('category_id');
            $param->key = $key;
            $param->display_key = $request->get('dkeys')[$index];
            $param->is_filter = 1;

        }

        $param->save();
        }

        return redirect('/admin/category/'.$request->get('category_url'));

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

        return redirect('/admin/category/'.$param->category->url);
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file('file');

        $destinationPath = 'temp/categories';
        $extension = $file->getClientOriginalExtension(); 
        $filename = $file->getClientOriginalName();
        $fullpath = $destinationPath.'/'.$filename;

        $preview_success = $file->move($destinationPath, $filename);


        return $fullpath;
    }

    public function confirmCrop($categoryid, Request $request)
    {
        $filename = $request->get('filename');


        $path = 'temp/categories/'.$filename;
        $destinationPath = 'uploads/categories';


        $w = 400;

        Image::make($path)
                 ->widen($w)
                 ->resizeCanvas($w, $w*0.8)
                 ->save($destinationPath.'/'.$filename);

        $category = Category::find($categoryid);

        $category->image = $destinationPath.'/'.$filename;
        $category->save();
        
        return $filename;
    }


    public function setOrder(Request $request)
    {
        foreach(Category::all() as $category)
        {
            $category->order = $request->get('orders')[$category->id];

            if (isset($request->get('parents')[$category->id]))
            {
                $category->parent_id = $request->get('parents')[$category->id];
            }

            $category->save();
        }
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();
    }
}
