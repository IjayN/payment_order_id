<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Safaricom\Mpesa\Mpesa;


use Illuminate\Support\Facades\Config;


class PaymentController extends Controller
{
	/**
	 * @var LogController
	 */
	public $logController;
	public $cartController;

	public function __construct (LogController $logController, CartController $cartController)
	{
		$this->logController = $logController;
		$this->cartController = $cartController;

	}



	public function pay (Request $request)
	{

		$this->validate($request , [
			'amount' => 'required',
			'phone_no' => 'required'
		]);

		$amount=$request->amount;
		$phone_no=$request->phone_no;


		// $order 	=	\Session::get('order');
		// $mpesa  = \Session::get('mpesa');
		// $items  = \Session::get('items');
		// $request = \Session::get('request');
		// $cart    = \Session::get('cart');

		// $order->payment ()->create ([
		// 	'amount' => $cart->total,
		// 	'user_id' => $request->user ()->id,
		// 	'business_id' => $business->id
		// ]);
		//
    // printf($order);
		// exit();

		$mpesa = new Mpesa();

		 $BusinessShortCode= env('LIPA_NA_MPESA_CODE');
		 $LipaNaMpesaPasskey = env('LIPA_NA_MPESA_PASSKEY');
		 $TransactionType= 'CustomerPayBillOnline';
		 $Amount= $amount;
		 $PartyA= $phone_no;
		 $PartyB= env('LIPA_NA_MPESA_CODE');
		 $PhoneNumber= $phone_no;
		 $CallBackURL= 'http://a3493a87.ngrok.io/api/callback';
		 $AccountReference='Order No: 1';
  	 $TransactionDesc='Mpesa';
	  	$Remarks='Paid';

		// printf($BusinessShortCode);
		// exit();


		$transaction= $mpesa->STKPushSimulation($BusinessShortCode,$LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference,$TransactionDesc,$Remarks);

     return $transaction;


	}


public function mpesacallbackurl()
{
 // store calback data to db



}


	public function mpesaCallback(){
		$order 	=	\Session::get('order');
		$mpesa  = \Session::get('mpesa');
		$items  = \Session::get('items');
		$request = \Session::get('request');
		$cart    = \Session::get('cart');

		/*
		On Errors
		*/


		/*
		On success
		*/
		$order->payment ()->create ([
			'amount' => $cart->total,
			'user_id' => $request->user ()->id,
			'business_id' => $business->id
		]);

		/*
		 * On successful payment
		 */
		foreach ($items as $item) {
			$orderItem = OrderItem::create ([
				'order_id' => $order->id,
				'quantity' => $item->quantity,
				'product_id' => $item->product_id,
				'total' => $item->total,
				'shipped' => FALSE,
				'canceled' => FALSE,
				'paid' => FALSE
			]);
		}


		/*
		 * Destroy Cart
		 */
		$this->cartController->destroy2 ($request);
		/*
		 * Log Controller
		 */
		$this
			->logController
			->createLog ('New Order', 'New Order placed by ' . $request->user ()->name . ' Phone: ' . $request->user ()->phone);

	}


	public function destroySession(){

	}
}
