<?php

	namespace App\Http\Controllers\Api;

	use App\Business;
	use App\Cart;
	use App\Http\Controllers\LogController;
	use App\Item;
	use App\Order;
	use App\OrderItem;
	use App\Payment;
	use App\Product;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Validator;
	use Carbon\Carbon;

	class CartController extends Controller
	{
		/**
		 * @var \App\Http\Controllers\PaymentController
		 */
		public $paymentController;
		/**
		 * @var LogController
		 */
		public $logController;
		private $mpesa;

		public function __construct (\App\Http\Controllers\PaymentController $paymentController, LogController $logController)
		{
				 $this->mpesa 	=	"false";

			$this->paymentController = $paymentController;
			$this->logController = $logController;
		}

		public function cart (Request $request)
		{
			$validate = Validator::make ($request->only ('product_id', 'quantity', 'business_id'),
				[
					'business_id' => 'required',
				]);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$business = Business::find ($request->get ('business_id'));
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "Business Not found"], "error" => TRUE], 404);
			}
			$cart = Cart::where ('business_id', $business->id)->with ('business', 'item', 'item.product', 'item.product.banner')->first ();
			if ($cart == NULL) {
				$cart = Cart::create ([
					'business_id' => $request->get ('business_id'),
					'total' => 0
				]);
			}
			return response ()->json ([
				'meta' => [
					"message" => "Cart Items"
				],
				"data" => [
					"cart" => $cart,
				],
				"error" => FALSE
			]);
		}

		public function add (Request $request)
		{
			$validate = Validator::make ($request->only ('product_id', 'quantity', 'business_id'),
				[
					'product_id' => 'required',
					'business_id' => 'required',
					'quantity' => 'required'
				]);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"],
					"errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			if ($request->get ('quantity') <= 0) {
				return response ()->json (["meta" => ["message" => "Invalid product Quantity"], "message" => "Quantity input should be greater than zero", "error" => TRUE], 400);
			}
			$product = Product::find ($request->get ('product_id'));
			if ($product == NULL) {
				return response ()->json (["meta" => ["message" => "Product Not found"], "err" => TRUE], 404);
			}

			$business = Business::find ($request->get ('business_id'));
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "Business Not found"], "err" => TRUE], 404);
			}
			$cart = Cart::where ('business_id', $business->id)->first ();
			if ($cart == NULL) {
				$cart = $business->cart ()->create ([
					'total' => 0
				]);
			}
			$item = Item::where ('product_id', $request->get ('product_id'))->where ('cart_id', $cart->id)->first ();
			if ($item == NULL) {
				$cart->item ()->create ([
					'quantity' => $request->get ('quantity'),
					'product_id' => $request->get ('product_id'),
					'total' => $product->price * $request->get ('quantity')
				]);
			} else {
				$item->update ([
					'quantity' => $item->quantity + $request->get ('quantity'),
					'total' => $product->price * ($request->get ('quantity') + $item->quantity)
				]);
			}


			$total_items_prices = $cart->item->sum ('total');

			$cart->update ([
				'total' => $total_items_prices
			]);

			return response ()->json ([
				'meta' => [
					"message" => "Item added to cart successfully"
				],
				"data" => [
					"cart" => $cart,
				],
				"error" => FALSE
			]);
		}

		public function editItem (Request $request)
		{
			$validate = Validator::make ($request->only ('item_id', 'quantity'), [
				'item_id' => 'required',
				'quantity' => 'required',
			]);
			if ($request->get ('quantity') <= 0) {
				return response ()->json ([
					"meta" => [
						"message" => "Invalid product Quantity"
					],
					"message" => "Quantity input should be greater than zero",
					"error" => TRUE
				], 400);
			}
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$item = Item::where ('id', $request->get ('item_id'))->first ();
			if ($item == NULL) {
				return response ()->json (["meta" => ["message" => "Item Not found"], "error" => TRUE], 404);
			}
			$product = $item->product;
			if ($product == NULL) {
				return response ()->json (["meta" => ["message" => "Item Not found"], "error" => TRUE], 404);
			}
			/*
			 * Delete all items having this product
			 */
			$item->update ([
				'quantity' => $request->get ('quantity'),
				'total' => $product->price * $request->get ('quantity'),
			]);
			$c = Cart::find ($item->cart_id);
			$c->update ([
				'total' => $c->item->sum ('total')
			]);
			$cart = Cart::where ('business_id', $c->business_id)->with ('business', 'item', 'item.product', 'item.product.banner')->first ();
			return response ()->json ([
				'meta' => [
					"message" => "Your cart has been updated successfully"
				],
				"data" => [
					"cart" => $cart,
				],
				"error" => FALSE
			]);
		}

		public function removeItem (Request $request)
		{
			$validate = Validator::make ($request->only ('item_id'), [
				'item_id' => 'required'
			]);

			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}

			$item = Item::where ('id', $request->get ('item_id'))->first ();
			if ($item == NULL) {
				return response ()->json (["meta" => ["message" => "Item Not found"], "error" => TRUE], 404);
			}
			$item->delete ();

			$cart = Cart::find ($item->cart_id);
			$cart->update ([
				'total' => $cart->item->sum ('total')
			]);
			return response ()->json ([
				'meta' => [
					"message" => "Your cart has been updated successfully"
				],
				"data" => [
					"cart" => $cart,
				],
				"error" => FALSE
			]);
		}

		public function destroy2 (Request $request)
		{
			$validate = Validator::make ($request->only ('business_id'), [
				'business_id' => 'required'
			]);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$business = Business::find ($request->get ('business_id'));
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "Business Not found"], "error" => TRUE], 404);
			}
			$cart = Cart::where ('business_id', $business->id)->first ();
			if ($cart == NULL) {
				$cart = $business->cart ()->create ([
					'total' => 0
				]);
			}
			$items = Item::where ('cart_id', $cart->id)->get ();

			foreach ($items as $item) {
				Item::find ($item->id)->delete ();
			}
			$cart->update ([
				'total' => 0
			]);

			return $this;
		}

		public function destroy (Request $request)
		{
			$validate = Validator::make ($request->only ('business_id'), [
				'business_id' => 'required'
			]);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$business = Business::find ($request->get ('business_id'));
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "Business Not found"], "error" => TRUE], 404);
			}
			$cart = Cart::where ('business_id', $business->id)->first ();
			if ($cart == NULL) {
				$cart = $business->cart ()->create ([
					'total' => 0
				]);
			}
			$items = Item::where ('cart_id', $cart->id)->get ();

			foreach ($items as $item) {
				Item::find ($item->id)->delete ();
			}
			$cart->update ([
				'total' => 0
			]);

			return response ()->json ([
				'meta' => [
					'message' => "Cart Destroyed successfully"
				],
				"data" => [
					"cart" => $cart
				],
				"error" => FALSE
			]);

		}

		public function makeOrder (Request $request)
		{
			$validate = Validator::make ($request->only ('business_id', 'phone', 'mpesa'), [
				'business_id' => 'required',
				'phone' => 'required',
				'mpesa' => 'required'
			]);
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation Errors"], "errors" => $validate->getMessageBag (), 'error' => TRUE]);
			}
			$business = Business::find ($request->get ('business_id'));
			if ($business == NULL) {
				return response ()->json (["meta" => ["message" => "Product Not found"], "error" => TRUE], 404);
			}
			$cart = Cart::where ('business_id', $business->id)->first ();
			if ($cart == NULL) {
				return response ()->json (["meta" => ["message" => "Cart Not found"], "error" => TRUE], 404);
			}
			$items = Item::where ('cart_id', $cart->id)->get ();
			if ($items->count () <= 0) {
				return response ()->json (["meta" => ["message" => "You don't have any items in your cart"], "error" => TRUE], 404);
			}
			/*
			 * Initiate Payment and Order
			 */


			$order = $business->order ()->create ([
				'amount' => $cart->total,
			]);

			/*
			 * Make Payment
			 */



			if ($request->get ('mpesa') == "true") {

				$this->paymentController->sendPayment ($request->user ()->phone, $cart->total);

				//ORDER //MPESA //ITEMS //REQUEST
         $this->mpesa 	=	"true";
				\Session::put('order', $order);
				\Session::put('mpesa', $this->mpesa);
				\Session::put('items', $items);
				\Session::put('request', $request);
				\Session::put('cart', $cart);

    

			}

		}

	}
