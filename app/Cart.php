<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

  protected $table = "carts";

  public function products() 
  {
 	  return $this->belongsToMany('App\Product')->orderBy('created_at')->withTimestamps()->withPivot(['qty','price_level_id','sizes']);
  }



}