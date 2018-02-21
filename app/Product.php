<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

  protected $table = "products";
  protected $fillable = ["category_id", "name", "code", "price", "price_unit", "desc", "link", "stock", "maker", "new", "sale", "sale_price"];

  	public function categories() 
  	{
 		return $this->belongsToMany('App\Category');
 	}

  	public function parameters() 
  	{
 		return $this->hasMany('App\Parameter');
 	}

 	public function image() 
  	{
 		return $this->hasOne('App\File')->where('type','image')->where('primary',1);
 	}

 	public function otherImages() 
  	{
 		return $this->hasMany('App\File')->where('type','image')->where('primary',0);;
 	}

  public function images() 
    {
    return $this->hasMany('App\File')->where('type','image');
  }

 	public function orders() 
  	{
 		return $this->belongsToMany('App\Order');
 	}

  public function ratings()
  {
    return $this->morphMany('App\Rating','ratingable');
  }


	public function setSaleAttribute($value)
  	{
      if ($value == 'on')
      {
        $this->attributes['sale'] = 1;
      }
      else
      {
        $this->attributes['sale'] = 0;
      }
  	}
	
	public function setNewAttribute($value)
  	{
      if ($value == 'on')
      {
        $this->attributes['new'] = 1;
      }
      else
      {
        $this->attributes['new'] = 0;
      }
  	}

}