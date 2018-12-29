<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

  protected $table = "settings";
  protected $fillable = ['name','value','display_name'];

	public function setvALUEAttribute($value)
  	{
      if ($value == 'on' || $value == 1)
      {
        $this->attributes['value'] = 1;
      }
      elseif ($value == 'off' || $value == 0)
      {
        $this->attributes['value'] = 0;
      }
      else
      {
      	$this->attributes['value'] = $value;
      }
  	}

}