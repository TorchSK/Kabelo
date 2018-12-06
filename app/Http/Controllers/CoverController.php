<?php

namespace App\Http\Controllers;

use App\Cover;
use Illuminate\Http\Request;

class CoverController extends Controller
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
            $cover = new Cover();
            $cover->image = $destinationPath.'/'.$filename;
            $cover->save();
        }

        return 1;

    }

}
