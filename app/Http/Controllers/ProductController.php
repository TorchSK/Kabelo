<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\ProductParameter;
use App\File as ProductFile;
use App\Rating;
use App\ProductRelation;
use App\PriceLevel;
use App\Parameter;

use Image;
use File;
use Response;
use Auth;
use Storage;
use Excel;
use Rap2hpoutre\FastExcel\FastExcel;

use App\Services\Contracts\ProductServiceContract;


class ProductController extends Controller
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

    public function inputSearch(Request $request)
    {
        return response()->json(['results'=>Product::where('name', 'like', '%'.$request->get('query').'%')->get()]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        if (Product::where('code',$request->get('code'))->count() > 0)
        {
            return redirect()->back()->withErrors(['msg'=>'Produkt s rovnakým kódom už existuje']);
        }

        $product = new Product();
        $product->name = $request->get('name');
        $product->desc = $request->get('desc');

        $product->price_unit = $request->get('unit');
        $product->code = $request->get('code');
        $product->maker = $request->get('maker');
        $product->new = $request->get('new');
        $product->sale = $request->get('sale');
        $product->sale_price = $request->get('sale_price');

        $product->save();

        foreach ((array)$request->get('thresholds') as $key=>$threshold)
        {
            $pricelevel = new PriceLevel();
            $pricelevel->threshold = $threshold;
            $pricelevel->moc_regular = $request->get('mocs')[$key];
            $pricelevel->moc_sale = $request->get('moc_sales')[$key];
            $pricelevel->voc_regular = $request->get('vocs')[$key];
            $pricelevel->voc_sale = $request->get('voc_sales')[$key];

            $product->priceLevels()->save($pricelevel);
        }

        foreach ((array)$request->get('categories') as $category)
        {
            $product->categories()->attach($category);
        }

        if ($request->filled('key'))
        {
            foreach ((array)$request->get('key') as $key => $param)
            {
                $parameter = new ProductParameter();
                $parameter->parameter_id = $param;
                $parameter->value = $request->get('value')[$key];
                $parameter->dvalue = $request->get('value')[$key];

                if ($param){
                    $product->parameters()->save($parameter);
                }
            }
        }

        $this->uploadImages($product);

        if ($product->sale)
        {
            $product->moc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale;
            $product->voc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_sale; 
        }
        else
        {
            $product->moc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular;
            $product->voc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular;  
        }
        $product->save();


        return redirect('admin/category/'.$product->categories->first()->url);
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
        
        $width = 1000;
        $height = 800;
        
        if ($success) 
        {
            if (in_array($extension, ['jpg','jpeg','gif','png']))
            {
                $image = Image::make($destinationPath.'/'.$filename);

                $image->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                });

                $image->resizeCanvas($width, $height, 'center', false, 'ffffff');
                

                $image->save($destinationPath.'/'.$filename);
            }
            else
            {

            }

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

    public function list(Request $request){
        if (!$request->has('filters') && !$request->has('category'))
        {
            return Response::json(['products' => view('home.initial')->render()]);   
        }
        else
        {
            $data = $this->productService->list($request);

            return Response::json(['products' => view('products.list', $data)->render(), 'filters' => view('home.makers', $data)->render(), 'data' => $data]);   
        }

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
                $ext = explode(".", $file)[1];

                $productFile = new ProductFile();

                $productFile->product_id = $product->id;
                $productFile->path = 'uploads/'.$filename;

                if (in_array($ext,['jpg','jpeg','gif','png']))
                {
                    $productFile->type = 'image';
                }
                else
                {
                    $productFile->type = 'file';
                }

                if ($key==0)
                {
                    $productFile->primary = 1;
                }

                $productFile->save();

                $move = File::move($file, 'uploads/'.$filename);

            }
        }
    }

    public function bulk()
    {

        return view('admin.bulk');
    }


    public function postBulk(Request $request)
    {
        $products = [];
        foreach ($request->all() as $key=>$data){
            $product = Product::find($key);
            foreach($data as $param => $value)
            {
                $product->$param = $value;

            }
            $product->save();
        }

        foreach ((array)$request->get('thresholds') as $key=>$threshold)
        {
            $pricelevel = new PriceLevel();
            $pricelevel->threshold = $threshold;
            $pricelevel->moc_regular = $request->get('mocs')[$key];
            $pricelevel->moc_sale = $request->get('moc_sales')[$key];
            $pricelevel->voc_regular = $request->get('vocs')[$key];
            $pricelevel->voc_sale = $request->get('voc_sales')[$key];

            $product->priceLevels()->save($pricelevel);
        }

        return $products;
    }

    public function apiUpdate($productid, Request $request)
    {
        $product = Product::find($productid);

        foreach ($request->except('_token') as $key => $value){
            $product->$key = $value;
        }

        $product->save();
        return 1;
    }




    public function update($productid, Request $request)
    {   
        $product = Product::find($productid);

        if (!$request->has('new')) {$request['new']='off';}
        if (!$request->has('sale')) {$request['sale']='off';}
        if (!$request->has('active')) {$request['active']='off';}

        $product->update($request->except('_token'));

        foreach ($product->priceLevels as $priceLevel)
        {
            $priceLevel->delete();
        }

        foreach ((array)$request->get('thresholds') as $key=>$threshold)
        {
            $pricelevel = new PriceLevel();
            $pricelevel->threshold = $threshold;
            $pricelevel->moc_regular = $request->get('mocs')[$key];
            $pricelevel->moc_sale = $request->get('moc_sales')[$key];
            $pricelevel->voc_regular = $request->get('vocs')[$key];
            $pricelevel->voc_sale = $request->get('voc_sales')[$key];

            $product->priceLevels()->save($pricelevel);
        }

        if ($request->has('categories'))
        {
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
        }


        foreach ($product->parameters as $parameter)
        {
            $parameter->delete();
        }

        if ($request->filled('key'))
        {
            foreach ((array)$request->get('key') as $key => $param)
            {
                $parameter = new ProductParameter();
                $parameter->parameter_id = $param;
                $parameter->value = $request->get('value')[$key];
                $parameter->dvalue = $request->get('value')[$key];

                if ($param){
                    $product->parameters()->save($parameter);
                }
            }
        }

        $this->uploadImages($product);

        foreach ($request->get('related_products') as $relprod)
        {   
            $relatedProduct = new ProductRelation();
            $relatedProduct->product_id = $product->id;
            $relatedProduct->related_product_id = $relprod;
            $relatedProduct->relation_type = 0;

            if($relprod){
        
                $relatedProduct->save();
            }
        }


        foreach ($product->videos as $video)
        {
            $video->delete();
        }

        if ($request->filled('videos'))
        {
            foreach ((array)$request->get('videos') as $key => $video)
            {
                $productFile = new ProductFile();

                $productFile->product_id = $product->id;
                $productFile->type='video';
                $productFile->path = $video;

                if ($video)
                {
                    $productFile->save();
                }
            }
        }



        if ($product->sale)
        {
            $product->moc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_sale;
            $product->voc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_sale; 
        }
        else
        {
            $product->moc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->moc_regular;
            $product->voc_sort_price = $product->priceLevels->where('threshold',$product->priceLevels->min('threshold'))->first()->voc_regular;  
        }
        $product->save();

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
        $data['products'] = Product::where('name','like','%'.$query.'%')->orWhere('desc','like','%'.$query.'%')->get();

        return view('products.list', $data);

    }

    public function addRating($id, Request $request)
    {
        $product = Product::find($id);
        $rating = new Rating();
        $rating->value = $request->get('value');
        $rating->text = $request->get('text');
        $rating->user_id = Auth::user()->id;

        $product->ratings()->save($rating);

        return 1;
    }

     public function viewPriceLevel()
     {
        return view('products.pricelevel');
     }


    public function setStock()
    {
        ini_set('max_execution_time', 180); //3 minutes

        $url = "zm.csv";
        $file = Storage::disk('s3')->get($url);
        Storage::disk('local')->put("zm.csv", $file);

        $results = (new FastExcel)->import(storage_path('app/zm.csv'));
        $productCodes = Product::all()->pluck('code')->toArray();

        foreach ($results as $row)
        {
            if(in_array($row['CISLO_MAS'], $productCodes))
            {
                $product = Product::where('code',$row['CISLO_MAS'])->first();
                $product->stock = round($row['POCET_MJ'],2);
                $product->save();
            }
        };
    return 'Stock updated';
      

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
