<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceLevel extends Model {

  protected $table = "price_levels";

  	public function product() 
  	{
 		return $this->belongsTo('App\Product');
 	}

}