<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assigned extends Model
{
    protected $fillable =   ['driver_id','order_id','business_id'];

    public function driver(){
    	return $this->belongsTo(User::class, 'driver_id');
    }

    public function order(){
    	return $this->belongsTo(Order::class);
    }

    public function business(){
    	return $this->belongsTo(Business::class);
    }
}
