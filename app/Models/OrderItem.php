<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OrderItem extends Model
{
	protected $fillable = ['quantity' , 'product_id' , 'dispatched', 'order_id' , 'total'];

	public function order ()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}

	public function product(){
		return $this->belongsTo(Product::class);
	}
	public function getCreatedAtAttribute ($value)
	{
		return Carbon::parse($value)->toDateTimeString();
	}
}
