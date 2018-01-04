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

        $product->save();


        foreach ($request->get('categories') as $category)
        {
            $product->categories()->attach($category);
        }

        foreach ($request->get('params') as $param)
        {
            $product->parameters()->attach($param);
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
}
