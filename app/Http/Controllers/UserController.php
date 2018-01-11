<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Welcome;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthRequest;

use Mail;
use Hash;
use Auth;

use App\User;
use App\Address;
use App\Activation;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
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

    public function register(RegisterRequest $request)
    {
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $user = User::create($data);

        $user->password = Hash::make($data['password']);
        $user->save();
        
        $token = $this->createActivationToken($user);
        $email = $this->sendActivationEmail($user->id);

        return 1;
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

    public function login(AuthRequest $request)
    {
     
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if(Auth::attempt($credentials, true))
        {
            return 0;
        }

        return -1;
    }

    public function update($id, Request $request){
        $user = User::find($id);

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->phone = $request->get('phone');

        if (!$user->invoiceAddress && $request->get('invoiceAddress')['street'])
        {
            $invoiceAddress = new Address();
            
            $invoiceAddress->street =  $request->get('invoiceAddress')['street'];
            $invoiceAddress->zip =  $request->get('invoiceAddress')['zip'];
            $invoiceAddress->city =  $request->get('invoiceAddress')['city'];
            $invoiceAddress->type =  'invoice';
            $invoiceAddress->state =  'Slovenská Republika';

            $user->invoiceAddress()->save($invoiceAddress);

        }
        elseif($user->invoiceAddress)
        {
            $invoiceAddress = $user->invoiceAddress;

            $invoiceAddress->street =  $request->get('invoiceAddress')['street'];
            $invoiceAddress->zip =  $request->get('invoiceAddress')['zip'];
            $invoiceAddress->city =  $request->get('invoiceAddress')['city'];
            
            $invoiceAddress->save();

        }

        if (!$user->deliveryAddress && $request->get('deliveryAddress')['street'])
        {
            $deliveryAddress = new Address();
            
            $deliveryAddress->name =  $request->get('deliveryAddress')['name'];
            $deliveryAddress->street =  $request->get('deliveryAddress')['street'];
            $deliveryAddress->zip =  $request->get('deliveryAddress')['zip'];
            $deliveryAddress->city =  $request->get('deliveryAddress')['city'];
            $deliveryAddress->additional =  $request->get('deliveryAddress')['additional'];
            $deliveryAddress->phone =  $request->get('deliveryAddress')['phone'];

            $deliveryAddress->type =  'delivery';
            $deliveryAddress->state =  'Slovenská Republika';

            $user->deliveryAddress()->save($deliveryAddress);

        }
        elseif($user->deliveryAddress)
        {
            $deliveryAddress = $user->deliveryAddress;

            $deliveryAddress->name =  $request->get('deliveryAddress')['name'];
            $deliveryAddress->street =  $request->get('deliveryAddress')['street'];
            $deliveryAddress->zip =  $request->get('deliveryAddress')['zip'];
            $deliveryAddress->city =  $request->get('deliveryAddress')['city'];
            $deliveryAddress->additional =  $request->get('deliveryAddress')['additional'];
            $deliveryAddress->phone =  $request->get('deliveryAddress')['phone'];
            
            $deliveryAddress->save();

        }


        $user->save();

        return 1;

    }   

    public function settings(){
        return view('users.settings');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
