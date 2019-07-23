<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['user_id' , 'amount' , 'paid' , 'assigned' , 'delivered' , 'canceled' , 'paid' , 'created_by' , 'confirmed'];

	public function business ()
	{
		return $this->belongsTo(Business::class);
	}

	public function orderItem ()
	{
		$this->hasMany(OrderItem::class , 'order_id');
	}

	public function asssigned ()
	{
		return $this->hasOne(Assigned::class);
	}

	public function confirmation ()
	{
		return $this->hasMany(Confirmation::class);
	}

	public function remark ()
	{
		return $this->hasOne(Remark::class);
	}

	public function getCreatedAtAttribute ($value)
	{
		return Carbon::parse($value)->toDateTimeString();
	}

	public function payment ()
	{
		return $this->hasOne(Payment::class);
	}
}
