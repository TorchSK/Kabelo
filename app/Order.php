<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

  	protected $table = "orders";
  	protected $fillable = [];
 
 	public function products() 
  	{
 		return $this->belongsToMany('App\Product');
 	}

 	public function status() 
  	{
 		return $this->hasOne('App\OrderStatus','id','status_id');
 	}

}