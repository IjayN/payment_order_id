<?php
	
	namespace App\Http\Controllers\Api\Driver;
	
	use App\Assigned;
	use App\Business;
	use App\Confirmation;
	use App\Http\Controllers\OTP;
	use App\Order;
	use App\OrderItem;
	use App\User;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Validator;
	
	class DriverController extends Controller
	{
		/**
		 * @var OTP
		 */
		public $OTP;
		
		public function __construct (OTP $OTP)
		{
			
			$this->OTP = $OTP;
		}
		
		/*
		 * Get assigned orders
		 */
		public function assigned (Request $request)
		{
			$assignedOrders = collect (Assigned::where ('driver_id', $request->user ()->id)->with ('driver', 'business', 'order')->get ());
			
			
			if ($assignedOrders == NULL) {
				return response ()->json (["meta" => ["message" => "This driver has no assigned orders"], "error" => TRUE], 404);
			}
			return response ()->json (["meta" => ["message" => "Assigned Orders"], "data" => ["orders" => $assignedOrders,//"order_items"   =>  $order_items
			], "error" => FALSE]);
		}
		
		public function order (Request $request)
		{
			$validate = Validator::make ($request->only ('order_id'), ['order_id' => 'required']);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$order = Order::find ($request->get ('order_id'));
			if ($order == NULL) {
				return response ()->json (["meta" => ["message" => "Order not found, Fatal Error"], "error" => TRUE]);
			}
			$order = Order::where ('id', $request->get ('order_id'))->with ('business', 'business.user')->first ();
			if ($order == NULL) {
				return response ()->json (["meta" => ["message" => "Order not found"], "error" => TRUE], 404);
			}
			$order_items = OrderItem::where ('order_id', $request->get ('order_id'))->with ('product')->get ();
			return response ()->json (["meta" => ["message" => "Order Data"], "data" => ["order" => $order, "order_items" => $order_items], "error" => FALSE]);
		}
		
		/*
		 * Send Delivery Code
		 */
		public function sendDeliveryCode (Request $request)
		{
			$validate = Validator::make ($request->only ('order_id'), ['order_id' => 'required']);
			
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			
			$assigned = Assigned::where ('driver_id', $request->user ()->id)->where ('order_id', $request->get ('order_id'))->first ();
			
			if ($assigned == NULL) {
				return response ()->json (["meta" => ["message" => "Assigned order not found"], "error" => TRUE]);
			}
			$business = Business::find ($assigned->business_id);
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "This business does not exist"], "error" => TRUE]);
			}
			$user = User::find ($business->user_id);
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "Something went wrong, verify user details"], "error" => TRUE]);
			}
			/*
			 * Send Sms to shop Owner
			 */
			$otp = generateOTP (6);
			$message = "Your delivery verification code is " . $otp . " Kindly confirm that all your items have been delivered verification";
			$confirmation = Confirmation::where ('order_id', $request->get ('order_id'))->where ('driver_id', $request->get ('driver_id'))->first ();
			if ($confirmation == NULL) {
				Confirmation::create (['driver_id' => $request->user ()->id, 'order_id' => $request->get ('order_id'), 'code' => $otp]);
			} else {
				$confirmation->update (['code' => $otp]);
			}
			$this->OTP->sendSms ($user->phone, $message);
			return response ()->json (['meta' => ["message" => "Confirmation code sent to Business Owner"], "data" => ["assigned" => $assigned], "error" => FALSE], 200);
			
		}
		
		/*
		 * Confirm Code and Deliver
		 */
		public function confirmDeliveryCode (Request $request)
		{
			$validate = Validator::make ($request->only ('order_id', 'code'),
				[
					'order_id' => 'required', 'code' => 'required'
				]);
			
			if ($validate->fails ()) {
				return response ()->json ([
					"meta" => [
						"message" => "Validation Errors"
					], "errors" => $validate->getMessageBag (),
					'error' => TRUE
				]);
			}
			
			$order = Order::find ($request->get ('order_id'));
			if ($order == NULL) {
				return response ()->json ([
					'meta' =>
						[
							"message" => "Something went wrong, Fatal Error"
						],
					"error" => TRUE
				]);
			}
			if ($order->delivered) {
				return response ()->json ([
					"meta" =>
						[
							"message" => "This order has already been delivered"
						],
					"error" => TRUE
				]);
			}
			$cornfirmation = Confirmation::where ('order_id', $request->get ('order_id'))->where ('code', $request->get ('code'))->first ();
			if ($cornfirmation == NULL) {
				return response ()->json ([
					'meta' => [
						"message" => "Code is invalid"
					], "error" => TRUE
				]);
			}
			
			$order->update (['delivered' => TRUE, 'confirmed' => TRUE,]);
			
			return response ()->json ([
					"meta" => [
						"message" => "Transaction Completed Successfully"
					], "data" => [
						"order" => $order
					], "error" => FALSE
				]
			);
		}
		
		/*
		 * Continue without confirmation
		 */
		public function continueWithoutConfirmation (Request $request)
		{
			$validate = Validator::make ($request->only ('order_id'), ['order_id' => 'required',]);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$order = Order::find ($request->get ('order_id'));
			if ($order == NULL) {
				return response ()->json (['meta' => ["message" => "Something went wrong, Fatal Error"], "error" => TRUE]);
			}
			if ($order->delivered) {
				return response ()->json (["meta" => ["message" => "This order has already been delivered"], "error" => TRUE]);
			}
			
			
			$order->update (['delivered' => TRUE, 'confirmed' => FALSE]);
			
			return response ()->json (["meta" => ["message" => "Transaction Completed Successfully"], "data" => ["order" => $order], "error" => FALSE]);
		}
	}
