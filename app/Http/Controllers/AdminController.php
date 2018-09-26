<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use App\Cover;
use App\Setting;
use App\Color;
use App\Parameter;
use App\File as ProductFile;
use App\PriceLevel;
use App\File;


use Auth;
use Excel;
use Image;
use Storage;
use Cookie;
use Exception;
use DB;

use App\DeliveryMethod;
use App\PaymentMethod;

use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\CategoryServiceContract;

use Orchestra\Parser\Xml\Facade as XmlParser;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductServiceContract $productService, CategoryServiceContract $categoryService)
    {        
        $this->middleware('auth');
        $this->productService = $productService;
        $this->categoryService = $categoryService;

    }

    public function translate()
    {
        $client = new \GoogleTranslate\Client('AIzaSyCEYe59xoog4g8GvqPOrBOP-veGVY8IFqI');
        foreach(Product::where('translate_error',1)->get() as $product)
        {   
    
            $sourceLanguage = 'cs';
            $name = $client->translate($product->name, 'sk', $sourceLanguage);

            if ($product->desc)
            {
                $desc = $client->translate($product->desc, 'sk', $sourceLanguage);
                $product->desc = $desc;
            }

            $product->name = $name;
            $product->translated = 1;
            $product->translate_error = null;

            $product->save();
     
        }

    }


    public function xmlUpdate()
    {
        return view('admin.eshop.xmlupdate');
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
            'products' => ['uses' => 'product[kategorie,product_id,text1,text2,text3,detail,meritko,picture1,picture2,picture3,picture4,picture5,picture6,price_skk,stav_skladu,variant_text,variant_image]'],
        ]);

        DB::beginTransaction();
        $changes = [];
        $changes['new_categories'] = [];
        $changes['new_products'] = [];
        $changes['removed_categories'] = [];
        $changes['removed_products'] = [];

        foreach($items['products'] as $key => $item)
        {
            $query = Product::where('code',$item['product_id']);
            $count = $query->count();
            $product = $query->first();

            // novy produkt ktory je v XML ale nie je v DB
            if($count==0)
            {
                $productCategory = $item['kategorie'];

                $productCategoryArray = explode(' / ',$item['kategorie']);


                $dbCategory1 = Category::where('path',$productCategoryArray[0])->first();

                if(isset($productCategoryArray[1]))
                {
                    $dbCategory2 = Category::where('path',$productCategoryArray[0].' / '.$productCategoryArray[1])->first();
                }

                if(isset($productCategoryArray[2]))
                {
                    $dbCategory3 = Category::where('path',$productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2])->first();
                }

                if(isset($productCategoryArray[3]))
                {
                    $dbCategory4 = Category::where('path',$productCategoryArray[0].' / '.$productCategoryArray[1].' / '.$productCategoryArray[2].' / '.$productCategoryArray[3])->first();
                }

                if(!$dbCategory1)
                {
                    $cat = new Category();
                    $cat->name = $productCategoryArray[0];
                    $cat->url = str_slug($productCategoryArray[0]);
                    $cat->path = $productCategoryArray[0];
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


                $product = new Product();
                $product->name = $item['text1'];
                $product->desc = $item['detail'];
                $product->code = $item['product_id'];
                $product->price = $item['price_skk'];
                $product->price_unit = 'ks';
                $product->maker = 'Dedra';
                $product->moc_sort_price = $item['price_skk'];
                $product->voc_sort_price = $item['price_skk'];
                $product->save();

                array_push($changes['new_products'],$product);


                $image = new ProductFile();
                $image->product_id = $product->id;
                $image->path = $item['picture1']; 
                $image->type = 'image';
                $image->primary = 1;
                $image->save();

                $product->categories()->attach($categoryID);

                $pricelevel = new PriceLevel();
                $pricelevel->threshold = 1;
                $pricelevel->moc_regular = $item['price_skk'];
                $pricelevel->moc_sale = $item['price_skk'];
                $pricelevel->voc_regular = $item['price_skk'];
                $pricelevel->voc_sale = $item['price_skk'];

                $product->priceLevels()->save($pricelevel);

            }
            else
            {
                $product->name = $item['text1'].' '.$item['text2'];
                $product->save();
            }

        }

        return $changes;
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
        $contents = Storage::get('dedra.xml');
        $xml = XmlParser::extract($contents);

        $items = $xml->parse([
            'products' => ['uses' => 'product[product_id,picture1,picture2,picture3,picture4,picture5,picture6]'],
        ]);

        foreach(array_reverse($items['products']) as $key => $item)
        {   

            $product = Product::where('code',$item['product_id'])->where('temp',0)->first(); 

            if($product && $item['picture2'] != '')
            {
                if(ProductFile::where('path', $item['picture2'])->count() == 0)
                {
                    $image = new ProductFile();
                    $image->product_id = $product->id;
                    $image->path = $item['picture2']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($product && $item['picture3'] != '')
            {
                if(ProductFile::where('path', $item['picture3'])->count() == 0)
                {
                    $image = new ProductFile();
                    $image->product_id = $product->id;
                    $image->path = $item['picture3']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($product && $item['picture4'] != '')
            {
                if(ProductFile::where('path', $item['picture4'])->count() == 0)
                {
                    $image = new ProductFile();
                    $image->product_id = $product->id;
                    $image->path = $item['picture4']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($product && $item['picture5'] != '')
            {

                if(ProductFile::where('path', $item['picture5'])->count() == 0)
                {
                    $image = new ProductFile();
                    $image->product_id = $product->id;
                    $image->path = $item['picture5']; 
                    $image->type = 'image';
                    $image->primary = 0;
                    $image->save();
                }
            }

            if($product &&  $item['picture6'] != '')
            {
                $image = new ProductFile();
                $image->product_id = $product->id;
                $image->path = $item['picture6']; 
                $image->type = 'image';
                $image->primary = 0;

                if(ProductFile::where('path', $item['picture6'])->count() == 0)
                {
                    $image->save();
                }
            }
            if($product){
                $product->temp = 1;
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
        
        foreach(ProductFile::all() as $temp)
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

            $image = new ProductFile();
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

        return view('admin.files', $data);
    }

    public function products($category, Request $request)
    {
        $cat = Category::where('url',$category)->first();

        $data = [
            'products' => $cat->products,
            'category' => $cat,
            'categories' => $this->categoryService->getCategories(),
            'categoryCounts' => $this->productService->categoryCounts()
        ];

        $request['category'] = $cat->id;

        return view('admin.eshop.products', $data);
    }

    public function new()
    {
        return view('admin.eshop.new');
    }

    public function sale()
    {
        return view('admin.eshop.sale');
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
        return view('admin.settings.banners');
    }

    public function eshop()
    {
        return view('admin.settings.eshop');
    }

    public function delivery()
    {
        return view('admin.settings.delivery');
    }

    public function invoice()
    {
        return view('admin.settings.invoice');
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

    public function addCover()
    {
        return view('admin.addcover');
    }




    public function editCover($id)
    {

        $data = [
            'cover'=>Cover::find($id)
        ];

        return view('admin.addcover', $data);
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

    public function storeCover(Request $request)
    {
        $filename = $request->get('filename');

        $x = round($request->get('x'));
        $y = round($request->get('y'));
        $w = round($request->get('w'));
        $h = round($request->get('h'));

        $path = 'temp/covers/'.$filename;
        $destinationPath = 'uploads/covers';


        $width = 1920;   

        Image::make($path)
                 ->crop($w, $h, $x, $y)
                 ->widen($width)
                 ->save($destinationPath.'/'.$filename);


        $cover = new Cover();
        $cover->image = $destinationPath.'/'.$filename;
        $cover->left = $request->get('left');
        $cover->top = $request->get('top');
        $cover->h1_font = $request->get('h1_font');
        $cover->h2_font = $request->get('h2_font');
        $cover->h1_size = $request->get('h1_size');
        $cover->h2_size = $request->get('h2_size');
        $cover->h1_color = $request->get('h1_color');
        $cover->h2_color = $request->get('h2_color');
        $cover->width = $request->get('width');
        $cover->h1_text = $request->get('h1_text');
        $cover->h2_text = $request->get('h2_text');
        $cover->url = $request->get('url');

        $cover->save();

        return redirect('/admin/settings/banners');
    }

    public function updateCover($id, Request $request)
    {
        $cover = Cover::find($id);
        $cover->left = $request->get('left');
        $cover->top = $request->get('top');
        $cover->h1_font = $request->get('h1_font');
        $cover->h2_font = $request->get('h2_font');
        $cover->h1_size = $request->get('h1_size');
        $cover->h2_size = $request->get('h2_size');
        $cover->h1_color = $request->get('h1_color');
        $cover->h2_color = $request->get('h2_color');
        $cover->width = $request->get('width');
        $cover->h1_text = $request->get('h1_text');
        $cover->h2_text = $request->get('h2_text');
        $cover->url = $request->get('url');

        if ($request->filled('filename'))
        {
            $filename = $request->get('filename');

            $x = round($request->get('x'));
            $y = round($request->get('y'));
            $w = round($request->get('w'));
            $h = round($request->get('h'));

            $path = 'temp/covers/'.$filename;
            $destinationPath = 'uploads/covers';


            $width = 1920;   

            Image::make($path)
                     ->crop($w, $h, $x, $y)
                     ->widen($width)
                     ->save($destinationPath.'/'.$filename);

        $cover->image = $destinationPath.'/'.$filename;

        }

        $cover->save();

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

    public function deleteCover($id)
    {
        $cover = Cover::find($id);
        $cover->delete();
        return 1;
    }

    public function setCoverOrder(Request $request)
    {
        foreach(Cover::all() as $cover)
        {
            $cover->order = $request->get($cover->id);
            $cover->save();
        }
    }


    public function layout()
    {

        return view('admin.layout');
    }

    public function setLayout(Request $request)
    {

        $setting = Setting::firstOrNew(['name' => 'layout']);
        $setting->value = $request->get('layout');
        $setting->save();

    }

    public function homePageSeetings()
    {

        return view('admin.pages.home');
    }

}
