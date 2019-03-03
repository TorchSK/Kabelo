<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SeoTool;
use Storage;


class SeoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


	public function settings()
	{
		return view('admin.seo.settings');

	}

	public function tools(){
		return view('admin.seo.tools');
	}  

    public function seoToolProfile($url){
        $data = [
            'tool' => SeoTool::where('url', $url)->first()
        ];

        return view('admin.seo.profile', $data);
    }

    public function seoToolUpdate($id)
    {
        $seoTool = SeoTool::find($id);
        
    }


    public function toolApiUpdate($id, Request $request)
    {
        $seoTool = SeoTool::find($id);

        foreach ($request->except('_token') as $key => $value){
            $seoTool->$key = $value;
        }

        $seoTool->save();
        return 1;
    }

    public function getXML($id){
        $tool = SeoTool::find($id);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<SHOP>'."\n";

        foreach(Product::whereActive(1) ->get() as $product)
        {
            $xml = $xml."\t".'<SHOPITEM>'."\n";
            foreach(json_decode($tool->columns, true) as $key => $value)
            {
                $xml = $xml."\t"."\t".'<'.$key.'>'.$value.'</'.$key.'>'."\n";
            }

            $xml = $xml."\t".'</SHOPITEM>'."\n";
        }

        $xml = $xml.'</SHOP>';

    }

    public function exportFiles(){
        foreach(SeoTool::all() as $tool)
        {
            $content = $this->getXML($id);
            Storage::disk('public_physical')->put($tool->file_name.$tool->file_ext, $content);
            return 1;
        }
        
    }


}
