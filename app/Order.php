<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

  	protected $table = "orders";
 
 	public function products() 
  	{
 		return $this->belongsToMany('App\Product')->withPivot(['price','qty','sizes']);
 	}

 	public function status() 
  	{
 		return $this->belongsTo('App\OrderStatus');
 	}

 	public function delivery() 
  	{
 		return $this->belongsTo('App\DeliveryMethod','delivery_method_id','id');
 	}

 	 	public function payment() 
  	{
 		return $this->belongsTo('App\PaymentMethod','payment_method_id','id');
 	}

 	public function user() 
  	{
 		return $this->belongsTo('App\User');
 	}

 	function getIdAttribute($value) {
    	return str_pad($value,6,'0',STR_PAD_LEFT);
	}
}