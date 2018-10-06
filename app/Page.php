<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

  	protected $table = "pages";
  	protected $fillable = ['active','name','url'];

	public function text()
	{
	    return $this->hasOne('App\Text');
	}
 

}