<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  	protected $table = "categories";
  	protected $fillable = [];
	public $timestamps = false;
 
 	public function products() 
  	{
 		return $this->belongsToMany('App\Product');
 	}

}