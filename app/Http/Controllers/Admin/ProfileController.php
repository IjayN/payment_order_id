<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravolt\Avatar\Avatar;

class ProfileController extends Controller
{
    public function index($id){
    	$user   =   User::find($id);
    	if ($user == NULL){
    		flash("User not found")->important()->warning();
    		return redirect()->back();
	    }
    	return view('admin.admin-profile', compact('user'));
    }
    public function update(Request $request, $id){
	    $user   =   User::find($id);
	    if ($user == NULL){
		    flash("User not found")->important()->warning();
		    return redirect()->back();
	    }
    	$user->update([
    		'name'  =>  $request->get('name', $user->name),
		    'phone' =>  $request->get('phone', $user->phone),
	    ]);
	    $this->generateAvatar($user);
    	flash("Profile updated successfully")->important()->success();
    	return redirect()->back();
    }

	public function generateAvatar ($user)
	{
		$path = '/users/avatar/' . uniqid() . '.png';
		$avatar = new Avatar();
		$avatar->create($user->name)->save(public_path() . $path);

		$user->update(['avatar' => $path ,]);
		return TRUE;
	}
}
