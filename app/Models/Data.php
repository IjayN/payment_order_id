<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
	protected $fillable = ['filePath' , 'fileName', 'user_id'];

	public function user ()
	{
		return $this->belongsTo(User::class);
	}
}
