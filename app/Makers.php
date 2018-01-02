<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model {

  protected $table = "activations";
  protected $fillable = ["user_id", "token"];

  	public function user() 
  	{
 		return $this->belongsTo('App\User');
 	}

}