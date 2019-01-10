<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Contracts\ProductServiceContract;
use App\Mail\NewOrder;
use App\Services\Contracts\CategoryServiceContract;

use App\Category;
use App\Order;
use App\Product;
use App\User;
use App\Text;

use Mail;
use Cookie;

class UtilController extends Controller
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

    public function cookie(){
        $cart = Cookie::get('cart');
        dd($cart);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function connectorsGuide()
    {       
        return view('pages/connectorsguide');
    }

    public function contactPage(Request $request)
    {       
        $data['bodyid'] = 'body_contact';

        if ($request->segment(2)=='edit')
        {
            $data['editmode'] =1;
        }
        else
        {
            $data['editmode'] = 0;
        }

        return view('pages/contact', $data);
    }

    public function termsPage(Request $request)
    {       
        if ($request->segment(2)=='edit')
        {
            $data['editmode'] = 1;
        }
        else
        {
            $data['editmode'] = 0;
        }
        return view('pages/terms',$data);
    }

    public function gdprPage(Request $request)
    {       
        $data['bodyid'] = 'body_gdpr';

        if ($request->segment(2)=='edit')
        {
            $data['editmode'] =1;
        }
        else
        {
            $data['editmode'] = 0;
        }

        return view('pages/gdpr', $data);
    }

    public function spolupracaPage(Request $request)
    {       
  

        return view('pages/spolupraca');
    }

    public function catalogue($id)
    {       
        return view('pages/catalogue/'.$id.'/ui');
    }

    public function setCookie(Request $request)
    {       
        $name = $request->get('name');
        $value = $request->get('value');
        $expiry = $request->get('expiry');

        return Cookie::queue($name,$value, $expiry);
    }


    public function cookiesInfo()
    {       
        return view('utils/cookiesinfo');
    }

    public function sendOrderEmail()
    {       
        $order = Order::find(2);
        Mail::to(json_decode($order->invoice_address)->email)->queue(new NewOrder($order));
    }

     public function setConfig(Request $request)
    {      
        foreach ($request->all() as $key => $value)
        {
        config(['app.'.$key => $value]);
        }
    }

    public function searchAll($query)
    {
        $data['products'] = Product::where('name', 'like', '%'.$query.'%')->orWhere("desc", "like", "%".$query."%")->orWhere("code", "like", "%".$query."%")->whereActive(1)->take(5)->get();
        $data['users'] = User::where('name', 'like', '%'.$query.'%')->orWhere("email", "like", "%".$query."%")->take(5)->get();

        return response()->json(['products'=>view('search.products', $data)->render(), 'users'=>view('search.users', $data)->render()]);
    }

    public function search($query)
    {
        $data['products'] = Product::where('name', 'like', '%'.$query.'%')->orWhere("desc", "like", "%".$query."%")->orWhere("code", "like", "%".$query."%")->paginate(28);
        $data['categories']  = $this->categoryService->getCategories();


        return view('search.all', $data);
    }

    public function setText(Request $request)
    {      
        Text::updateOrCreate(['key' => $request->get('key')], ['text' => $request->get('text')]);
    }
}
