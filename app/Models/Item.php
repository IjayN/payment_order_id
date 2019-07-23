<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable =   ['cart_id','quantity','product_id','total'];

    public function product(){
    	return $this->belongsTo(Product::class);
    }

    public function cart(){
    	return $this->belongsTo(Cart::class);
    }
}
