<?php

namespace App\Http\Controllers\Api\Marketer;

use App\Authorize;
use App\Business;
use App\Cart;
use App\Item;
use App\OrderItem;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
   public function timeOut($marketer, $userId){
   	$now    =   Carbon::now();
   	$gate   =   Authorize::where('marketer_id', $marketer->id)->where('user_id', $userId)->first();
   	if ($gate == Null){
	    return TRUE;
    }
    if ($gate->authorized == FALSE){
	    return TRUE;
    }
   	$diff   =   Carbon::parse($gate->created_at)->diffInMinutes($now);
   	if ($diff > 60){
   		return TRUE;
    }
    return FALSE;
   }

	public function add (Request $request)
	{
		$validate = Validator::make($request->only('product_id' , 'quantity', 'business_id') ,
			[
				'product_id' => 'required' ,
				'business_id'   =>  'required',
				'quantity' => 'required'
			]);
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		if ($request->get('quantity') <= 0) {
			return response()->json(["meta" => ["message" => "Invalid product Quantity"] , "message" => "Quantity input should be greater than zero" , "error" => TRUE] , 400);
		}
		$product = Product::find($request->get('product_id'));
		if ( $product == NULL ) {
			return response()->json(["meta" => ["message" => "Product Not found"] , "err" => TRUE] , 404);
		}

		$business   =   Business::find($request->get('business_id'));
		if ( $business == NULL ) {
			return response()->json(["meta" => ["message" => "Business Not found"] , "err" => TRUE] , 404);
		}
		if ($this->timeOut($request->user(), $business->user_id)){
			return response()->json([
				'meta'  =>  [
					"message"   =>  "Your session has expired"
				],
				"error" =>  TRUE
			]);
		}
		$cart = Cart::where('business_id' , $business->id)->first();
		if ( $cart == NULL ) {
			$cart = $business->cart()->create([
				'total' =>  0
			]);
		}

		$cart->item()->create([
			'quantity' => $request->get('quantity') ,
			'product_id' => $request->get('product_id') ,
			'total' => $product->price * $request->get('quantity')
		]);

		$total_items_prices =   $cart->item->sum('total');

		$cart->update([
			'total' =>  $total_items_prices
		]);

		return response()->json([
			'meta' => [
				"message" => "Item added to cart successfully"
			] ,
			"data" => [
				"cart" => $cart ,
			]
		]);
	}
	public function editItem(Request $request)
	{
		$validate   =   Validator::make($request->only('item_id','quantity', 'business_id'), [
			'item_id'   =>  'required',
			'quantity'  =>  'required',
			'business_id'   =>  'required'
		]);
		if ($request->get('quantity') <= 0){
			return response()->json([
				"meta"  =>  [
					"message"   =>  "Invalid product Quantity"
				],
				"message"   =>  "Quantity input should be greater than zero",
				"error"     =>  TRUE
			], 400);
		}
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		$business   =   Business::find($request->get('business_id'));
		if ( $business == NULL ) {
			return response()->json(["meta" => ["message" => "Business Not found"] , "err" => TRUE] , 404);
		}
		if ($this->timeOut($request->user(), $business->user_id)){
			return response()->json([
				'meta'  =>  [
					"message"   =>  "Your session has expired"
				],
				"error" =>  TRUE
			]);
		}
		$item   =   Item::where('id', $request->get('item_id'))->first();
		if ($item == NULL){
			return response()->json(["meta" => ["message" => "Item Not found"] , "err" => TRUE] , 404);
		}
		$product    =   $item->product;
		if ($product == NULL){
			return response()->json(["meta" => ["message" => "Item Not found"] , "err" => TRUE] , 404);
		}
		/*
		 * Delete all items having this product
		 */
		$item->update([
			'quantity'  =>  $request->get('quantity'),
			'total'     =>  $product->price * $request->get('quantity'),
		]);
		$cart   =  Cart::find($item->cart_id);
		$cart->update([
			'total' =>  $cart->item->sum('total')
		]);
		return response()->json([
			'meta' => [
				"message" => "Your cart has been updated successfully"
			] ,
			"data" => [
				"cart" => $cart ,
			]
		]);
	}
	public function removeItem(Request $request){
		$validate   =   Validator::make($request->only('item_id', 'business_id'), [
			'item_id'   =>  'required',
			'business_id'   =>  'required'
		]);

		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		$business   =   Business::find($request->get('business_id'));
		if ( $business == NULL ) {
			return response()->json(["meta" => ["message" => "Business Not found"] , "err" => TRUE] , 404);
		}
		if ($this->timeOut($request->user(), $business->user_id)){
			return response()->json([
				'meta'  =>  [
					"message"   =>  "Your session has expired"
				],
				"error" =>  TRUE
			]);
		}
		$item   =   Item::where('id',$request->get('item_id'))->first();
		if ($item == NULL){
			return response()->json(["meta" => ["message" => "Item Not found"] , "err" => TRUE] , 404);
		}
		$item->delete();

		$cart   =  Cart::find($item->cart_id);
		$cart->update([
			'total' =>  $cart->item->sum('total')
		]);
		return response()->json([
			'meta' => [
				"message" => "Your cart has been updated successfully"
			] ,
			"data" => [
				"cart" => $cart ,
			],
			"error" =>  FALSE
		]);
	}

	public function destroy(Request $request){
		$validate   =   Validator::make($request->only('business_id'), [
			'business_id'   =>  'required'
		]);
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		$business   =   Business::find($request->get('business_id'));
		if ( $business == NULL ) {
			return response()->json(["meta" => ["message" => "Business Not found"] , "err" => TRUE] , 404);
		}

		if ($this->timeOut($request->user(), $business->user_id)){
			return response()->json([
				'meta'  =>  [
					"message"   =>  "Your session has expired"
				],
				"error" =>  TRUE
			]);
		}
		$cart   = Cart::where('business_id', $business->id)->first();
		if ( $cart == NULL ) {
			$cart = $business->cart()->create([
				'total' =>  0
			]);
		}
		$items  =   Item::where('cart_id', $cart->id)->get();

		foreach ($items as $item){
			Item::find($item->id)->delete();
		}
		$cart->update([
			'total' =>  0
		]);

		return response()->json([
			'meta'  =>  [
				'message'   =>  "Cart Destroyed successfully"
			],
			"data" => [
				"cart"  =>  $cart
			],
			"error" =>  FALSE
		]);

	}

	public function makeOrder(Request $request){
		$validate   =   Validator::make($request->only('business_id'), [
			'business_id'   =>  'required'
		]);
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}
		$business   =   Business::find($request->get('business_id'));
		if ( $business == NULL ) {
			return response()->json(["meta" => ["message" => "Product Not found"] , "err" => TRUE] , 404);
		}
		if ($this->timeOut($request->user(), $business->user_id)){
			return response()->json([
				'meta'  =>  [
					"message"   =>  "Your session has expired"
				],
				"error" =>  TRUE
			]);
		}
		$cart   = Cart::where('business_id', $business->id)->first();
		if ( $cart == NULL ) {
			return response()->json(["meta" => ["message" => "Cart Not found"] , "err" => TRUE] , 404);
		}
		$items  =   Item::where('cart_id', $cart->id)->get();
		if ($items->count() <= 0 ){
			return response()->json(["meta" => ["message" => "You don't have any items in your cart"] , "error" => TRUE] , 404);
		}
		$order  =   $business->order()->create([
			'amount'    =>  $cart->total,
			'created_by' => $request->user()->id,
			'paid'      =>  FALSE,
			'shipped'   =>  FALSE,
			'canceled'  =>  FALSE
		]);
		foreach ($items as $item){
			$orderItem  = OrderItem::create([
				'order_id'  =>  $order->id,
				'quantity'  =>  $item->quantity,
				'product_id'    =>  $item->product_id,
				'total' =>  $item->total,
				'shipped'   =>  FALSE,
				'canceled'  =>  FALSE,
				'paid'      =>  FALSE
			]);
		}
		/*
		 * Destroy Cart
		 */
		$this->destroy($request);

		return response()->json([
			"meta"  =>  [
				"message"   =>  "Your order for the following products has been recieved successfully",
			],
			"data"  =>  [
				"order" =>  $order,
				"items" =>  OrderItem::where('order_id', $order->id)->get()
			],
			"error" =>  FALSE
		]);
	}
}
