<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function set($id, Request $request)
    {
        $page = Page::find($id);
        
        $page->update($request->all());

        return 1;
    }

    public function setOrder(Request $request)
    {
        foreach(Page::where('active',1)->get() as $page)
        {
            $page->order = $request->get('orders')[$page->id];

            $page->save();
        }
    }


}
