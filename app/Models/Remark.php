<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
	protected $fillable = ['user_id' , 'order_id' , 'reason'];

	public function order ()
	{
		return $this->belongsTo(Order::class);
	}

	public function user ()
	{
		return $this->belongsTo(User::class);
	}
}
