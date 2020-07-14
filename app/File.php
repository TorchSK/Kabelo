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

    public function thumbnail() 
    {
    return $this->belongsTo('App\File','thumb_id');
  }


    public function getThumbAttribute()
    {
		  $array = explode('/', $this->path);


      if(isset($array[5]) && isset($array[7]))
      {

 

    	$path = 'https://cdndedra.azureedge.net/imagehandler/dedra.blob.core.windows.net/cms/ContentItems/'.$array[5].'/m_max__w_300__h_375__a_middlecenter__f_webp__o__x_bottomright__r_50/'.explode('.',$array[7])[0].'.webp';
        return $path;
      }
      else{
        return $this->path;
      }

    }
}
