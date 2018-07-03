<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceLevel extends Model {

  protected $table = "price_levels";

  	public function product() 
  	{
 		return $this->belongsTo('App\Product');
 	}

    public function setMocRegularAttribute($value)
    {
        $this->attributes['moc_regular'] =  floatval(str_replace(',', '.', $value));
    }

    public function setMocSaleAttribute($value)
    {
        $this->attributes['moc_sale'] =  floatval(str_replace(',', '.', $value));
    }

    public function setVocRegularAttribute($value)
    {
        $this->attributes['voc_regular'] =  floatval(str_replace(',', '.', $value));
    }

    public function setVocSaleAttribute($value)
    {
        $this->attributes['voc_sale'] =  floatval(str_replace(',', '.', $value));
    }
}