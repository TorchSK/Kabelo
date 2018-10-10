<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sticker extends Model {

  protected $table  = "stickers";

  	public function ratingable() 
  	{
		return $this->morphTo();
	}

 	public function user() {
 		return $this->belongsTo('App\User');
 	}


	public function setProductRowAttribute($value)
  	{
      if ($value == 'true' || $value == 1)
      {
        $this->attributes['product_row'] = 1;
      }
      else
      {
        $this->attributes['product_row'] = 0;
      }
  	}

  	public function setProductDetailAttribute($value)
  	{
      if ($value == 'true' || $value == 1)
      {
        $this->attributes['product_detail'] = 1;
      }
      else
      {
        $this->attributes['product_detail'] = 0;
      }
  	}

}