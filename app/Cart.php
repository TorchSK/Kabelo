<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

  protected $table = "carts";

  public function products() 
  {
 	  return $this->belongsToMany('App\Product')->orderBy('created_at')->withTimestamps();
  }

	public function setInvoiceAddressAttribute($value)
  {
    $this->attributes['invoice_address'] = json_encode($value);
  }

  public function setDeliveryAddressAttribute($value)
  {
    $this->attributes['delivery_address'] = json_encode($value);
  }
}