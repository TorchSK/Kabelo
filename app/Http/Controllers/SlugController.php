<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Category;


use File;

class SlugController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


	public function show($url, Request $request)
	{
		$pageSlugs = Page::all()->pluck('url')->toArray();

		if(in_array($url, $pageSlugs))
		{
			return app('App\Http\Controllers\PageController')->profile($url, $request);		
		}
		else
		{
			return app('App\Http\Controllers\CategoryController')->products($url, $request);		
		}
	}

	public function spolupraca(){
		return view('pages.spolupraca');
	}

}
