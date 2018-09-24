<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;

use Session;
use Image;
use Cache;

use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;

class CategoryController extends Controller
{
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


    public function all()
    {
        $data = [
            'categoryCounts' => $this->productService->categoryCounts()
        ];

        return view('categories.all', $data);
    }


    public function products($path=null, Request $request)
    {   
            $cat = Category::whereFullUrl($path)->first();

            $request['category'] = $cat->id;
            $data = $this->productService->list($request);

            $data['requestCategory'] = Category::find($request->get('category'));
            $data['categories'] = $this->categoryService->getCategories();

            return view('categories/products', $data);


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
        
        $path = $category->name;

        foreach($category->ancestors->reverse() as $child)
        {
            $path = $child->name.' / '.$path;
        }

        $category->path = $path;
        $category->full_url = str_replace("99","-",str_replace("9999", "/", str_slug(str_replace(" ","99", $category->path))));

        $category->save();

        Cache::forget('category_counts');

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


    public function set($id, Request $request)
    {
        $category = Category::find($id);
        
        $category->update($request->all());

        if($request->has('active'))
        {
            foreach($category->products as $product)
            {
                $product->active = $request->get('active');
                $product->save();
            }
        }

        return 1;
    }

    public function addParameter(Request $request)
    {   
       
        $param = Parameter::find($request->get('parameter_id'));
        $category = Category::find($request->get('category_id'));

        $category->parameters()->syncWithoutDetaching($param);

        return 1;
    }

    public function editParameter($id, Request $request)
    {
        $data = [
            'param' => CategoryParameter::find($id)
        ];

       return view ('categories.editparam', $data);

    }


    public function filterbar()
    {
        return view('includes/filterbar_content')->render();

    }


    public function deleteParameter($id, Request $request)
    {
        $param = Parameter::find($id);
        $category = Category::find($request->get('category_id'));

        $category->parameters()->detach($param);
        return 1;

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


        $width = 400;
        $height = 280;

        $image = Image::make($path);

        $image->fit($width, $height);

        $image->resizeCanvas($width, $height, 'center', false, 'ffffff');
        

        $image->save($destinationPath.'/'.$filename);

        $category = Category::find($categoryid);

        $category->image = $destinationPath.'/'.$filename;
        $category->save();
        
        return $filename;
    }


    public function setOrder(Request $request)
    {
        foreach(Category::where('active',1)->get() as $category)
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
