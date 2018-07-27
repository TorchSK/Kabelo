<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model {

  	public function product() 
  	{
 		return $this->belongsTo('App\Product');
 	}

 	public function productParameters() 
  	{
 		return $this->hasMany('App\ProductParameter');
 	}
}