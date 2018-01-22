<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryParameter extends Model {

  protected $table = "category_parameters";

  	public function products() 
  	{
 		return $this->hasMany('App\Product');
 	}

 	public function parameters() 
  	{
 		return $this->hasMany('App\Parameter');
 	}


  	public function category() 
  	{
 		return $this->belongsTo('App\Category');
 	}

}