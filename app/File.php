<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

  protected $table = "files";
  protected $appends = array('thumb');

  	public function product() 
  	{
 		return $this->belongsTo('App\Product');
 	}

    public function getThumbAttribute()
    {
		  $array = explode('/', $this->path);


      try{
    	$path = 'https://dedra.blob.core.windows.net/imagehandler/dedra.blob.core.windows.net/cms/ContentItems/'.$array[5].'/images/m_max__w_480__h_480__a_middlecenter__o__x_bottomright__r_30/'.explode('.',$array[7])[0].'.jpeg';
      }
      catch (ErrorException $e) {
        return $this->path;
      }
      
      return $path;

    }
}