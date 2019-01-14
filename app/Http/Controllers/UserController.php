<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Welcome;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthRequest;

use Mail;
use Hash;
use Auth;
use Cookie;

use DB;
use App\User;
use App\Address;
use App\Activation;
use App\Cart;
use Carbon\Carbon;
use App\Product;

use App\Services\Contracts\ProductServiceContract;


class UserController extends Controller
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

    public function sendActivationEmail($userid)
    {
        $user = User::find($userid);
        Mail::to($user->email)->queue(new Welcome($user));
    }

    public function createActivationToken($user)
    {
        $data = [
            'user_id' => $user->id,
            'token' => str_random(64)
        ];

        $token = Activation::create($data);

        return $token;
    }

       public function getRegister()
    {
        return view('auth.register');
    }

    public function registerSuccess()
    {
        return view('auth.registersuccess');
    }

    public function postRegister(RegisterRequest $request)
    {
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $user = User::create($data);

        $user->password = Hash::make($data['password']);
        $user->save();

        // create DB Cart
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->price  = 0;
        $cart->delivery_method = '';
        $cart->payment_method = '';
        $cart->invoice_address = '{}';
        $cart->delivery_address = '{}';
        $cart->delivery_address_flag = 0;

        $cart->save();

        //create invoice address DB object
        $address = new Address();
        $address->address =  '';
        $address->type =  'invoice';
        $user->invoiceAddress()->save($address);

        //send activation email
        $token = $this->createActivationToken($user);
        $email = $this->sendActivationEmail($user->id);

        return redirect('/register/success');

    }

    public function activate($token)
    {
       $token = Activation::where('token',$token)->first();

       if ($token)
       {
            $user = $token->user;

            $userData = [
                'active' => 1,
                'activated_at' => Carbon::now()
            ];

            $user->update($userData);

            Auth::login($user, true);
            return redirect('/');
        }
        else
        {
            return redirect('/');
        }
       
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if ($auth = Auth::attempt($credentials, true))
        {
            $cookieCart = Cookie::get('cart');
            $dbCart = Auth::user()->cart;

            foreach($cookieCart['items'] as $key=>$item)
            {   
                if (! $dbCart->products->contains($item))
                {
                    $product = Product::find($item);
                    $dbCart->products()->attach($product,['qty' => $cookieCart['counts'][$product->id], 'price_level_id' => $cookieCart['price_levels'][$product->id]]);
                }

            }

            $dbCart->save();



            return redirect('/');
        }
        else
        {
             return redirect('/login')->withErrors(['1'=>'Zadali ste nesprávne heslo']);
        }


    }

    public function update($id, Request $request){

        $user = User::find($id);
        $redirect = $request->get('redirect');

        foreach ($request->except(['_method','redirect','_token','invoice_address', 'delivery_address']) as $key => $value)
        {
             $user->$key = $value;
        }

        if ($user->invoiceAddress)
        {
            $address = $user->invoiceAddress;
            $address->address =  $request->get('invoice_address');
            $address->save();
        }
        else
        {
            $address = new Address();
            $address->address =  $request->get('invoice_address');
            $address->type =  'invoice';
            $user->invoiceAddress()->save($address);
        }

        if ($user->deliveryAddresses->count() > 0)
        {
            $address = $user->deliveryAddresses->first();
            $address->address =  $request->get('delivery_address');
            $address->save();
        }
        else
        {
            $address = new Address();
            $address->address =  $request->get('invoice_address');
            $address->type =  'delivery';
            $user->deliveryAddresses()->save($address);
        }



        $user->save();

        if($request->ajax())
        {
            return 1;
        }
        else
        {
            return redirect()->back();
        }

    }   

    public function settings(){
        return view('users.settings');
    }


    public function logout()
    {

        Auth::logout();
        return redirect('/');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        
        if (isset($user->cart))
        {
            $user->cart->delete();
        }

        $user->delete();

    }


    public function countByDays($daysago)
    {
        $orders = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%c-%e") as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->get();

        return $orders;
    }


}
