<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

  	protected $table = "settings";
	public $incrementing = false;
	public $timestamps = false;
	protected $fillable = ['key'];
	protected $primaryKey = 'key';

}