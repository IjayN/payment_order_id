<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LogController;
use Closure;
use Illuminate\Support\Facades\Auth;

class admin
{
	/**
	 * @var LogController
	 */
	public $logController;

	public function __construct (LogController $logController)
	{
		$this->logController = $logController;
	}

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if (!Auth::user()->admin){

    		$this->logController->createLog('Permission Denied','Login attempt by ' .Auth::user()->name);

		    flash("Permission denied, Login attempt by ". Auth::user()->name. " Logged successfully")->important()->success();

    		Auth::logout();

    		return redirect()->to('login');
	    }
        return $next($request);
    }
}
