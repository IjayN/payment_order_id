<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $hidden = ['qty' , 'sku'];
	protected $fillable = ['title' , 'sku' , 'available' , 'price' , 'qty' , 'category_id' , 'description', 'weight'];

	public function category ()
	{
		return $this->belongsTo(Category::class);
	}

	public function banner ()
	{
		return $this->hasMany(Banner::class);
	}
	public function orderItem(){
		return $this->hasMany(OrderItem::class);
	}


}
