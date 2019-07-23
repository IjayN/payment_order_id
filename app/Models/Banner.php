<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $hidden = ['name'];

	protected $fillable = ['src' , 'name'];

	public function product ()
	{
		return $this->belongsTo(Product::class);
	}

	public function getSrcAttribute ($value)
	{
		return  productUploads(). $value;
	}

}
