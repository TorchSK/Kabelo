<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Text;

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

    public function profile($url, Request $request)
    {   
        $data['page'] = Page::whereUrl($url)->first();

        return view('pages.profile',$data);
    }   


    public function store(Request $request)
    {   
        $page = new Page();
        $page->name = $request->get('name');
        $page->url = str_slug($request->get('url'));
        $page->save();

        return 1;
    }   

    public function apiUpdate($id, Request $request)
    {   
        $page = Page::find($id);
        foreach($request->except('_token') as $key => $value)
        {
            $page->$key = $value;
            $page->save();
        }
        
        return 1;
    }  

    public function update($id, Request $request)
    {   
        $page = Page::find($id);
        $page->name = $request->get('name');
        $page->url = $request->get('url');
        $page->save();
        
        return redirect()->back();
    }  

    public function attachText($pageid, $textid)
    {   
        $page = Page::find($pageid);
        $page->texts()->attach($textid);
        $page->save();
        
        return 1;
    }  

    public function detachText($pageid, $textid)
    {   
        $page = Page::find($pageid);
        $page->texts()->detach($textid);
        $page->save();
        
        return 1;
    }  

    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();
    }
}
