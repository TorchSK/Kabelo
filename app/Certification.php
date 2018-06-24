<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model {

  protected $table = "certifications";

  	public function product() 
  	{
 		return $this->belongsToMany('App\Product');
 	}

}