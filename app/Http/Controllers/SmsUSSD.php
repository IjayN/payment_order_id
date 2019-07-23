<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Config;

class SmsUSSD extends Controller
{

	private $username;
	private $key;
	public $setup;

	public function __construct ()
	{
		$this->username = Config::get('africastalking_name');
		$this->key = Config::get('africastalking_key');
		$this->setup = new AfricasTalking($this->username , $this->key);

	}

	public function sendSms ()
	{
		$set = new AfricasTalking('Munyingi' , '8d326e0044e6c8b961d448f1addcb56641248813c1a31f992167226915b0e477');
		$set->sms()->send([
			'message' => 'From Sembe' ,
			'to' => '0717040975' ,
		]);


	}

}
