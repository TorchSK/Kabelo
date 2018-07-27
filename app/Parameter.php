<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model {

  	public function categories() 
  	{
 		return $this->belongsToMany('App\Category');
 	}

 	public function productParameters() 
  	{
 		return $this->hasMany('App\ProductParameter');
 	}
}