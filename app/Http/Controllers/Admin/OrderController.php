<?php

namespace App\Http\Controllers\Admin;

use App\Assigned;
use App\Order;
use App\OrderItem;
use App\Product;
use App\Remark;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
	public $dir = "orders.";

	public function orders ()
	{
		$orders = Order::orderBy('id' , 'desc')->get();
		return view($this->dir . 'all' , compact('orders'));
	}

	public function order (Request $request , $id)
	{
		$order = Order::find($id);
		if ( $order == NULL ) {
			flash("Order not found")->important()->warning();
			return redirect()->back();
		}
		$items = OrderItem::where('order_id' , $order->id)->get();
		$drivers = User::where('driver' , TRUE)->orderBy('name' , 'asc')->get();
		return view($this->dir . 'order' , compact('order' , 'items' , 'drivers'));
	}

	public function canceled ()
	{
		$orders = Order::where('canceled' , TRUE)->orderBy('id' , 'desc')->get();
		return view($this->dir . 'canceled' , compact('orders'));
	}

	public function delivered ()
	{
		$orders = Order::where('delivered' , TRUE)->orderBy('id' , 'desc')->get();
		return view($this->dir . 'delivered' , compact('orders'));
	}

	public function pending ()
	{
		$orders = Order::where('delivered' , FALSE)->where('canceled' , FALSE)->orderBy('id' , 'desc')->get();
		return view($this->dir . 'pending' , compact('orders'));
	}

	/*
	 * Cancel Order
	 */
	public function cancelOrder (Request $request , $id)
	{
		$validate = Validator::make($request->only('reason') , ['reason' => 'required']);
		if ( $validate->fails() ) {
			flash("Please provide a valid reason before canceling this order")->important()->warning();
			return redirect()->back();
		}
		$order = Order::find($id);
		if ( $order == NULL ) {
			flash("Order not found")->important()->warning();
			return redirect()->back();
		}
		if ($order->delivered){
			flash("Too late, Order has been shipped to the customer")->important()->warning();
			return redirect()->back();
		}
		if ($order->confirmed){
			flash("Too late, Order can only be canceled by the customer")->important()->warning();
			return redirect()->back();
		}
		$remark = Remark::where('user_id' , $request->user()->id)->where('order_id' , $id)->first();
		if ( $remark == NULL ) {
			$remark = Remark::create(['reason' => $request->get('reason') , 'user_id' => $request->user()->id , 'order_id' => $id]);
		} else {
			$remark->update(['reason' => $request->get('reason')]);
		}
		$items  =   OrderItem::where('order_id', $id)->get();
		foreach ($items as $item){
				$item->update([
					'dispatched'    =>  FALSE
				]);
		}
		$order->update([
			'canceled' => TRUE,
			'assigned'  =>  FALSE
		]);
		flash("Order canceled successfully")->important()->warning();
		return redirect()->back();
	}

	public function assignOrder (Request $request , $id)
	{
		$validate = Validator::make($request->only('driver') , ['driver' => 'required']);
		if ( $validate->fails() ) {
			flash("Kindly select a driver to continue")->important()->warning();
			return redirect()->back();
		}
		$assigned = Assigned::where('order_id' , $id)->first();
		$order = Order::find($id);
		if ( $order == NULL ) {
			flash("Order not found")->important()->warning();
			return redirect()->back();
		}
		$dispatchedItems = OrderItem::where('dispatched' , TRUE)->get();
		if ( $dispatchedItems->count() < 1 ) {
			$order->update(['assigned' => FALSE]);
			flash("Dispatch at least one item before assigning an order")->important()->warning();
			return redirect()->back();
		}
		if ( $assigned == NULL ) {
			$assigned = Assigned::create(['order_id' => $id , 'business_id' => $order->business_id , 'driver_id' => $request->get('driver')]);
		}
		$assigned->update(['driver_id' => $request->get('driver')]);

		$order->update(['assigned' => TRUE]);
		flash("Order assigned successfully")->important()->warning();
		return redirect()->back();
	}

	public function massDispatch ($id)
	{
		$order  =   Order::find($id);
		if ($order == NULL){
			flash("Order no found")->important()->warning();
			return redirect()->back();
		}
		if ($order->canceled){
			flash("Dispatching items on a canceled order is not allowed")->important()->warning();
			return redirect()->back();
		}
		$orderItems = OrderItem::where('order_id' , $id)->get();
		foreach ( $orderItems as $item ) {
			$product   =   Product::find($item->product_id);
			if ($product == NULL){
				continue;
			}elseif ($product->qty <= 0){
				continue;
			}elseif ($product->qty < $item->quantity){
				continue;
			}
			$product->update([
				'qty'  =>  $product->qty - $item->quantity
			]);

			$item->update(['dispatched' => TRUE]);
		}
		flash("All products have been dispatched successfully")->important()->warning();
		return redirect()->back();
	}

	public function dispatchSingleItem ($id)
	{
		$item = OrderItem::where('id' , $id)->first();
		if ( $item == NULL ) {
			flash("Selected Item not found")->important()->warning();
			return redirect()->back();
		}
		if ($item->order->canceled){
			flash("Revert the order to dispatch Items")->important()->warning();
			return redirect()->back();
		}
		$product   =   Product::find($item->product_id);
		if ($product    ==  NULL){
			flash("Product not found")->important()->warning();
			return redirect()->back();
		}
		if ($product->qty < $item->quantity){
			flash("Amount of products ordered is greater than products in stock, Kindly restock to continue")->important()->warning();
			return redirect()->back();
		}
		$product->update([
			'qty'   =>  $product->qty - $item->quantity
		]);

		$item->update(['dispatched' => TRUE]);
		flash("Item dispatched Successfully")->important()->warning();
		return redirect()->back();
	}

	public function revertItem ($id)
	{
		$item = OrderItem::where('id' , $id)->first();
		if ( $item == NULL ) {
			flash("Selected Item not found")->important()->warning();
			return redirect()->back();
		}
		$product   =   Product::find($item->product_id);
		if ($product    ==  NULL){
			flash("Product not found")->important()->warning();
			return redirect()->back();
		}
		$product->update([
			'qty'   =>  $product->qty + $item->quantity
		]);
		$item->update(['dispatched' => FALSE]);
		flash("Item Reverted successfully")->important()->warning();
		return redirect()->back();
	}

	public function revertOrderCancellation($id){
		$order = Order::find($id);
		if ( $order == NULL ) {
			flash("Order not found")->important()->warning();
			return redirect()->back();
		}
		$order->update([
			'canceled'  =>  FALSE
		]);
		flash("Order cancellation reverted successfully")->important()->warning();
		return redirect()->back();
	}

	public function businessOrders($id){
		$orders = Order::where('business_id', $id)->orderBy('id' , 'desc')->get();
		return view($this->dir . 'all' , compact('orders'));
	}
}
