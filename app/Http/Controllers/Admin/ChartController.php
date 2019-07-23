<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;

class ChartController extends Controller
{
	public function index(){
		$ordersDelivered    =   Order::where('canceled', FALSE)->where('delivered', TRUE)->orderBy('created_at', 'desc')->get();
		$ordersAssigned     =   Order::where('assigned', TRUE)->where('canceled', FALSE)->where('delivered', FALSE)->orderBy('created_at', 'desc')->get();
		$ordersCanceled     =   Order::where('canceled', TRUE)->where('delivered', FALSE)->orderBy('created_at', 'desc')->get();
		$orders     =   Order::orderBy('created_at', 'desc')->get();
		return view('admin.index', compact('orders','ordersAssigned','ordersCanceled','ordersDelivered'));
	}

	public function algorithm ()
	{
		$size   =   Product::all()->count();
		$i  =   0;
		$lastProduct    =   0;
		$productID  =   0;
		$productSales   = [];
		$today  =   Carbon::now();
		foreach (range($i, $size-1) as $key) {
			if ($productID == 0){
				$product  = Product::where('title', '!=', null)->first();
				if ($size > 1){
					$lProduct = Product::where('title', '!=', null)->orderBy('created_at', 'desc')->first();
					$lastProduct    =   $lProduct->id;
				}
				$productID  =   $product->id + 1;
			}elseif ($productID > 0 && $productID < $lastProduct){
				$product    =   Product::find($productID);

				if ($product == NULL){
					if ($lastProduct  > $productID){
						$productID  =   $productID+1;

					}
					continue;
				}
				$productID  =   $product->id + 1;
			}
			$firstMonthSale =   OrderItem::where('product_id', $product->id)->whereBetween('created_at', [$today->startOfMonth()->toDateTimeString(), $today->endOfMonth()->toDateTimeString()])->sum('total');
			$secondMonthSale =   OrderItem::where('product_id', $product->id)->whereBetween('created_at', [$today->subMonth(1)->startOfMonth()->toDateTimeString(), $today->subMonth(1)->endOfMonth()->toDateTimeString()])->sum('total');
			array_push($productSales, array(
				"sales" => [$secondMonthSale, $firstMonthSale],
				"product" => $product->id,
			));
		}
		return response()->json([
			'sales' =>  $productSales
		]);
	}

	public function usersChart ()
	{
		$users  =   User::all()->count();
		$admin = (User::where('admin' , TRUE)->get()->count()/$users) * 100;
		$shopOwners = (User::where('user' , TRUE)->get()->count()/$users) * 100;
		$drivers = (User::where('driver' , TRUE)->get()->count()/$users) * 100;
		$marketers = (User::where('marketer' , TRUE)->get()->count()/$users) * 100;

		$lava = new Lavacharts; // See note below for Laravel

		$reasons = $lava->DataTable();

		$reasons->addStringColumn('Users')
			->addNumberColumn('Percent')
			->addRow(['Administrators', $admin])
			->addRow(['Customers', $shopOwners])
			->addRow(['Marketers', $marketers])
			->addRow(['Drivers', $drivers]);

		$lava->DonutChart('users', $reasons, [
			'title' => 'Registered users % => Total ( '.$users . " Users )"
		]);

		return view('charts.users', compact('lava'));
	}

	public function sales(){
		/*
		 * Get the current date
		 */
		$today  =   Carbon::now();
		/*
		 * Get the months in descending order
		 */
		$firstMonth     =  date('Y M', strtotime( $today->startOfMonth()));
		$secondMonth    =  date('Y M', strtotime( $today->subMonth(1)->startOfMonth()));
		$thirdMonth     =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$fourthMonth    =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$fifthMonth     =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$sixthMonth     =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$seventhMonth    =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$eigth    =  date('Y M', strtotime( $today->subMonth(1)->startOfMonth()));
		$ninethMonth     =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$tentMonth    =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$eleventhhMonth     =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		$twelevthMonth     =   date('Y M', strtotime($today->subMonth(1)->startOfMonth()));
		/*
		 *  Query Orders Between each month
		 */
		$firstMonthSales    =   DB::table('orders')->whereBetween('created_at', [$today->startOfMonth()->toDateTimeString(), $today->endOfMonth()->toDateTimeString()])->sum('amount');
		$chartjs = app()->chartjs
			->name('Sales')
			->type('line')
			->size(['width' => 400, 'height' => 200])
			->labels([$twelevthMonth, $eleventhhMonth,$tentMonth,$ninethMonth, $eigth, $seventhMonth,$sixthMonth,$fifthMonth,$fourthMonth, $thirdMonth, $secondMonth, $firstMonth, ])
			->datasets([
				[
					"label" => "Sales",
					'backgroundColor' => "rgba(38, 185, 154, 0.31)",
					'borderColor' => "rgba(38, 185, 154, 0.7)",
					"pointBorderColor" => "rgba(38, 185, 154, 0.7)",
					"pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
					"pointHoverBackgroundColor" => "#fff",
					"pointHoverBorderColor" => "rgba(220,220,220,1)",
					'data' => [65, 59, 80, 81, 56, 55, 40, 50, 60, 80,23, $firstMonthSales],
				],
			])
			->options([]);
		return $chartjs;
	}

