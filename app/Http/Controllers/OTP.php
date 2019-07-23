<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;

class OTP extends Controller
{
	public function sendSms ($to , $message)
	{
		$set = new AfricasTalking('Munyingi', '8d326e0044e6c8b961d448f1addcb56641248813c1a31f992167226915b0e477');
		$set->sms()->send([
                        'username' => 'Munyingi' ,
			'message' => $message ,
			'to' => $to ,
                        'from' => 'Ellixar',
		]);


	}
}
