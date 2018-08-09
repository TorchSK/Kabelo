<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Setting;

use File;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


	public function update($id, Request $request)
	{
		$setting = Setting::find($id);

		if ($setting){
			$setting->name = $request->get('name');
			$setting->value = $request->get('value');

			$setting->save();
		}
		else
		{
			$setting = new Setting();
			$setting->name = $request->get('name');
			$setting->value = $request->get('value');

			$setting->save();
		}
	}

}
