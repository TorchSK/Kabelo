<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model {

  protected $table = "product_parameters";
	public $timestamps = false;

  	public function product() 
  	{
 		return $this->belongsTo('App\Product');
 	}

  	public function categoryParameter() 
  	{
 		return $this->belongsTo('App\CategoryParameter');
 	}
}