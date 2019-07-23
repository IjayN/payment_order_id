<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =   ['amount','mode', 'user_id', 'business_id','order_id'];

    public function order(){
    	return $this->belongsTo(Order::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function business(){
    	return $this->belongsTo(Business::class);
    }
}
