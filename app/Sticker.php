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

}