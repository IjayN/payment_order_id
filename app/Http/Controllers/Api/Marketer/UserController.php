<?php

namespace App\Http\Controllers\Api\Marketer;

use App\Authorize;
use App\Business;
use App\Http\Controllers\OTP;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Avatar;

class UserController extends Controller
{
	/**
	 * @var OTP
	 */
	public $OTP;

	public function __construct (OTP $OTP)
    {
	    $this->OTP = $OTP;
    }

    public function users(Request $request){
		$users  =   User::where('created_by', $request->user()->id)->orderBy('created_at', 'desc')->get();
		return response()->json([
			"meta"  =>  [
				"message"   =>  'All Users'
			],
			"data"  =>  [
				"users" =>  $users
			],
			"error" =>  FALSE
		]);
    }
    public function createUser(Request $request){
    	$validate   = Validator::make($request->only('name', 'phone'), [
    		'name'  =>  'required',
		    'phone' =>  'required|unique:users'
	    ]);
	    if ( $validate->fails() ) {
		    return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
	    }
    	$password   =   generateOTP(6);
    	$otp        =   generateOTP(4);

    	$user = User::create([
    		'name'  =>  $request->get('name'),
		    'phone' =>  $request->get('phone'),
		    'otp'   =>  $otp,
		    'user'  =>  TRUE,
		    'created_by'    =>  $request->user()->id,
		    'password'  =>  Hash::make($password)
	    ]);
    	/*
    	 * Generate avatar
    	 */
    	$this->generateAvatar($user);

	    $message2   =   "Your Sembe account has been created successfully by Marketer ".$request->user()->name;
    	$message    =   "Your Sembe Verification code is ". $otp." and your App Password is ". $password;

    	$this
		    ->OTP->sendSms($user->phone, $message2);
    	$this
		    ->OTP->sendSms($user->phone, $message);

    	return response()->make([
    		'meta'  =>  [
    			"message"   =>  "User Created Successfully"
		    ],
		    "data"  =>  [
		    	"user"  =>  $user
		    ],
		    "error" =>  FALSE
	    ]);
    }

    public function searchUser(Request $request){
		$validate   =   Validator::make($request->only('phone'), [
			'phone' =>  'required'
		]);
	    if ( $validate->fails() ) {
		    return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
	    }
		$user   =   User::where('phone', $request->get('phone'))->first();
	    if ($user == NULL){
	    	return response()->json([
	    		"meta" => [
	    			"message"   =>  "User not found"
			    ],
			    "error" =>  TRUE
		    ], 404);
	    }
	    $gate   =   Authorize::where('marketer_id', $request->user()->id)->where('user_id', $user->id)->first();
	    $code   =   generateOTP(4);
	    if ($gate == NULL){
	    	Authorize::create([
	    		'code'  =>  $code,
			    'authorized'    =>  FALSE,
			    'marketer_id'   =>  $request->user()->id,
			    'user_id'   =>  $user->id
		    ]);
	    }else{
	    	$gate->update([
	    		'code'  =>  $code,
			    'authorized'    =>  FALSE,
			    'created_at'    =>  Carbon::now(),
			    'updated_at'    =>  Carbon::now()
		    ]);
	    }
	    /*
	     * Send Otp to app
	     */
	    $message    =   "Hello, Send this code ". $code. " to Sembe Marketer ".$request->user()->phone.", ".$request->user()->name . " to order goods on your behalf";
	    $this
		    ->OTP->sendSms($user->phone, $message);
	    return response()->json([
	    	'meta'  =>  [
	    		"message"   =>  "Verification code sent to the client successfully"
		    ],
		    "error" =>  FALSE
	    ]);
    }

    public function verifyCode(Request $request){
		$validate   =   Validator::make($request->only('code'), [
			'code'  =>  'required'
		]);
	    if ( $validate->fails() ) {
		    return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
	    }

	    $gate   =   Authorize::where('code', $request->get('code'))->where('marketer_id', $request->user()->id)->first();
	    if ($gate == NULL){
	    	return response()->json([
	    		'meta'  =>  [
	    			"message"   =>  "Authorization Code is invalid"
			    ]
		    ]);
	    }
	    $user   =   User::find($gate->user_id);
	    if ($user == NULL){
		    return response()->json([
			    "meta"  =>  [
				    "message"   =>  "This user does not exist"
			    ],
			    "error" =>  TRUE
		    ]);
	    }
	    $gate->update([
	    	'authorized'    =>  TRUE
	    ]);
	    return response()->json([
	    	"meta"  =>  [
	    		"message"   =>  "You have been authorized successfully"
		    ],
		    "data" => [
		    	"user"  =>  $user
		    ],
		    "error" =>  FALSE
	    ]);
    }

    public function  businesses(Request $request){
	    $validate   =   Validator::make($request->only('user_id'), [
		    'user_id'  =>  'required'
	    ]);
	    if ( $validate->fails() ) {
		    return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
	    }
	    $businesses =   Business::where('user_id', $request->get('user_id'))->get();
	    return response()->json([
	    	"meta"  =>  [
	    		"message"   =>  "User Businesses"
		    ],
		    "data"  =>  [
		    	"businesses"    =>  $businesses
		    ]
	    ]);
    }

    public function createBusiness(Request $request){
	    $validate = Validator::make($request->only('name' , 'phone' , 'location', 'location_name','user_id') , [
		    	'name' => 'required' ,
			    'phone'   =>  'required',
			    'location' => 'required',
			    'location_name' => 'required',
			    'user_id'   => 'required'
		    ]);
	    /*
		 * Validate API REQUEST
		 */
	    if ( $validate->fails() ) {
		    return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
	    }
	    $user   =   User::find($request->get('user_id'));
	    if ($user == NULL){
	    	return response()->json([
	    		"meta"  =>  [
	    			"message"   =>  "This user does not exist"
			    ],
			    "error" =>  TRUE
		    ]);
	    }
	    $business   =   Business::create([
	    	'user_id'   =>  $request->get('user_id'),
		    'name' => $request->get('name') ,
		    'location' => $request->get('location') ,
		    'location_name' =>  $request->get('location_name'),
		    'contact' => $request->get('phone')
	    ]);

	    return response()->json([
	    	'meta' => [
	    		"message" => "Business Created successfully"] ,
		    "data" => [
		    	'business' => $business
		    ] ,
		    'error' => FALSE
	    ] ,
		    201);
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
