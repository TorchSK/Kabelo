<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use App\Banner;


use Image;

class BannerController extends Controller
{

    public function create()
    {
        return view('admin.banners.create');
    }


    public function store(Request $request)
    {
        $filename = $request->get('filename');
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $x = round($request->get('x'));
        $y = round($request->get('y'));
        $w = round($request->get('w'));
        $h = round($request->get('h'));

        $path = 'temp/covers/'.$filename;
        $destinationPath = 'uploads/covers';

        $width = 1920;   

        $mdfilename = md5($filename.time());

        Image::make($path)
                 ->crop($w, $h, $x, $y)
                 ->widen($width)
                 ->save($destinationPath.'/'.$mdfilename.'.'.$ext);


        $cover = new Banner();
        $cover->image = $destinationPath.'/'.$mdfilename.'.'.$ext;
        $cover->left = $request->get('left');
        $cover->top = $request->get('top');
        $cover->h1_font = $request->get('h1_font');
        $cover->h2_font = $request->get('h2_font');
        $cover->h1_size = $request->get('h1_size');
        $cover->h2_size = $request->get('h2_size');
        $cover->h1_color = $request->get('h1_color');
        $cover->h2_color = $request->get('h2_color');
        $cover->width = $request->get('width');
        $cover->h1_text = $request->get('h1_text');
        $cover->h2_text = $request->get('h2_text');
        $cover->url = $request->get('url');
        $cover->type = $request->get('type');

        $cover->save();

        return redirect()->route('admin.banners');
    }

}
