<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorize extends Model
{
    protected $fillable =   ['code','authorized','marketer_id','user_id'];

}
