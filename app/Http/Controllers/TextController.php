<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Text;

class TextController extends Controller
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
        $text = new Text();
        $text->name = $request->get('name');
        $text->save();

        return 1;
    }   

    public function show($id)
    {   
        $data['text'] = Text::find($id);

        return view('texts.profile',$data);
    }   

    public function update($id, Request $request)
    {   
        $text = Text::find($id);
        $text->name = $request->get('name');
        
        if($request->filled('mce')){
            $text->text = $request->get('mce');
        }

        $text->save();
        
        return redirect()->back();
    }  

    public function destroy($id)
    {
        $text = Text::find($id);
        $text->delete();
    }
}