	public function salesChart(){
		$firstMonth     =  date('M', strtotime( Carbon::today()->startOfMonth()));
		$secondMonth    =  date('M', strtotime( Carbon::today()->subMonth(1)->startOfMonth()));
		$thirdMonth     =   date('M', strtotime(Carbon::today()->subMonth(2)->startOfMonth()));
		$fourthMonth    =   date('M', strtotime(Carbon::today()->subMonth(3)->startOfMonth()));
		$fifthMonth     =   date('M', strtotime(Carbon::today()->subMonth(4)->startOfMonth()));
		$sixthMonth     =   date('M', strtotime(Carbon::today()->subMonth(5)->startOfMonth()));
		/*
		 * Sales
		 */
		$firstMonthSales    =   DB::table('orders')->whereBetween('created_at', [Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->endOfMonth()->toDateTimeString()])->sum('amount');
		$secondMonthSales    =   DB::table('orders')->whereBetween('created_at', [ Carbon::today()->subMonth(1)->startOfMonth()->toDateTimeString(), Carbon::today()->subMonth(1)->startOfMonth()->endOfMonth()->toDateTimeString()])->sum('amount');
		$thirdMonthSales    =   DB::table('orders')->whereBetween('created_at', [ Carbon::today()->subMonth(2)->startOfMonth()->toDateTimeString(), Carbon::today()->subMonth(2)->startOfMonth()->endOfMonth()->toDateTimeString()])->sum('amount');
		$fourthMonthSales    =   DB::table('orders')->whereBetween('created_at', [ Carbon::today()->subMonth(3)->startOfMonth()->toDateTimeString(), Carbon::today()->subMonth(3)->startOfMonth()->endOfMonth()->toDateTimeString()])->sum('amount');
		$fifthMonthSales    =   DB::table('orders')->whereBetween('created_at', [ Carbon::today()->subMonth(4)->startOfMonth()->toDateTimeString(), Carbon::today()->subMonth(4)->startOfMonth()->endOfMonth()->toDateTimeString()])->sum('amount');
		$sixthMonthSales    =   DB::table('orders')->whereBetween('created_at', [ Carbon::today()->subMonth(5)->startOfMonth()->toDateTimeString(), Carbon::today()->subMonth(5)->startOfMonth()->endOfMonth()->toDateTimeString()])->sum('amount');


		$salesLava = new Lavacharts; // See note below for Laravel

		$sales  = $salesLava->DataTable();

		$sales->addStringColumn('Sales')
			->addNumberColumn('Months')
			->addRow([$firstMonth,  $firstMonthSales])
			->addRow([$secondMonth,  $secondMonthSales])
			->addRow([$thirdMonth,  $thirdMonthSales])
			->addRow([$fourthMonth,  $fourthMonthSales])
			->addRow([$fifthMonth,  $fifthMonthSales])
			->addRow([$sixthMonth,  $sixthMonthSales]);

		$salesLava->BarChart('sales', $sales);
		$totalSales   =   DB::table('orders')->whereBetween('created_at', [ Carbon::today()->startOfMonth()->toDateTimeString(), Carbon::today()->subMonth(5)->startOfMonth()->endOfMonth()->toDateTimeString()])->sum('amount');
		return view('charts.sales', compact('salesLava', 'totalSales'));
	}
}
