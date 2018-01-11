<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

  protected $table = "products";
  protected $fillable = ["category_id", "code", "price", "price_unit", "desc", "link", "stock", "maker"];

  	public function categories() 
  	{
 		return $this->belongsToMany('App\Category');
 	}

  	public function parameters() 
  	{
 		return $this->hasMany('App\Parameter');
 	}

 	public function image() 
  	{
 		return $this->hasOne('App\File')->where('type','image');
 	}

 	public function images() 
  	{
 		return $this->hasMany('App\File')->where('type','image');
 	}

 	public function orders() 
  	{
 		return $this->belongsToMany('App\Order');
 	}

}