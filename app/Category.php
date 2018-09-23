<?php

namespace App;
use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Database\Eloquent\Model;
use Request;

class Category extends Model {
    
  use NodeTrait;

	protected $table = "categories";
	protected $fillable = ['active'];

  public $timestamps = false;

 	public function products() 
  {
 		return $this->belongsToMany('App\Product');
 	}

 	public function parameters() 
  	{
 		return $this->belongsToMany('App\Parameter');
 	}

	public function children()
	{
	    return $this->hasMany('App\Category', 'parent_id');
	}


 	public function parent() 
  	{
 		return $this->belongsTo('App\Category', 'parent_id');
 	}

 	
 	public function getImageAttribute($value) 
  	{
  		$appname = env('APP_NAME');

        if($appname == 'Laravel')
        {
            $appname = explode(".", Request::getHost())[0];
        }

 		if($value)
 		{
			return $value;
 		}
		else{
			 return "/img/category_".$appname.".jpg" ;
		}
 	}
}