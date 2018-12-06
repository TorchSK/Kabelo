<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function store(Request $request)
    {
        $file = $request->file('file');

        $destinationPath = 'uploads/banners';

        $extension = $file->getClientOriginalExtension(); 
        $filename = $file->getClientOriginalName().'.'.$extension;
        $fullpath = $destinationPath.'/'.$filename;

        $success = $file->move($destinationPath, $filename);

        if ($success)
        {
            $banner = new Banner();
            $banner->image = $destinationPath.'/'.$filename;
            $banner->type = 'top';
            $banner->save();
        }

        return redirect('/admin/banners');

    }

}
