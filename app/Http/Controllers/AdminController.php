<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use App\Banner;
use App\Setting;
use App\Color;
use App\Parameter;
use App\File;
use App\PriceLevel;
use App\Page;
use App\Text;
use App\Sticker;
use App\Variant;
use App\Log;
use App\Size;

use Auth;
use Excel;
use Image;
use Storage;
use Cookie;
use DB;
use Response;
use File as Filez;
use Exception;
use Cache;

use App\DeliveryMethod;
use App\PaymentMethod;

use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;
use App\Services\Contracts\TranslateServiceContract;

use Orchestra\Parser\Xml\Facade as XmlParser;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductServiceContract $productService, 
        CategoryServiceContract $categoryService,
        TranslateServiceContract $translateService
    )
    {        
        $this->middleware('auth');
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->translateService = $translateService;
    }

    public function copperLoadProducts()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $oldProducts = DB::table('eshop_produkty')->get();
        DB::table('products')->truncate();

        foreach($oldProducts as $oldProduct)
        {
            $product = new Product();
            $product->id = $oldProduct->id;
            $product->name = $oldProduct->title;
            $product->code = $oldProduct->kod_produktu;
            $product->price_unit = 'ks';
            $product->maker = $oldProduct->id_vyrobca;

            $product->save();


        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperLoadCategories()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $oldCategories = DB::table('eshop_kategorie')->get();
        DB::table('categories')->truncate();

        foreach($oldCategories as $oldCategory)
        {
            $category = new Category();
            $category->id = $oldCategory->id;
            $category->name = $oldCategory->nazov;
            $category->url = str_slug($oldCategory->nazov);

            $category->save();
        }


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperAddCategoryParent()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach(Category::all() as $category)
        {
            $category->parent_id = DB::table('eshop_kategorie')->where('id', $category->id)->first()->parent;

            $category->save();
        }


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperAddPrices()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach(Product::all() as $product)
        {
            $pricelevel = new PriceLevel();
            $pricelevel->threshold = 1;
            $pricelevel->moc_regular = DB::table('eshop_produkty')->where('id', $product->id)->first()->cena;
            $pricelevel->moc_sale = DB::table('eshop_produkty')->where('id', $product->id)->first()->cena_akcia;
            $pricelevel->voc_regular = DB::table('eshop_produkty')->where('id', $product->id)->first()->cena_voc;
            $pricelevel->voc_sale = DB::table('eshop_produkty')->where('id', $product->id)->first()->cena_voc_akcia;

            $product->priceLevels()->save($pricelevel);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperAttachCategories()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category_product')->truncate();

        foreach(Product::all() as $product)
        {
            if (DB::table('eshop_katalogova_vazba')->where('id_produkt', $product->id)->count() > 0)
            {
                $categoryId = DB::table('eshop_katalogova_vazba')->where('id_produkt', $product->id)->first()->id_kategoria;
                $category = Category::find($categoryId);
                $product->categories()->save($category);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperAttachFiles()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('files')->truncate();

        foreach(Product::all() as $product)
        {
            $image = new File();
            $image->product_id = $product->id;
            $image->path = 'uploads/'.DB::table('eshop_produkty')->where('id', $product->id)->first()->image;
            $image->type = 'image';
            $image->primary = 1;
            $image->save();
            
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperAddDesc()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach(Product::all() as $product)
        {   
            if(DB::table('eshop_produkty_description')->where('id_produkt', $product->id)->count() > 0)
            {
                $product->desc = DB::table('eshop_produkty_description')->where('id_produkt', $product->id)->first()->uputavka;
                $product->save();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function copperInit()
    {
        $this->copperLoadProducts();
        $this->copperLoadCategories();
        $this->copperAddCategoryParent();
        $this->copperAddPrices();
        $this->copperAttachCategories();
        $this->copperAttachFiles();
        $this->copperAddDesc();

    }



    public function translate()
    {
        $items = $xml->parse([
            'products' => ['uses' => 'product[kategorie,product_id,text1,text2,text3,detail]'],
        ]);

        $item_collection = collect($items['products']);

        try{

            foreach(Product::where('translated', 0)->get() as $product)
            {
                $item = $item_collection->where('product_id',$product->code)->first();

                $product->name = $this->translateService->translate($item['text1']+' '+$item['text2']+' '+$item['text3']);
                $product->desc = $this->translateService->translate($item['detail']);

                $product->translated = 1;
                $product->translate_error = null;

                $product->save();
            }
        }
        catch(Exception $e)
        {
            $product->translate_error = 'e';
            $product->save();
        }
    }

    public function translatePathToCz()
    {
        $client = new \GoogleTranslate\Client('AIzaSyCEYe59xoog4g8GvqPOrBOP-veGVY8IFqI');

        foreach(Category::all() as $category)
        {   
            $sourceLanguage = 'sk';
            $category->path_cz = $client->translate($category->path, 'cs', $sourceLanguage);
            $category->save();
        }


    }

    public function xmlUpdate()
    {
        return view('admin.eshop.xmlupdate');
    }

    public function xmlUpdateHistory()
    {
        return view('admin.eshop.xmlupdatehistory');
    }

    public function postXmlUpdate(Request $request)
    {   
        if ($request->get('external'))
        {
            $contents = file_get_contents($request->get('url'));

        }
        else
        {
            $contents = file_get_contents('uploads/files/'.$request->get('url'));
        }

        $xml = XmlParser::extract($contents);
       
        $items = $xml->parse([
            'products' => ['uses' => 'product[kategorie,product_id,text1,text2,text3,detail,meritko,picture1,picture2,picture3,picture4,picture5,picture6,price_skk,stav_skladu,variant_text,variants.variant(::product_id=::type)>variants]'],
        ]);

        //dd($items['products']);

        $xmlProductsIds = $xml->parse([
            'ids' => ['uses' => 'product[product_id]'],
        ]);

        $xmlCategoryPaths = $xml->parse([
            'paths' => ['uses' => 'product[kategorie]'],
        ]);

        $changes = [];
        $changes['new_categories'] = [];
        $changes['new_products'] = [];
        $changes['removed_categories'] = [];
        $changes['removed_products'] = [];

        $xmlProducts = collect($xmlProductsIds)->flatten()->toArray();
        $dbProducts = Product::all()->pluck('code')->toArray();
        
        $activeDbProducts = Product::whereActive(1)->get()->pluck('code')->toArray();

        $addedProductsArray = array_diff($xmlProducts, $dbProducts);
        $existingProductsArray = array_intersect($xmlProducts, $activeDbProducts);

        $removedProductsArray = array_diff($dbProducts, $xmlProducts);
        $removedProducts = Product::whereIn('code', $removedProductsArray)->whereActive(1)->get();
        
        $changes['removed_products'] = $removedProducts->count();


        foreach($addedProductsArray as $key => $temp)
        {
            $item = $items['products'][$key];

            $productCategory = $item['kategorie'];

            $productCategoryArray = explode(' / ',$item['kategorie']);


            $dbCategory1 = Category::where('path_cz',$productCategoryArray[0])->first();

            if(isset($productCategoryArray[1]))
            {
                $dbCategory2 = Category::where('path_cz',$productCategoryArray[0].' / '.$productCategoryArray[1])->first();
            }

            if(isset($productCategoryArray[2]))
            {
                $dbCategory3 = Category::where('path_cz',$productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2])->first();
            }

            if(isset($productCategoryArray[3]))
            {
                $dbCategory4 = Category::where('path_cz',$productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2].' / '.$productCategoryArray[3])->first();
            }

            if(!$dbCategory1)
            {
                $cat = new Category();
                $cat->name = $productCategoryArray[0];
                $cat->url = str_slug($productCategoryArray[0]);
                $cat->path = $productCategoryArray[0];
                $cat->path_cz = $productCategoryArray[0];
                $cat->save();
                $parent = $cat->id;

                $categoryID = $cat->id;

                array_push($changes['new_categories'],$cat);

            }
            else
            {
                $parent = $dbCategory1->id;
                $categoryID = $dbCategory1->id;
            }

            if(isset($productCategoryArray[1]))
            {
                if(!$dbCategory2)
                {
                    $cat = new Category();
                    $cat->name = $productCategoryArray[1];
                    $cat->url = str_slug($productCategoryArray[1]);
                    $cat->parent_id = $parent;
                    $cat->path = $productCategoryArray[0].' / '.$productCategoryArray[1];
                    $cat->path_cz = $productCategoryArray[0].' / '.$productCategoryArray[1];
                    $cat->save();
                    $parent = $cat->id;

                    $categoryID = $cat->id;

                    array_push($changes['new_categories'],$cat);
                }
                else
                {
                    $parent = $dbCategory2->id;
                    $categoryID = $dbCategory2->id;
                }
            }

            if(isset($productCategoryArray[2]))
            {
                if(!$dbCategory3)
                {
                    $cat = new Category();
                    $cat->name = $productCategoryArray[2];
                    $cat->url = str_slug($productCategoryArray[2]);
                    $cat->parent_id = $parent;
                    $cat->path = $productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2];
                    $cat->path_cz = $productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2];
                    $cat->save();
                    $parent = $cat->id;

                    $categoryID = $cat->id;

                    array_push($changes['new_categories'],$cat);
                }
                else
                {
                    $parent = $dbCategory3->id;
                    $categoryID = $dbCategory3->id;
                }
            }

            if(isset($productCategoryArray[3]))
            {
                if(!$dbCategory4)  
                {
                    $cat = new Category();
                    $cat->name = $productCategoryArray[3];
                    $cat->url = str_slug($productCategoryArray[3]);
                    $cat->parent_id = $parent;
                    $cat->path = $productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2].' / '.$productCategoryArray[3];
                    $cat->path_cz = $productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2].' / '.$productCategoryArray[3];
                    $cat->save();
                    $parent = $cat->id;

                    $categoryID = $cat->id;

                    array_push($changes['new_categories'],$cat);

                }
                else
                {
                    $parent = $dbCategory4->id;
                    $categoryID = $dbCategory4->id;
                }
            }

            $client = new \GoogleTranslate\Client('AIzaSyCEYe59xoog4g8GvqPOrBOP-veGVY8IFqI');

            $sourceLanguage = 'cs';

            $product = new Product();

            try {
                $product->name = $client->translate($item['text1'].' '.$item['text2'], 'sk', $sourceLanguage);
                $product->desc = $client->translate($item['detail'], 'sk', $sourceLanguage);
            }
            catch(Exception $e)
            {

            }

            $product->code = $item['product_id'];
            $product->price = $item['price_skk'];
            $product->price_unit = 'ks';
            $product->maker = 'Dedra';
            $product->moc_sort_price = $item['price_skk'];
            $product->voc_sort_price = $item['price_skk'];
            
            if(isset($item['variant_text']))
            {
            $product->variant_text = $item['variant_text'];
            }

            $product->save();

            array_push($changes['new_products'],$product);


            $image = new File();
            $image->product_id = $product->id;
            $image->path = $item['picture1']; 
            $image->type = 'image';
            $image->primary = 1;
            $image->save();

            if($item['picture2']!='')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item['picture2']; 
                $image->type = 'image';
                $image->primary = 0;
                $image->save();
            }

            if($item['picture3']!='')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item['picture3']; 
                $image->type = 'image';
                $image->primary = 0;
                $image->save();
            }

            if($item['picture4']!='')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item['picture4']; 
                $image->type = 'image';
                $image->primary = 0;
                $image->save();
            }

            if($item['picture5']!='')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item['picture5']; 
                $image->type = 'image';
                $image->primary = 0;
                $image->save();
            }

            if($item['picture6']!='')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item['picture6']; 
                $image->type = 'image';
                $image->primary = 0;
                $image->save();
            }
            
            $product->categories()->attach($categoryID);

            $pricelevel = new PriceLevel();
            $pricelevel->threshold = 1;
            $pricelevel->moc_regular = $item['price_skk'];
            $pricelevel->moc_sale = $item['price_skk'];
            $pricelevel->voc_regular = $item['price_skk'];
            $pricelevel->voc_sale = $item['price_skk'];

            $product->priceLevels()->save($pricelevel);

            if(count($item['variants']) > 0)
            {   
                foreach($item['variants'] as $key => $type)
                {
                    $variant_product = Product::whereCode($key)->first();

                    if($variant_product)
                    {
                        if($product->allVariants()->where('id',$variant_product->id)->count()==0)
                        {
                            $variant = new Variant();
                            $variant->product_id = $product->id;
                            $variant->variant_id = $variant_product->id;
                            $variant->type = $type;
                            $variant->save();
                        }
                    }
                }
            }

        }
        
        
        foreach($existingProductsArray as $key => $temp)
        {   
            $item = $items['products'][$key];

            $product = Product::whereCode($temp)->first();

            if($item['stav_skladu']=='PRODEJ UKONČEN' || $item['stav_skladu']=='poslední kusy')
            {
                if($product->active==1)
                {
                    $product->active = 'off';
                    $product->save();

                    $removedProducts->push($product);
                }

            }
            else
            {
                if(isset($item['variant_text']))
                {
                $product->variant_text = $item['variant_text'];
                }

                $product->price = $item['price_skk'];
                $product->moc_sort_price = $item['price_skk'];
                $product->voc_sort_price = $item['price_skk'];
                $product->save();

                $priceLevel = $product->priceLevels->first();
                $priceLevel->moc_regular = $item['price_skk'];
                $priceLevel->voc_regular = $item['price_skk'];

                if($priceLevel){
                    $priceLevel->save();
                }

                $image = $product->image;
                
                if($image){

                    $image->path = $item['picture1']; 

                    $image->save();
                }
            }



        }

        

        foreach($removedProductsArray as $key => $temp)
        {   
            $product = Product::whereCode($temp)->first();
            $product->active = 'off';
            $product->save();
        }

        $log = new Log();
        $log->log = $changes['new_categories'];
        $log->type = 'product_update';
        $log->operation = 'new_categories';
        $log->save();

        $log = new Log();
        $log->log = $changes['new_products'];
        $log->type = 'product_update';
        $log->operation = 'new_products';
        $log->save();

        $log = new Log();
        $log->log = $removedProducts;
        $log->type = 'product_update';
        $log->operation = 'removed_products';
        $log->save();

        $this->addCategoryFullurl();
        $this->addProductUrl();

        Cache::forget('category_counts');
        Cache::forget('categories');

        return Response::json(['changes' => $changes, 'newCategories' => view('admin.eshop.xmlcategorylist', ['categories'=>collect($changes['new_categories'])])->render(), 'removedCategories' => view('admin.eshop.xmlcategorylist', ['categories'=>collect($changes['removed_categories'])])->render(), 'newProducts' => view('admin.eshop.xmlproductlist', ['products'=>collect($changes['new_products'])])->render(), 'removedProducts' => view('admin.eshop.xmlproductlist', ['products'=>$removedProducts])->render()]);   

    }   

    public function addSizes()
    {
        $contents = file_get_contents('https://dedra.blob.core.windows.net/cms/xmlexport/cs_xml_export.xml?ppk=133538');
        $xml = XmlParser::extract($contents);

        $items = $xml->parse([
            'products' => ['uses' => 'product[product_id,sizes.size(::size_id=@)>sizes,sizes.size(::size_id=::availability)>sizeStocks]'],
        ]);


        $item_collection = collect($items['products']);

        foreach(Product::all() as $product)
        {   

            $item = $item_collection->where('product_id',$product->code)->first();

            if ($item)
            {
                if(count($item['sizes']) > 0)
                {   
                    foreach($item['sizes'] as $code => $text)
                    {
                        
                        if($product->sizes()->where('product_id',$product->id)->where('size_code', $code)->count()==0)
                        {
                            $size = new Size();
                            $size->product_id = $product->id;
                            $size->size_code = $code;
                            $size->text = $text;
                            $size->stock = $item['sizeStocks'][$code];
                            $size->save();
                        }
                        
                    }
                }
            }
        }
    }


    public function confirmXMLUpdate(){
        return DB::commit();
    }

    public function addCategoryPath()
    {
        foreach(Category::all() as $category)
        {
            $path = $category->name;

            foreach($category->ancestors->reverse() as $child)
            {
                $path = $child->name.' / '.$path;
            }

            $category->path = $path;
            $category->save();
        }
    }

    public function addCategoryFullurl()
    {
        foreach(Category::all() as $category)
        {
            $category->full_url = str_replace("99","-",str_replace("9999", "/", str_slug(str_replace(" ","99", $category->path))));
            $category->save();
        }
    }

    public function addProductUrl()
    {
        foreach(Product::all() as $product)
        {
            $product->url = str_slug($product->code."-".$product->name);
            $product->save();
        }
    }


    public function addMoreImages()
    {   

        $contents = file_get_contents('https://dedra.blob.core.windows.net/cms/xmlexport/cs_xml_export.xml?ppk=133538');
        $xml = XmlParser::extract($contents);

        $items = $xml->parse([
            'products' => ['uses' => 'product[product_id,picture1,picture2,picture3,picture4,picture5,picture6]'],
        ]);

        $item_collection = collect($items['products']);

        foreach(Product::whereTemp(0)->get() as $product)
        {   

            $item = $item_collection->where('product_id',$product->code)->first();

            if ($item)
            {
            if($item['picture1'] != '')
            {
                if(File::where('path', $item['picture1'])->count() == 0)
                {
                    $image = new File();
                    $image->product_id = $product->id;
                    $image->path = $item['picture1']; 
                    $image->type = 'image';
                    $image->primary = 1;
                    $image->save();
                }
            }


            if($item['picture2'] != '')
            {
                if(File::where('path', $item['picture2'])->count() == 0)
                {
                    $image = new File();
                    $image->product_id = $product->id;
                    $image->path = $item['picture2']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($item['picture3'] != '')
            {
                if(File::where('path', $item['picture3'])->count() == 0)
                {
                    $image = new File();
                    $image->product_id = $product->id;
                    $image->path = $item['picture3']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($item['picture4'] != '')
            {
                if(File::where('path', $item['picture4'])->count() == 0)
                {
                    $image = new File();
                    $image->product_id = $product->id;
                    $image->path = $item['picture4']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($item['picture5'] != '')
            {

                if(File::where('path', $item['picture5'])->count() == 0)
                {
                    $image = new File();
                    $image->product_id = $product->id;
                    $image->path = $item['picture5']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($item['picture6'] != '')
            {
                $image = new File();
                $image->product_id = $product->id;
                $image->path = $item['picture6']; 
                $image->type = 'image';
                $image->primary = 0;

                if(File::where('path', $item['picture6'])->count() == 0)
                {
                    $image->save();
                }
            }

            $product->temp=1;
            $product->save();

        }

        }
    }


    public function xmlImpaort()
    {
        $contents = Storage::get('dedra.xml');
        $xml = XmlParser::extract($contents);

        $items = $xml->parse([
            'products' => ['uses' => 'product[kategorie,product_id,text1,text2,text3,detail,meritko,picture1,picture2,picture3,picture4,picture5,picture6,price_skk,stav_skladu,variant_text,variant_image]'],
        ]);
        $categories = [];

        foreach(Category::all() as $temp)
        {
            $temp->delete();
        }
        
        foreach(File::all() as $temp)
        {
            $temp->delete();
        }
        
        foreach(Product::all() as $temp)
        {
            $temp->delete();
        }


        $cat_unique = [];

        foreach($items['products'] as $key => $item)
        {   
            if(!in_array($item['kategorie'], $cat_unique))
            {
                array_push($cat_unique, $item['kategorie']);
            }
        }

        foreach($cat_unique as $key => $item)
        {   
            $category_array = explode(" / ", $item);

            if(count($category_array) > 1)
            {
                $popped = $category_array;
                array_pop($popped);
                $temp = implode(" / ", $popped);
                if (!in_array($temp, $cat_unique)) 
                {
                    array_push($cat_unique, $temp);
                }

                if(count($popped) > 1)
                {
                    $popped2 = $popped;
                    array_pop($popped2);
                    $temp = implode(" / ", $popped2);
                    if (!in_array($temp, $cat_unique)) 
                    {
                        array_push($cat_unique, $temp);
                    }
                }


            }

        }

        usort($cat_unique, function($a, $b) {return strlen($b) - strlen($a);});
        
        //dd(array_reverse($cat_unique));

        foreach(array_reverse($cat_unique) as $category_path)
        {
            $category_array = explode(" / ", $category_path);
            $popped =  $category_array;

            $pop = array_pop($popped);
            $temp = implode(" / ", $popped);

            $cat = new Category();
            $cat->name = $pop;
            $cat->url = str_slug($pop);

            if(count($category_array) > 1)
            {
                $cat->parent_id = $category_ids[$temp];
            }

            $cat->save();

            $category_ids[$category_path] = $cat->id;
        }

        

        foreach($items['products'] as $key => $item)
        {      
        
            $product = new Product();
            $product->name = $item['text1'];
            $product->desc = $item['detail'];
            $product->code = $item['product_id'];
            $product->price_unit = 'ks';
            $product->maker = 'Dedra';
            $product->moc_sort_price = $item['price_skk'];
            $product->voc_sort_price = $item['price_skk'];
            $product->save();

            $image = new File();
            $image->product_id = $product->id;
            $image->path = $item['picture1']; 
            $image->type = 'image';
            $image->primary = 1;
            $image->save();

            $product->categories()->attach($category_ids[$item['kategorie']]);

            $pricelevel = new PriceLevel();
            $pricelevel->threshold = 1;
            $pricelevel->moc_regular = $item['price_skk'];
            $pricelevel->moc_sale = $item['price_skk'];
            $pricelevel->voc_regular = $item['price_skk'];
            $pricelevel->voc_sale = $item['price_skk'];

            $product->priceLevels()->save($pricelevel);
        }
        
    }


    public function dashboardNew()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts(),
            'bodyid' => 'dashboard'

        ];

        return view('admin.dashboard.new', $data);
    }

    public function dashboardOverall()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts(),
            'bodyid' => 'dashboard'

        ];

        return view('admin.dashboard.overall', $data);
    }

    public function categories()
    {
        $data = [
            'categories' => $this->categoryService->getCategories(),
            'categoryCounts' => $this->productService->categoryCounts(),
        ];

        return view('admin.eshop.categories', $data);
    }
    
    public function users()
    {
        $data = [
            'users' => User::all(),
        ];

        return view('admin.users.index', $data);
    }

    public function files()
    {
        $data = [
            'files' => File::where('type','system')->get()
        ];

        return view('admin.files.files', $data);
    }

    public function catalogues()
    {
        $data = [
            'catalogues' => File::where('type','catalogue')->get()
        ];

        return view('admin.files.catalogues', $data);
    }

    public function eshopStickers()
    {
        $data = [
            'stickers' => Sticker::all()
        ];

        return view('admin.eshop.stickers', $data);
    }

    public function stickers()
    {
        $data = [
            'stickers' => Sticker::all()
        ];

        return view('admin.files.stickers', $data);
    }



    public function category($category, Request $request)
    {
        $cat = Category::where('url',$category)->first();

        $data = [
            'products' => $cat->products,
            'category' => $cat,
            'categories' => $this->categoryService->getCategories(),
            'categoryCounts' => $this->productService->categoryCounts()
        ];

        $request['category'] = $cat->id;

        return view('admin.eshop.category', $data);
    }




    public function products()
    {
        $data['bodyid'] = 'body_bulk';

        return view('admin.bulk', $data);
    }


    public function new()
    {
        return view('admin.eshop.new');
    }

    public function sale()
    {
        return view('admin.eshop.sale');
    }

    public function bestsellers()
    {
        return view('admin.eshop.bestsellers');
    }

    public function inactive()
    {
        return view('admin.eshop.inactive');
    }
    


    public function orders()
    {
        $data = [
            'orders' => Order::all()
        ];

        return view('admin.orders.index', $data);
    }

    public function params()
    {
        $data = [
            'params' => Parameter::all()
        ];

        return view('admin.params.index', $data);
    }

    public function manageCategoryParams($categoryid)
    {
        $data = [
            'activecategory' => Category::find($categoryid)
        ];

        return view('admin.params.index', $data);
    }


    public function orderDetail($id)
    {
        $data = [
            'order' => Order::find($id)
        ];

        return view('admin.orderdetail', $data);
    }

    
    public function userDetail($id)
    {
        

        $data = [
            'user' => User::find($id)
        ];

        return view('admin.users.userdetail', $data);
    }

    public function userPricing($id)
    {
        $data = [
            'user' => User::find($id)
        ];

        return view('admin.users.userpricing', $data);
    }


    public function userOrders($id)
    {
        $userOrdersPrice = 0;
        foreach (User::find($id)->orders as $order){
            $userOrdersPrice =+ $order->products->sum('price');
        }

        $data = [
            'user' => User::find($id),
            'userOrdersPrice' => $userOrdersPrice
        ];

        return view('admin.users.userorders', $data);
    }


    public function userCart($id)
    {
        $usercart = User::find($id)->cart;

        $data = [
            'user' => User::find($id),
            'usercart' => $usercart
        ];

        return view('admin.users.usercart', $data);
    }



    public function banners()
    {
        return view('admin.banners.banners');
    }

    public function bannersSettings()
    {
        return view('admin.banners.settings');
    }

    public function eshop()
    {
        return view('admin.settings.eshop');
    }

    public function delivery()
    {
        return view('admin.settings.delivery');
    }

    public function emails()
    {
        return view('admin.settings.emails');
    }

    public function invoice()
    {
        return view('admin.settings.invoice');
    }


    public function site()
    {
        return view('admin.settings.site');
    }

    public function pages()
    {
        $data['pages'] = Page::orderBy('order')->get();

        return view('admin.pages.list', $data);
    }

    public function pageEdit($url)
    {
        $data = [
         'page' => Page::whereUrl($url)->first(),
         'texts' => Text::all()
        ];

        return view('admin.pages.edit', $data);
    }

    public function texts()
    {
        $data['texts'] = Text::get();

        return view('admin.texts.list', $data);
    }

    public function textEdit($id)
    {
        $data = [
         'text' => Text::find($id)
        ];

        return view('admin.texts.edit', $data);
    }

    public function stickerEdit($id)
    {
        $data = [
         'sticker' => Sticker::find($id)
        ];

        return view('admin.stickers.edit', $data);
    }




    public function import()
    {
        $data = [
        ];

        return view('admin.import', $data);
    }

    public function postImport(Request $request)
    {
        $file = $request->file('file');

        $results  = Excel::load($file, function($reader) {
            
        })->get();  

        // check the results, and add valid flag at the end
        
        return $results;
    }


    public function importJson()
    {
        $data = [
        ];

        return view('admin.importjson', $data);
    }

    public function postImportJson(Request $request)
    {
        $json = json_decode($request->get('json'));
        return $json;
    }


    public function addDeliveryMethod(Request $request)
    {
        $delivery = new DeliveryMethod();
        $delivery->name = $request->get('name');
        $delivery->key = str_slug($request->get('name'));
        $delivery->desc = $request->get('desc');
        $delivery->icon = $request->get('icon');
        $delivery->price = $request->get('price');
        $delivery->note = $request->get('note');

        $delivery->save();

        return $delivery;
    }

    public function editDeliveryMethod($id, Request $request)
    {
        $delivery = DeliveryMethod::find($id);
        $delivery->name = $request->get('name');
        $delivery->desc = $request->get('desc');
        $delivery->icon = $request->get('icon');
        $delivery->price = $request->get('price');
        $delivery->save();

        return $delivery;
    }

    public function deleteDeliveryMethod($id)
    {
        $delivery = DeliveryMethod::find($id);
        $delivery->delete();

        return 1;
    }

    public function addPaymentMethod(Request $request)
    {
        $payment = new PaymentMethod();
        $payment->name = $request->get('name');
        $payment->key = str_slug($request->get('name'));
        $payment->desc = $request->get('desc');
        $payment->icon = $request->get('icon');
        $payment->price = $request->get('price');
        $payment->note = $request->get('note');
        $payment->save();

        return $payment;
    }

    public function editPaymentMethod($id, Request $request)
    {
        $payment = PaymentMethod::find($id);
        $payment->name = $request->get('name');
        $payment->desc = $request->get('desc');
        $payment->icon = $request->get('icon');
        $payment->price = $request->get('price');
        $payment->save();

        return $payment;
    }

    public function deletePaymentMethod($id)
    {
        $payment = PaymentMethod::find($id);
        $payment->delete();

        return 1;
    }

    public function addDeliveryPayment(Request $request)
    {
        $delivery = DeliveryMethod::find($request->get('delivery_method_id'));
        $payment = PaymentMethod::find($request->get('payment_method_id'));

        return $delivery->paymentMethods()->attach($payment);

    }

    public function changeDeliveryPayment(Request $request)
    {
        $delivery = DeliveryMethod::find($request->get('delivery_method_id'));
        $payment = PaymentMethod::find($request->get('payment_method_id'));
        $price = $request->get('price');

        return $delivery->paymentMethods()->updateExistingPivot($payment->id,['price'=>$price]);

    }

    public function addColor(Request $request)
    {
        $color = new Color();
        $color->key = $request->get('key');
        $color->value = $request->get('value');
        $color->save();

        return $color;
    }
    
    public function removeDeliveryPayment(Request $request)
    {
        $delivery = DeliveryMethod::find($request->get('delivery_method_id'));
        $payment = PaymentMethod::find($request->get('payment_method_id'));

        return $delivery->paymentMethods()->detach($payment);

    }






    public function uploadAndStoreBanner(Request $request)
    {
        $file = $request->file('file');

        $destinationPath = 'uploads/covers';

        $extension = $file->getClientOriginalExtension(); 
        $filename = $file->getClientOriginalName().'.'.$extension;
        $fullpath = $destinationPath.'/'.$filename;

        $success = $file->move($destinationPath, $filename);

        if ($success)
        {
            $cover = new Cover();
            $cover->image = $destinationPath.'/'.$filename;
            $cover->save();
        }

        return redirect('/admin/settings/banners');

    }





    public function uploadCover(Request $request)
    {   
        $file = $request->file('file');

        $destinationPath = 'temp/covers';
        $extension = $file->getClientOriginalExtension(); 
        $filename = $file->getClientOriginalName();
        $fullpath = $destinationPath.'/'.$filename;

        $preview_success = $file->move($destinationPath, $filename);

        return $fullpath;

    }


    public function setBannerOrder(Request $request)
    {
        foreach(Banner::where('type','banner')->get() as $cover)
        {
            $cover->order = $request->get($cover->id);
            $cover->save();
        }
    }

    public function setCoverOrder(Request $request)
    {
        foreach(Banner::where('type','cover')->get() as $cover)
        {
            $cover->order = $request->get($cover->id);
            $cover->save();
        }
    }


    public function layoutTemplates()
    {

        return view('admin.layout.templates');
    }

    public function setLayout(Request $request)
    {

        $setting = Setting::firstOrNew(['name' => 'layout']);
        $setting->value = $request->get('layout');
        $setting->save();

    }

    public function layoutHome()
    {

        return view('admin.layout.home');
    }

}
