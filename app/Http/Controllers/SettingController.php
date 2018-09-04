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


	public function update($id, $value)
	{
		$setting = Setting::find($id);

		$setting->value = $value;

		$setting->save();
	}

	public function bulkUpdate(Request $request)
	{
		foreach($request->except('_token') as $key => $item)
		{
			$setting = Setting::where('name', $key)->first();
			
			if($setting)
			{
				$this->update($setting->id, $item);		
			}
		}

		return redirect()->back();
	}

}
