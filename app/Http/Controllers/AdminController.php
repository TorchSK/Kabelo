<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Order;
use App\Cover;

use Auth;
use Excel;
use Image;

use App\DeliveryMethod;
use App\PaymentMethod;

use App\Services\Contracts\ProductServiceContract;

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


    public function dashboard()
    {
        $data = [
            'makers' => Product::groupBy('maker'),
            'categories' => Category::orderBy('order','asc')->get(),
            'categoryCounts' => $this->productService->categoryCounts()

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

    public function cookie(){
        $cart = Auth::user()->cart;
        $cart['items'] = $cart->products->pluck('id');
        dd($cart);
    }

    
    public function manageOrders()
    {
        $data = [
            'orders' => Order::all()
        ];

        return view('admin.orders', $data);
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


    public function settings()
    {
        $data = [
            'orders' => Order::all()
        ];

        return view('admin.settings', $data);
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
        $payment->save();

        return $payment;
    }

    public function addDeliveryPayment(Request $request)
    {
        $delivery = DeliveryMethod::find($request->get('delivery_method_id'));
        $payment = PaymentMethod::find($request->get('payment_method_id'));

        return $delivery->paymentMethods()->attach($payment);

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

        return redirect('/admin/settings');
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


}
