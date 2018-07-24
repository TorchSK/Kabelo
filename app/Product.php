<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

  protected $table = "products";
  protected $fillable = ["category_id", "name", "code", "price", "price_unit", "desc", "link", "stock", "maker", "new", "sale", "sale_price","active"];

  	public function categories() 
  	{
 		 return $this->belongsToMany('App\Category');
 	  }

    public function getParentCategoriesAttribute() {
        $result = collect();
        $parents = function($categories) use(&$result, &$parents) {
            $result = $result->merge($categories->pluck('parent'));
        };
        $parents($this->categories);
        return $result;
    }

      public function getParentBaseCategoriesAttribute() {
        $result = collect();
        $parents = function($parentCategories) use(&$result, &$parents) {
            $result = $result->merge($parentCategories->pluck('parent'));
        };
        $parents($this->parentCategories);
        return $result;
    }

  	public function parameters() 
  	{
 		return $this->hasMany('App\Parameter');
 	}

    public function relatedProducts() 
    {
    return $this->hasManyThrough('App\Product', 'App\ProductRelation','product_id','id','id','related_product_id');
  }

  public function allfiles() 
    {
    return $this->hasMany('App\File');
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

  public function videos() 
    {
    return $this->hasMany('App\File')->where('type','video');
  }

  public function files() 
    {
    return $this->hasMany('App\File')->where('type','file');
  }

  public function priceLevels() 
    {
    return $this->hasMany('App\PriceLevel');
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
      if ($value == 'on' || $value == 1)
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
      if ($value == 'on' || $value == 1)
      {
        $this->attributes['new'] = 1;
      }
      else
      {
        $this->attributes['new'] = 0;
      }
  	}


  public function setActiveAttribute($value)
    {
      if ($value == 'on' || $value == 1)
      {
        $this->attributes['active'] = 1;
      }
      else
      {
        $this->attributes['active'] = 0;
      }
    }


    public function setPriceAttribute($value)
    {
        $this->attributes['price'] =  floatval(str_replace(',', '.', $value));
    }

}


