<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  	protected $table = "categories";
  	protected $fillable = [];
	public $timestamps = false;
 
 	public function products() 
  	{
 		return $this->belongsToMany('App\Product');
 	}

 	public function parameters() 
  	{
 		return $this->hasMany('App\CategoryParameter');
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