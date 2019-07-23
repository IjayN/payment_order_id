<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
	/**
	 * @var UtilitiesController
	 */
	public $utilitiesController;
	/**
	 * @var ValidationController
	 */
	public $validationController;

	public function __construct (UtilitiesController $utilitiesController , ValidationController $validationController)
	{
		$this->utilitiesController = $utilitiesController;
		$this->validationController = $validationController;
		$this->middleware('auth')->except('login');
	}

	public function index ()
	{

		$ordersDelivered    =   Order::where('canceled', FALSE)->where('delivered', TRUE)->orderBy('created_at', 'desc')->get();
		$ordersAssigned     =   Order::where('assigned', TRUE)->where('canceled', FALSE)->where('delivered', FALSE)->orderBy('created_at', 'desc')->get();
		$ordersCanceled     =   Order::where('canceled', TRUE)->where('delivered', FALSE)->orderBy('created_at', 'desc')->get();
		$orders     =   Order::orderBy('created_at', 'desc')->get();
		return view('admin.index', compact('orders','ordersAssigned','ordersCanceled','ordersDelivered'));

	}

	public function products ()
	{
		$products = Product::orderBy('id' , 'desc')->get();
		$message = "All";
		$categories = Category::orderBy('name' , 'asc')->get();
		return view('admin.products' , compact('products' , 'categories' , 'message'));
	}

	public function newProduct ()
	{
		$categories = Category::orderBy('name' , 'asc')->get();
		return view('admin.new-product' , compact('categories'));
	}

	public function postProduct (Request $request)
	{
		$this->validate($request , ['title' => 'required|unique:products' , 'category' => 'required' , 'price' => 'required' , 'weight' => 'required' , 'qty' => 'required' , 'file' => 'required|image' , 'description' => 'required' ,]);
		$product = Product::create(['title' => $request->get('title') , 'sku' => generateOTP(8) , 'weight' => $request->get('weight') , 'price' => $request->get('price') , 'qty' => $request->get('qty') , 'description' => $request->get('description') , 'category_id' => $request->get('category') ,]);

		if ( $request->get('qty') < 1 ) {
			$product->update(['available' => FALSE]);
		}

		$name = customUnique() . '.' . $request->file('file')->getClientOriginalExtension();

		$request->file('file')->move(public_path(productUploads()) , $name);

		$product->banner()->create(['src' => $name , 'name' => $request->file('file')->getClientOriginalName() ,]);

		return redirect()->route('products');
	}

	public function login (Request $request)
	{
		$this->validate($request , ['phone' => 'required' , 'password' => 'required' ,]);
		if ( Auth::attempt(['phone' => $request->get('phone') , 'password' => $request->get('password') ,]) ) {
			return redirect()->route('home');
		} else {
			flash("Username or Password is incorrect")->important();
			return redirect()->route('login');
		}


	}
}
