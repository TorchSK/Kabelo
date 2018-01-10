<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;
use App\File as ProductFile;

use Image;
use File;


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
        $product->new = $request->get('new');
        $product->sale = $request->get('sale');
        $product->sale_price = $request->get('sale_price');

        $product->save();


        foreach ($request->get('categories') as $category)
        {
            $product->categories()->attach($category);
        }

        if (sizeof($request->get('params')) > 0)
        {
            foreach ($request->get('params') as $key => $param)
            {
                $parameter = new Parameter();
                $parameter->key = $key;
                $parameter->value = $param;

                $product->parameters()->save($parameter);
            }
        }

        return $product->maker.'/'.$product->code.'/detail';
    }

    
    public function create(Request $request)
    {
        $category = Category::find($request->get('category'));
        
        $data = [
           'selectedCategory' => $category
        ];

        return view('products.create', $data);
    }

    public function upload($type, Request $request)
    {   
        $file = $request->file('file');
        $destinationPath = 'temp';
        $extension = $file->getClientOriginalExtension(); 
        $filename = md5($file->getClientOriginalName().rand(0,1000)).'.'.$extension;
        $fullpath = $destinationPath.'/'.$filename;
        
        // store the filename into session
        //Session::put($type, $filename);

        $success = $file->move($destinationPath, $filename);
        
        $w = 1000;

        if ($success) 
        {
          $image = Image::make($destinationPath.'/'.$filename)
               ->widen($w)
               ->save($destinationPath.'/'.$filename);

          return url($destinationPath.'/'.$filename);
        } 
        else 
        {
            throw new Exception("Error cropping image", 1);
        }
    }

    public function list(Request $request)
    {
        $filters = $request->get('filters');

        $products = Product::when(isset($filters['category']), function ($query) use ($filters) {
            return $query->whereHas('categories', function($query) use ($filters){
                $query->whereIn('category_id', (array)$filters['category']);
            });
        })
        ->when(isset($filters['search']), function ($query) use ($filters) {
            return $query->whereRaw("name like '%".$filters['search']['item0']."%'");
        })
        ->get();
        
        $data = [
            'products' => $products
        ];

        return view('products.list', $data)->render();
    }

    public function profile($maker, $code)
    {

        $product = Product::where('maker',$maker)->where('code', $code)->first();
        
        $data = [
           'product' => $product
        ];

        return view('products.profile', $data);

    }

    public function edit($maker, $code)
    {

        $product = Product::where('maker',$maker)->where('code', $code)->first();
        
        $data = [
           'product' => $product
        ];

        $directory = 'temp';
        
        $files = File::files($directory);
        
        if (sizeof(File::files($directory)) > 0)
        {
            foreach ($files as $file)
            {
                File::delete($file);
            }
        }

        return view('products.edit', $data);

    }

    public function update($productid)
    {
        $product = Product::find($productid);
        $directory = 'temp';

        if (sizeof(File::files($directory)) > 0)
        {
            $files = File::files($directory);

            foreach ($files as $file)
            {
                $filename = explode("/", $file)[1];

                $productFile = new ProductFile();

                $productFile->product_id = $product->id;
                $productFile->path = 'uploads/'.$filename;
                $productFile->type = 'image';

                $productFile->save();

                $move = File::move($file, 'uploads/'.$filename);

            }
        }

        return '/'.$product->maker.'/'.$product->code.'/detail';
    }

    public function search($query)
    {
        $data['products'] = Product::where('name','like','%'.$query.'%')->get();

        return view('products.list', $data);

    }

    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();
    }
}
