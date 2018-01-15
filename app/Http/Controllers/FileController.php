<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File as ProductFile;
use App\Product;

use File;

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

    public function destroy($id)
    {
        $file = ProductFile::find($id);
        File::delete($file->path);
        $file->delete();
    }

}
