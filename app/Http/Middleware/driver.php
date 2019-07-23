<?php

namespace App\Http\Middleware;

use Closure;

class driver
{
    public function handle($request, Closure $next)
    {
	    if ( !$request->user()->driver ) {
		    return response()->json(['error' => TRUE , 'error_type' => 'permission' , 'message' => "You don't have permissions to make this transaction"] , 401);
	    }
        return $next($request);
    }
}
