<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
	protected $fillable = ['name' , 'location' , 'contact' , 'user_id' , 'location_name'];

	public function user ()
	{
		return $this->belongsTo(User::class);
	}

	public function order ()
	{
		return $this->hasMany(Order::class);
	}

	public function cart ()
	{
		return $this->hasOne(Cart::class);
	}

	public function assigned ()
	{
		return $this->hasMany(Assigned::class);
	}

	public function payment ()
	{
		return $this->hasMany(Payment::class);
	}
}
