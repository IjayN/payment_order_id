<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $fillable = ['user_id' , 'total','business_id'];

	public function business ()
	{
		return $this->belongsTo(Business::class);
	}
	public function item(){
		return $this->hasMany(Item::class);
	}
}
