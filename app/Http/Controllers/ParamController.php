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

    public function createUrlName($name)
    {
      // count the number of dogs with same name
    $number = Parameter::where('key', $name)->count();
    $number = $number+1;
    
    $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,č, ");
    $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,c,-");

        $new = strtolower(trim(str_replace($search, $replace, $name.'-'.$number)));

    while (Parameter::where('key', $new)->count()>0)
    {
      $number = $number+1;
      $new = strtolower(trim(str_replace($search, $replace, $name.'-'.$number)));
    }

    return $new;
    }

    public function store(Request $request)
    {   
        $param = new Parameter();
        $param->key = $this->createUrlName($request->get('display_key'));
        $param->display_key = $request->get('display_key');
        $param->save();

        return $param;
    }   

    public function update($id, Request $request)
    {   
        $param = Parameter::find($id);
        $param->key =  $this->createUrlName($request->get('display_key'));
        $param->display_key = $request->get('display_key');
        $param->save();

        return $param;
    }   

    public function destroy($id)
    {   
        $param = Parameter::find($id);

        foreach ($param->productParameters as $p)
        {
            $p->delete();
        }

        $param->delete();

        return $param;
    }   

}
