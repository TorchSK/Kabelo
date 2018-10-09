<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File as ProductFile;
use App\Product;

use File;
use App\File as FileDB;
use Image;

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
        if(!$request->has('do_not_upload'))
        {
            $file = $request->file('file');
            $destinationPath = 'uploads/files';
            $extension = $file->getClientOriginalExtension(); 
            $filename = $file->getClientOriginalName();
            $fullpath = $destinationPath.'/'.$filename;

            $success = $file->move($destinationPath, $filename);


            if ($success)
            {

                if(FileDB::wherePath($fullpath)->count() == 0)
                {
                    $fileDB = new FileDB();
                    $fileDB->type = "system";
                    $fileDB->path = $fullpath;

                    $fileDB->save();

                }

            }

            return $filename;

        }
        else
        {
            $fileDB = new FileDB();
            $fileDB->type = $request->get('type');
            $fileDB->path = $request->get('path');;

            $fileDB->save();

            return $fileDB;
        }

    }

    public function changeCatalogueImage(Request $request)
    {
        $catalogue = FileDB::find($request->get('catalogue_id'));
        
        $file = $request->file('file');
        $destinationPath = 'uploads/files';
        $extension = $file->getClientOriginalExtension(); 
        $filename = $file->getClientOriginalName();
        $fullpath = $destinationPath.'/'.$filename;

        $success = $file->move($destinationPath, $filename);

        if ($success)
        {
            $image = Image::make($destinationPath.'/'.$filename);

            $image->resize(100, null , function ($constraint) {
                    $constraint->aspectRatio();
            });
            
            $image->save($destinationPath.'/'.$filename);

            $thumb = new FileDB();
            $thumb->type = "thumb";
            $thumb->path = $fullpath;

            $thumb->save();
            $catalogue->thumb_id = $thumb->id;
            $catalogue->save();

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
