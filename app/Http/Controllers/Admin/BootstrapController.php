<?php

namespace App\Http\Controllers\Admin;

use App\Log;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Avatar;

class BootstrapController extends Controller
{
    public function initApp(){
    	$user   =   User::where('name', 'Super Admin')->where('admin', TRUE)->first();
    	if ($user == NULL){
    		$user   =   User::create([
    			'name'  =>  'Super Admin',
			    'phone' =>  '07223334444',
			    'admin' => TRUE,
			    'marketer'  =>  TRUE,
			    'driver'    =>  TRUE,
			    'user'  =>  TRUE,
			    'validated' =>  TRUE,
			    'password' => Hash::make('superSS3#')
		    ]);
    		$this->generateAvatar($user);
		    return "Admin phone ". $user->phone. " Password => superSS3#";
	    }
	    return "Admin phone ". $user->phone. " Password => superSS3#";
    }
	public function generateAvatar ($user)
	{
		$path = '/users/avatar/' . uniqid() . '.png';
		$avatar = new Avatar();
		$avatar->create($user->name)->save(public_path() . $path);

		$user->update(['avatar' => $path ,]);
		return TRUE;
	}

	public function logs(){
    	$logs   =   Log::orderBy('created_at','desc')->get();
    	return view('admin.log', compact('logs'));
	}
}
