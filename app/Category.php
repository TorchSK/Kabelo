<?php

namespace App;
use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    
  use NodeTrait;

	protected $table = "categories";
	protected $fillable = ['active'];

  public $timestamps = false;

 	public function products() 
  {
 		return $this->belongsToMany('App\Product');
 	}

 	public function parameters() 
  	{
 		return $this->belongsToMany('App\Parameter');
 	}

	public function children()
	{
	    return $this->hasMany('App\Category', 'parent_id');
	}


 	public function parent() 
  	{
 		return $this->belongsTo('App\Category', 'parent_id');
 	}
}