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

        if(!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath);
        }

        Image::make($path)
                 ->crop($w, $h, $x, $y)
                 ->widen($width)
                 ->save($destinationPath.'/'.$mdfilename.'.'.$ext);


        $cover = new Banner();
        $cover->image = $destinationPath.'/'.$mdfilename.'.'.$ext;
        $cover->url = $request->get('url');
        $cover->type = $request->get('type');

        $cover->save();

        return redirect()->route('admin.banners');
    }

    public function edit($id)
    {

        $data = [
            'cover'=>Banner::find($id)
        ];

        return view('admin.banners.create', $data);
    }

    public function update($id, Request $request)
    {
        $cover = Banner::find($id);
        $cover->url = $request->get('url');
        $cover->type = $request->get('type');

        if ($request->filled('filename'))
        {
            $filename = $request->get('filename');

            $x = round($request->get('x'));
            $y = round($request->get('y'));
            $w = round($request->get('w'));
            $h = round($request->get('h'));

            $path = 'temp/covers/'.$filename;
            $destinationPath = 'uploads/covers';


            $width = 1920;   

            Image::make($path)
                     ->crop($w, $h, $x, $y)
                     ->widen($width)
                     ->save($destinationPath.'/'.$filename);

        $cover->image = $destinationPath.'/'.$filename;

        }

        $cover->save();

        return redirect()->route('admin.banners');
    }


    public function destroy($id)
    {
        $cover = Banner::find($id);
        $cover->delete();
        return 1;
    }


}
