<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\ServiceProvider;



use Cookie;
use Crypt;
use App\User;
use App\Cart;
use Config;
use Request;

class AppnameComposer {

    public function __construct()
    {        
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {   
        $appname = env('APP_NAME');

        if($appname == 'Laravel')
        {
            $appname = 'Dedra';
        }

        $view->with('appname', strtolower($appname));
    }

}