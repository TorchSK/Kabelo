<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

use File;
use App\Sticker;
use Image;

class StickerController extends Controller
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
            $sticker = new Sticker();
            $sticker->path = $request->get('path');;
            $sticker->save();

            return $sticker;
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
        $sticker = Sticker::find($id);
        $sticker->delete();
    }

}
