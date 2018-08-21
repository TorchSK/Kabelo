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

use Auth;
use Excel;
use Image;
use Storage;
use Cookie;

use App\DeliveryMethod;
use App\PaymentMethod;

use App\Services\Contracts\ProductServiceContract;

use Orchestra\Parser\Xml\Facade as XmlParser;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductServiceContract $productService)
    {        
        $this->middleware('auth');
        $this->productService = $productService;
    }

    public function translate()
    {
        $client = new \GoogleTranslate\Client('AIzaSyCEYe59xoog4g8GvqPOrBOP-veGVY8IFqI');
        foreach(Product::all() as $product)
        {
            $sourceLanguage = 'cs';
            $name = $client->translate($product->name, 'sk', $sourceLanguage);

            if ($product->desc)
            {
                $desc = $client->translate($product->desc, 'sk', $sourceLanguage);
                $product->desc = $desc;
            }

            $product->name = $name;
            $product->save();
        }

    }
    public function xmlImport()
    {
        
        $contents = Storage::get('dedra.xml');
        $xml = XmlParser::extract($contents);

        $items = $xml->parse([
            'categories' => ['uses' => 'product[kategorie]'],
            'products' => ['uses' => 'product[product_id,text1,text2,text3,detail,meritko,picture1,picture2,picture3,picture4,picture5,picture6,price_skk,stav_skladu,variant_text,variant_image]'],
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

        foreach($items['categories'] as $key => $item)
        {   

            $cat_array = explode(" / ", $item['kategorie']);

            if(isset($cat_array[0]))
            {
                $categories[$key][1] = $cat_array[0];
            }

            if(isset($cat_array[1]))
            {
                $categories[$key][2] = $cat_array[1];
            }

            if(isset($cat_array[2]))
            {
                $categories[$key][3] = $cat_array[2];
            }

            if(isset($cat_array[3]))
            {
                $categories[$key][4] = $cat_array[3];
            }
        }


        foreach($categories as $key => $item)
        {
            $categories[$key]['id'] = null;
            try{
                $cat = new Category();
                $cat->name = $item[1];
                $cat->url = str_slug($item[1]);
                if (Category::where('name', $item[1])->count() == 0) 
                {
                    $cat->save();
                    $categories[$key]['id'] = $cat->id;
                    $lastid = $cat->id;
                }
        
     
                if(isset($item[2])){
                    $cat = new Category();
                    $cat->name = $item[2];
                    $cat->url = str_slug($item[2]);
                    $cat->parent_id = Category::where('name',$categories[$key][1])->first()->id;
                    $cat->save();
                    $categories[$key]['id'] = $cat->id;
                    $lastid = $cat->id;

                }
       

        
                if(isset($item[3])){
                    $cat = new Category();
                    $cat->name = $item[3];
                    $cat->url = str_slug($item[3]);
                    $cat->parent_id = Category::where('name',$categories[$key][2])->first()->id;
                    $cat->save();
                    $categories[$key]['id'] = $cat->id;
                    $lastid = $cat->id;

                }
     

       
                if(isset($item[4])){
                    $cat = new Category();
                    $cat->name = $item[4];
                    $cat->url = str_slug($item[4]);
                    $cat->parent_id = Category::where('name',$categories[$key][3])->first()->id;
                    $cat->save();
                    $categories[$key]['id'] = $cat->id;
                    $lastid = $cat->id;

                }
            }
            catch(\Illuminate\Database\QueryException $e){
                  $categories[$key]['id'] = $lastid;
            }
        }

        foreach($items['products'] as $key => $item)
        {
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

            $image = new ProductFile();
            $image->product_id = $product->id;
            $image->path = $item['picture1']; 
            $image->type = 'image';
            $image->primary = 1;
            $image->save();


            $category = Category::where('name', end($categories[$key]))->first()->id;
            $product->categories()->attach($category);

            $pricelevel = new PriceLevel();
            $pricelevel->threshold = 1;
            $pricelevel->moc_regular = $item['price_skk'];
            $pricelevel->moc_sale = $item['price_skk'];
            $pricelevel->voc_regular = $item['price_skk'];
            $pricelevel->voc_sale = $item['price_skk'];

            $product->priceLevels()->save($pricelevel);
        }
    }


    public function dashboard()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts(),
            'bodyid' => 'dashboard'

        ];

        return view('admin.dashboard', $data);
    }

    
    public function manageProducts()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts()

        ];

        return view('admin.index', $data);
    }

    public function manageUsers()
    {
        $data = [
            'users' => User::all(),
        ];

        return view('admin.users', $data);
    }


    public function categoryProducts($category, Request $request)
    {
        $cat = Category::where('url',$category)->first();

        if($category != 'unknown')
        {
            $data = [
                'products' => $cat->products,
                'category' => $cat,
                'categories' => Category::orderBy('order','asc')->get(),
                'categoryCounts' => $this->productService->categoryCounts()
            ];

            $request['category'] = $cat->id;

        }
        else
        {
            $data = [
                'products' => Product::doesntHave('categories')->get(),
                'categories' => Category::orderBy('order','asc')->get(),
                'category' => 'unknown',
                'categoryCounts' => $this->productService->categoryCounts()

            ];
        }

        return view('admin.products', $data);
    }

    
    public function manageOrders()
    {
        $data = [
            'orders' => Order::all()
        ];

        return view('admin.orders', $data);
    }

    public function manageParams()
    {
        $data = [
            'params' => Parameter::all()
        ];

        return view('admin.params', $data);
    }

    public function manageCategoryParams($categoryid)
    {
        $data = [
            'activecategory' => Category::find($categoryid)
        ];

        return view('admin.params', $data);
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

        return view('admin.userdetail', $data);
    }

    public function userPricing($id)
    {
        $data = [
            'user' => User::find($id)
        ];

        return view('admin.userpricing', $data);
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

        return view('admin.userorders', $data);
    }


    public function userCart($id)
    {
        $usercart = User::find($id)->cart;

        $data = [
            'user' => User::find($id),
            'usercart' => $usercart
        ];

        return view('admin.usercart', $data);
    }


    public function settingsBanners()
    {
        return view('admin.settings');
    }

    public function settingsEshop()
    {
        return view('admin.settingseshop');
    }

    public function settingsDelivery()
    {
        return view('admin.settingsdelivery');
    }

    public function settingsInvoice()
    {
        return view('admin.settingsinvoice');
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
        $delivery->save();

        return $delivery;
    }

    public function editDeliveryMethod($id, Request $request)
    {
        $delivery = DeliveryMethod::find($id);
        $delivery->name = $request->get('name');
        $delivery->key = $request->get('key');
        $delivery->desc = $request->get('desc');
        $delivery->icon = $request->get('icon');
        $delivery->price = $request->get('price');
        $delivery->save();

        return $delivery;
    }

    public function addPaymentMethod(Request $request)
    {
        $payment = new PaymentMethod();
        $payment->name = $request->get('name');
        $payment->key = str_slug($request->get('name'));
        $payment->desc = $request->get('desc');
        $payment->icon = $request->get('icon');
        $payment->save();

        return $payment;
    }

    public function editPaymentMethod($id, Request $request)
    {
        $payment = PaymentMethod::find($id);
        $payment->name = $request->get('name');
        $payment->key = $request->get('key');
        $payment->desc = $request->get('desc');
        $payment->icon = $request->get('icon');
        $payment->price = $request->get('price');
        $payment->save();

        return $payment;
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
        $cover->save();

        return redirect('/admin/settings');
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

}
