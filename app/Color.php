<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {

  protected $table = "colors";
	public $timestamps = false;

  	public function product() 
  	{
 		return $this->belongsToMany('App\Product');
 	}

}