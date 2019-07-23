<?php
	
	namespace App\Http\ViewComposers;
	
	
	use App\Category;
	use App\Order;
	use App\Product;
	use App\User;
	use Illuminate\Contracts\View\View;
	
	
	class AdminComposer
	{
		
		
		public function compose (View $view)
		{
			$view->with (
				[
					'admin_orders' => Order::all ()->count (),
					'admin_users' => User::where ('student', false)->get ()->count (),
					'admin_orders_pending_delivery' => Order::where ('delivered', FALSE)->where ('canceled', FALSE)->get ()->count (),
					'admin_orders_delivered' => Order::where ('delivered', TRUE)->get ()->count (),
					'admin_orders_canceled' => Order::where ('canceled', TRUE)->get ()->count (),
					'admin_products' => Product::all ()->count (),
					'admin_categories' => Category::all ()->count (),
					'admin_jijenge' => User::where ('student', true)->get ()->count (),
					'admin_pending_verification' => User::where ('student', true)->where ('verified', false)->orderBy ('id', 'desc')->get ()->count (),
					'admin_verified' => User::where ('student', true)->where ('verified', true)->orderBy ('id', 'desc')->get ()->count ()
				]
			);
		}
	}