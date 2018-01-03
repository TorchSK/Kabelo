<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

  protected $table = "products";
  protected $fillable = ["category_id", "code", "price", "price_unit", "desc", "link", "stock", "maker"];

  	public function category() 
  	{
 		return $this->belongsTo('App\Category');
 	}

}