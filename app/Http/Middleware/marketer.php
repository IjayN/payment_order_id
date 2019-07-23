<?php

namespace App\Http\Middleware;

use Closure;

class marketer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//	    if ( !$request->user()->marketer || !$request->user()->student ) {
//		    return response()->json(['error' => TRUE , 'error_type' => 'permission' , 'message' => "You don't have permissions to make this transaction"] , 401);
//	    }
        return $next($request);
    }
}
