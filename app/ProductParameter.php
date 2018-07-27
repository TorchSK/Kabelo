<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductParameter extends Model {

  protected $table = "product_parameters";
	public $timestamps = false;

  	public function product() 
  	{
 		return $this->belongsTo('App\Product');
 	}

}