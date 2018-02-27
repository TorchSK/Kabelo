<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model {

	protected $table = "delivery_methods";
	public $timestamps = false;

  	public function paymentMethods() 
  	{
 		return $this->belongsToMany('App\PaymentMethod');
 	}

}