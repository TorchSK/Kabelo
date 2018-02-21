<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

  protected $table  = "ratings";
  protected $fillable = ['ratingable_id','ratingable_type','value','text','user_id'];

  	public function ratingable() 
  	{
		return $this->morphTo();
	}

 	public function user() {
 		return $this->belongsTo('App\User');
 	}

}