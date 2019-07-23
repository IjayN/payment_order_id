<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function createLog($type, $info){
    	Log::create([
    		'type'  =>  $type,
		    'info'  =>  $info
	    ]);
    	
    	return $this;
    }
}
