<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Category;


use File;

class SeoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


	public function settings()
	{
		return view('admin.seo.settings');

	}

	public function tools(){
		return view('admin.seo.tools');
	}

}
