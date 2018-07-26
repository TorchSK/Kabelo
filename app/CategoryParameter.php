<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryParameter extends Model {

 	public function parameters() 
  	{
 		return $this->belongsTo('App\Parameter');
 	}

  	public function category() 
  	{
 		return $this->belongsToMany('App\Category');
 	}

}