<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
	protected $fillable = ['code' , 'driver_id' , 'order_id'];

	public function user ()
	{
		return $this->belongsTo(User::class , 'driver_id');
	}

	public function order ()
	{
		return $this->belongsTo(Order::class);
	}

}
