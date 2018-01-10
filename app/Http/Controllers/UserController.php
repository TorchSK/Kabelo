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

    public function settings(){
        return view('users.settings');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
