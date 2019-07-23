<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\OTP;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct (OTP $OTP)
    {
    }

	public function cancelOrder(Request $request){
		$validate   =   Validator::make($request->only('order_id'), [
			'order_id'  =>  'required'
		]);
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		$order  =   Order::find($request->get('order_id'));
		if ($order == NULL){
			return response()->json([
				"meta"  => [
					"message"   =>  "Order not found"
				],
				"error" =>  TRUE
			], 404);
		}
		if ($order->canceled){
			return response()->json([
				"meta"  => [
					"message"   =>  "Order has already been canceled"
				],
				"error" =>  TRUE
			], 421);
		}
		$order->update([
			'canceled' => TRUE
		]);

		return response()->json([
			'meta'  =>  [
				"message"   =>  "Order canceled successfully"
			],
			"error" =>  TRUE
		]);
	}

	public function order(Request $request){
		$validate   =   Validator::make($request->only('order_id'), [
			'order_id'  =>  'required',
		]);
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		$order  =   Order::find($request->get('order_id'));
		if ($order == NULL){
			return response()->json([
				"meta"  => [
					"message"   =>  "Order not found"
				],
				"error" =>  TRUE
			], 404);
		}
		$cart_items     =   OrderItem::where('order_id', $order->id)->get();

		return response()->json([
			"meta"  =>  [
				"message"   =>  "Customer Order"
			],
			"data"  =>  [
				"order"    =>  $order,
				"order_items"  =>  $cart_items
			],
			"error" =>  FALSE
		]);
	}

	public function orders(Request $request){
		$validate   =   Validator::make($request->only('business_id'), [
			'business_id'  =>  'required'
		]);
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
    	$orders     =   Order::where('business_id', $request->get('business_id'))->orderBy('id', 'desc')->get();
		return response()->json([
			"meta"  =>  [
				"message"   =>  "Customer Orders"
			],
			"data"  =>  [
				"orders"    =>  $orders,
				"orders_count"  =>  $orders->count()
			],
			"error" =>  FALSE
		]);

	}
}
