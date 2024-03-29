<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\ProductParameter;
use App\File;
use App\Rating;
use App\ProductRelation;
use App\PriceLevel;
use App\Parameter;

use Image;
use Response;
use Auth;
use Storage;
use Excel;
use Cache;
use File as Filez;

use Rap2hpoutre\FastExcel\FastExcel;

use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;

use Orchestra\Parser\Xml\Facade as XmlParser;

class ProductController extends Controller
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
        return Product::all();
    }

    public function inputSearch(Request $request)
    {
        return response()->json(['results'=>Product::where('name', 'like', '%'.$request->get('query').'%')->get()]);
    }

    public function filter(Request $request)
    {
        return $this->productService->filter($request);
    }


    public function create(Request $request)
    {   
        $category = Category::find($request->get('category'));
        
        $data = [
           'selectedCategory' => $category
        ];

        return view('products.create', $data);
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
        $product->url = str_slug($product->code."-".$product->name);

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

        Cache::forget('category_counts');
        return redirect()->route('admin.eshop.products');
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

    

    public function profile($url)
    {

        $product = Product::whereUrl($url)->first();
        
        if(!$product) return abort(404);
        
        $data = [
           'product' => $product,
           'bodyid' => 'body_product_detail',
           'categories' => $this->categoryService->getCategories(),
           'title' => $product->name,
        ];

        if($product->image)
        {
            $data['ogImages'] = $product->images->pluck('path');
        }

        return view('products.profile', $data);

    }



    public function list(Request $request){
        $data = $this->productService->list($request);

        if($request->get('filters')['search'])
        {
            return Response::json(['products' => view('products.searchlist', $data)->render(), 'filters' => view('home.makers', $data)->render(), 'data' => $data]);
        }
        else
        {
            return Response::json(['products' => view('products.list', $data)->render(), 'filters' => view('home.makers', $data)->render(), 'data' => $data]);
        }
      

    }


    public function makerlist(Request $request){

        $data = $this->productService->makerList($request);

        return Response::json(['products' => view('products.list', $data)->render(), 'filters' => view('home.makers', $data)->render(), 'data' => $data]);   
     

    }


    public function uploadImages(Product $product)
    {
        $directory = 'temp';

        if (sizeof(Filez::files($directory)) > 0)
        {
            $files = Filez::files($directory);

            foreach ($files as $key => $file)
            {
                $filename = explode("/", $file)[1];
                $ext = explode(".", $file)[1];

                $productFile = new File();

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

                $move = Filez::move($file, 'uploads/'.$filename);

            }
        }
    }


    public function simpleList(Request $request)
    {
        foreach(array_unique($request->get('id')) as $key => $product)
        {
            $data['products'][$key] = Product::find($product);
        }

        return view('products.simplelist', $data);
 
    }

    public function postBulk(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data['changes'] as $item)
        {
            $product = Product::find($item['id']);
            $product->name = $item['name'];

            $priceLevel = PriceLevel::where('product_id', $item['id'])->first();
            $priceLevel->moc_regular = $item['price_levels'][0]['moc_regular'];
            $priceLevel->moc_sale = $item['price_levels'][0]['moc_sale'];
            $priceLevel->save();
            
            $product->sale = $item['sale'];
            $product->active = $item['active'];
            $product->name = $item['name'];
            $product->save();
        }

        foreach ($data['categoryChanges']['products'] as $productid)
        {
            $product = Product::find($productid);
            
            foreach ($product->categories as $category)
            {
                $product->categories()->detach($category);
            }

            foreach ($data['categoryChanges']['categories'] as $categoryid)
            {
                $product->categories()->attach($categoryid);
            }

            $product->save();

        }

        foreach (array_unique($data['categoryAdds']['products']) as $productid)
        {
            $product = Product::find($productid);

            foreach ($data['categoryAdds']['categories'] as $categoryid)
            {
                $product->categories()->attach($categoryid);
            }

            $product->save();

        }


        foreach (array_unique($data['addEcoImages']) as $productid)
        {
            $product = Product::find($productid);
            $product->ecoImages = 1;
            $product->save();
        }

        foreach (array_unique($data['removeEcoImages']) as $productid)
        {
            $product = Product::find($productid);
            $product->ecoImages = 0;
            $product->save();
        }

        return 1;
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


    public function translate($productid)
    {
        $product = Product::find($productid);

        $client = new \GoogleTranslate\Client('AIzaSyCEYe59xoog4g8GvqPOrBOP-veGVY8IFqI');

        $sourceLanguage = 'cs';

        $checkName = $result = $client->detect($product->name);
        if ($checkName['language'] != 'sk')
        {
            $name = $client->translate($product->name, 'sk', $sourceLanguage);
            $product->name = $name;
        }
        
        if ($product->desc)
        {
            $desc = $client->translate($product->desc, 'sk', $sourceLanguage);
            $product->desc = $desc;
        }

        $product->translated = 1;
        $product->translate_error = null;

        $product->save();
 
        return 1;
    }

    public function edit($product)
    {
        $product = Product::where('url', $product)->first();
        
        $data = [
           'product' => $product
        ];

        $directory = 'temp';
        
        $files = Filez::files($directory);
        
        if (sizeof(Filez::files($directory)) > 0)
        {
            foreach ($files as $file)
            {
                Filez::delete($file);
            }
        }

        return view('products.edit', $data);

    }


    public function update($productid, Request $request)
    {   
        $product = Product::find($productid);

        if (!$request->has('new')) {$request['new']='off';}
        if (!$request->has('sale')) {$request['sale']='off';}
        if (!$request->has('active')) {$request['active']='off';}
        if (!$request->has('thumbnail_flag')) {$request['thumbnail_flag']='off';}

        $product->update($request->except('_token'));

        /*
        foreach ($product->priceLevels as $priceLevel)
        {
            $priceLevel->delete();
        }
        */

        foreach ((array)$request->get('thresholds') as $key=>$threshold)
        {
            if ($request->get('ids')[$key] == 'na' || $request->get('ids')[$key] == '')
            {
                $pricelevel = new PriceLevel();
                $pricelevel->threshold = $threshold;
                $pricelevel->moc_regular = $request->get('mocs')[$key];
                $pricelevel->moc_sale = $request->get('moc_sales')[$key];
                $pricelevel->voc_regular = $request->get('vocs')[$key];
                $pricelevel->voc_sale = $request->get('voc_sales')[$key];

                $product->priceLevels()->save($pricelevel);
            }
            else
            {
                $pricelevel = PriceLevel::find($request->get('ids')[$key]);
                $pricelevel->threshold = $threshold;
                $pricelevel->moc_regular = $request->get('mocs')[$key];
                $pricelevel->moc_sale = $request->get('moc_sales')[$key];
                $pricelevel->voc_regular = $request->get('vocs')[$key];
                $pricelevel->voc_sale = $request->get('voc_sales')[$key];
                $pricelevel->save();
            }
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
                    $params = $product->parameters;

                    foreach($params as $param)
                    {
                        $param->delete();
                    }
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

        foreach ($request->get('image_paths') as $index => $path)
        {   
            $image = File::find($request->get('image_ids')[$index]);

            $image->path = $path;
            $image->save();
        }

        if ($request->filled('videos'))
        {
            foreach ((array)$request->get('videos') as $key => $video)
            {
                $productFile = new File();

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

        return redirect()->route('product.detail',['url'=> $product->url]);
    }

    public function xmlUpdate($id)
    {
        $product = Product::find($id);
        
        $contents = file_get_contents('https://dedra.blob.core.windows.net/cms/xmlexport/cs_xml_export.xml?ppk=133538');
        $xml = XmlParser::extract($contents);
       
        $items = $xml->parse([
            'products' => ['uses' => 'product[kategorie,product_id,text1,text2,text3,detail,meritko,picture1,picture2,picture3,picture4,picture5,picture6,price_skk,stav_skladu,variant_text,variants.variant(::product_id=::type)>variants,sizes.size(::size_id=@)>sizes,sizes.size(::size_id=::availability)>sizeStocks]']
        ]);

        $item_collection = collect($items['products']);
        $item = $item_collection->where('product_id',$product->code)->first();

        if($product->image)
        {
            $product->image->path = $item['picture1'];
            $product->image->save();
        }
        else
        {
            $image = new File();
            $image->product_id = $product->id;
            $image->path = $item['picture1']; 
            $image->type = 'image';
            $image->primary = 1;
            $image->save();
        }

        foreach($product->otherImages as $key => $image)
        {   
            $temp = $key + 2;
            $index = 'picture'.$temp;

            if($item[$index]!='')
            {
                $image->path = $item[$index]; 
                $image->save();
            }
            else
            {
                $image->delete();
            }
        }
        
        for ($i = $product->images->count()+1; $i <= 6; $i++)
        {   
            $index = 'picture'.$i;

            if($item[$index]!='')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item[$index]; 
                $image->type = 'image';
                $image->primary = 0;
                $image->save();
            }
        }

            
    }

    public function changeCategory($productid, $categoryid)
    {
        $product = Product::find($productid);
        $category = Category::find($categoryid);

        $product->categories()->attach($category);
    }


    public function addRating($id, Request $request)
    {
        $product = Product::find($id);
        $existing = Rating::where('ratingable_id', $id)->where('user_id', Auth::user()->id);

        if ($existing->count())
        {
            $rating = $existing->first();
            $rating->value = $request->get('value');
            $rating->text = $request->get('text');
            $rating->user_id = Auth::user()->id;

            $product->ratings()->save($rating);
        }
        else
        {
            $rating = new Rating();
            $rating->value = $request->get('value');
            $rating->text = $request->get('text');
            $rating->user_id = Auth::user()->id;

            $product->ratings()->save($rating);
        }

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


    public function setNewOrder(Request $request)
    {
        foreach(Product::whereNew(1)->get() as $product)
        {
            $product->new_order = $request->get($product->id);
            $product->save();
        }
    }



    public function setSaleOrder(Request $request)
    {
        foreach(Product::whereSale(1)->get() as $product)
        {
            $product->sale_order = $request->get($product->id);
            $product->save();
        }
    }



    public function getSizes($id)
    {
        return Product::find($id)->sizes;
    }
    

    public function destroy($id)
    {
        $product = Product::find($id);

        foreach ($product->images as $file)
        {
            Filez::delete($file->path);
            $file->delete();
        }
        $product->delete();
    }
}
