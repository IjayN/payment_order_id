<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OTP
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle ($request , Closure $next)
	{
		if ( !$request->user()->validated ) {
			return response()->json(['error' => TRUE , 'error_type' => 'OTP' , 'message' => 'Please Verify Your account'] , 401);
		}
		return $next($request);
	}
}
