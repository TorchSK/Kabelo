<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File as ProductFile;
use App\Product;

use File;
use App\File as FileDB;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function update($id, Request $request)
    {
        $file = ProductFile::find($id);
        $product = $file->product;

        foreach ($request->except('_token') as $key => $value)
        {
            $file->$key = $value;

            if ($key == 'primary')
            {
                $otherFiles = $product->images->whereNotIn('id', [$file->id]);

                foreach ($otherFiles as $otherFile)
                {
                    $otherFile->primary = 0;
                    $otherFile->save();
                }  
            }
        }

        $file->save();

        return $file;
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $destinationPath = 'uploads/files';
        $extension = $file->getClientOriginalExtension(); 
        $filename = $file->getClientOriginalName().'.'.$extension;
        $fullpath = $destinationPath.'/'.$filename;

        $success = $file->move($destinationPath, $filename);

        if ($success)
        {
            $fileDB = new FileDB();
            $fileDB->type = "system";
            $fileDB->path = $fullpath;

            $fileDB->save();
        }
        return 1;
    }

    public function destroy($id)
    {
        $file = ProductFile::find($id);
        File::delete($file->path);
        $file->delete();
    }

}
