<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Parameter;

use App\Services\Contracts\CartServiceContract;

use DB;
use Cookie;
use Auth;
use Mail;
use Carbon\Carbon;

class ParamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function store(Request $request)
    {   
        $param = new Parameter();
        $param->key = $request->get('key');
        $param->display_key = $request->get('display_key');
        $param->save();

        return $param;
    }   

    public function update($id, Request $request)
    {   
        $param = Parameter::find($id);
        $param->key = $request->get('key');
        $param->display_key = $request->get('display_key');
        $param->save();

        return $param;
    }   


}
