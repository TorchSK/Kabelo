<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;
use App\File as ProductFile;

use Image;
use File;
use Response;

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


        foreach ((array)$request->get('categories') as $category)
        {
            $product->categories()->attach($category);
        }

        if ($request->has('key') && sizeof($request->get('key')) > 0)
        {
            foreach ((array)$request->get('key') as $key => $param)
            {
                $parameter = new Parameter();
                $parameter->category_parameter_id = $param;
                $parameter->value = $request->get('value')[$key];
                $parameter->dvalue = $request->get('value')[$key];

                $product->parameters()->save($parameter);
            }
        }

        $this->uploadImages($product);

        return redirect($product->maker.'/'.$product->code.'/detail');
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

    public function query($filters, $except=[])
    {


        $result = Product::leftjoin('product_parameters',function($leftjoin){
            $leftjoin->on('product_parameters.product_id', '=', 'products.id');
            })
        ->leftjoin('category_parameters',function($leftjoin){
            $leftjoin->on('category_parameters.id', '=', 'product_parameters.category_parameter_id');
            })
        ->where(function($query) use ($filters, $except){
            foreach ((array)$filters as $key => $temp){
              if ($filters[$key])
              {
                if ($key=='search')
                {   
                    $query->whereRaw("name like '%".$filters['search']."%'");
                }
                elseif($key=='category')
                {
                    $query->whereHas('categories', function($query) use ($filters){
                        $query->where('category_id', $filters['category']);
                    });
                }
                elseif($key=='price')
                {
                    $array = explode(",",$filters['price']);
                    $query->whereBetween('price', $array);

                }
                elseif($key=='parameters')
                {
                    foreach ((array)$filters['parameters'] as $categoryParameter => $value)
                    {
                        if ($categoryParameter == 'makers')
                        {
                             $query->whereIn('maker', $value);
                        }
                        else
                        {
                            $query->whereHas('parameters', function ($query) use ($categoryParameter, $value) {
                                $query->whereIn('value',(array)$value)->whereHas('categoryParameter', function ($query)  use ($categoryParameter, $value){
                                       $query->where('key', $categoryParameter);
                                });
                            }); 
                        }
                   

                    }
                };
              }
            }
        });

        return $result->groupBy(['products.id'])->select(['products.*']);
    }

    public function list(Request $request)
    {
        $filters = $request->get('filters');
        $category = Category::find($request->get('categoryid'));

        $sortBy = $request->get('sortBy');
        $sortOrder = $request->get('sortOrder');    
        
        // set active filters
        $activeFilters = collect($filters);

        // set products
        $products = $this->query($filters)->orderBy($sortBy,$sortOrder)->get();

        // set price range
        $priceRangeFilters = $filters;
        unset($priceRangeFilters['price']);
        $priceRange = [];
        $priceRange[0] = $this->query($priceRangeFilters)->pluck('price')->min();
        $priceRange[1] = $this->query($priceRangeFilters)->pluck('price')->max();

        $makers = $category->products()->get()->unique(['maker']);
        $categoryParameters = $category->parameters;


        $temp = [];
        $filterCounts['parameters'] = [];

        $filterCounts['parameters']['makers'] = [];
        $filterCountFilters['parameters']['makers'] = [];
        foreach ($makers as $maker)
        {
            $filterCountFilters = $filters;
            
            $filterCountFilters['parameters']['makers'] = [$maker->maker];
            
            $filterCounts['parameters']['makers'][$maker->maker] = $this->query($filterCountFilters)->get()->count();
            
        }


        foreach ($categoryParameters as $categoryParameter)
        {
            $filterCounts['parameters'][$categoryParameter->id] = [];
            $filterCountFilters = $filters;

            foreach ($categoryParameter->parameters as $productParameter)
            {   
                $filterCountFilters['parameters'][$categoryParameter->key] = $productParameter->value;
                array_push($temp, $filterCountFilters);
                $filterCounts['parameters'][$categoryParameter->id][$productParameter->value] = $this->query($filterCountFilters, [$categoryParameter->key])->get()->count();
                unset($filterCountFilters['parameters'][$categoryParameter->key]);
            }
        }

        $data = [
            'makers' => $makers,
            'filters' => $category->parameters,
            'products' => $products,
            'activeFilters' => $activeFilters,
            'filterCounts' => $filterCounts,
            'temp' => $temp,
            'priceRange' => $priceRange
        ];

        return Response::json(['products' => view('products.list', $data)->render(), 'filters' => view('makers', $data)->render(), 'data' => $data]);
    }

    public function profile($maker, $code)
    {

        $product = Product::where('maker',$maker)->where('code', $code)->first();
        
        $data = [
           'product' => $product,
           'bodyid' => 'body_product_detail'
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

    public function uploadImages(Product $product)
    {
        $directory = 'temp';

        if (sizeof(File::files($directory)) > 0)
        {
            $files = File::files($directory);

            foreach ($files as $key => $file)
            {
                $filename = explode("/", $file)[1];

                $productFile = new ProductFile();

                $productFile->product_id = $product->id;
                $productFile->path = 'uploads/'.$filename;
                $productFile->type = 'image';

                if ($key==0)
                {
                    $productFile->primary = 1;
                }

                $productFile->save();

                $move = File::move($file, 'uploads/'.$filename);

            }
        }
    }

    public function update($productid, Request $request)
    {   
        $product = Product::find($productid);

        if (!$request->has('new')) {$request['new']='off';}
        if (!$request->has('sale')) {$request['sale']='off';}

        $product->update($request->except('_token'));

        foreach ($request->get('categories') as $categoryid)
        {   
            $category = Category::find($categoryid);

            if ($product->categories->where('id', $categoryid)->count() == 0)
            {
                $product->categories()->save($category);
            }
        }

        foreach ($product->categories as $category)
        {   
            if (!in_array($category->id,$request->get('categories')))
            {
                $product->categories()->detach($category);
            }
        }

        foreach ($product->parameters as $parameter)
        {
            $parameter->delete();
        }


        if ($request->has('key') && sizeof($request->get('key')) > 0)
        {
            foreach ((array)$request->get('key') as $key => $param)
            {
                $parameter = new Parameter();
                $parameter->category_parameter_id = $param;
                $parameter->value = $request->get('value')[$key];
                $parameter->dvalue = $request->get('value')[$key];

                $product->parameters()->save($parameter);
            }
        }

        $this->uploadImages($product);

        return redirect('/'.$product->maker.'/'.$product->code.'/detail');
    }

    public function changeCategory($productid, $categoryid)
    {
        $product = Product::find($productid);
        $category = Category::find($categoryid);

        $product->categories()->attach($category);
    }

    public function search($query)
    {
        $data['products'] = Product::where('name','like','%'.$query.'%')->get();

        return view('products.list', $data);

    }

    public function destroy($id)
    {
        $product = Product::find($id);

        foreach ($product->images as $file)
        {
            File::delete($file->path);
            $file->delete();
        }
        $product->delete();
    }
}
