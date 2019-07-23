<?php

namespace App\Http\Controllers\Api;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
	public function index (Request $request)
	{
    	$payments   =   Payment::where('user_id', $request->user()->id)->with('business','order')->orderBy('created_at', 'desc')->get();
    	return response()->json([
    		'meta'  =>  [
    			"message"   =>  "All user payments"
		    ],
		    "data"  =>  [
		    	"payments"  =>  $payments
		    ],
		    "error" =>  FALSE
	    ]);
	}
}
