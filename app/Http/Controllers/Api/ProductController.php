<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

	public function products ()
	{
		$products = Product::where('title' , '!=' , NULL)->orderBy('title' , 'asc')->with('banner')->get();

		return response()->json(['meta' => ['message' => 'All Products end point' , 'success' => TRUE ,] , 'data' => ['products' => $products ,] , "error" => FALSE ,] , 200);
	}

	public function categoryProducts (Request $request)
	{
		$category = Category::find($request->user()->id);
		if ( $category == NULL ) {
			return response()->json(['meta' => ['success' => FALSE , 'message' => "Category not found" , "error" => TRUE] ,]);
		}
		$products = $category->product()->where('title' , '!=' , NULL)->orderBy('title' , 'asc')->with('banner')->get();

		return response()->json(['meta' => ['message' => 'All Products end point' , 'success' => TRUE ,] , 'data' => ['products' => $products ,] , "error" => FALSE] , 200);

	}

	public function product (Request $request)
	{
		$trial = Product::find($request->get('id'));
		if ( $trial == NULL ) {
			return response()->json(['meta' => ['message' => "Product not found" ,] , "error" => TRUE]);
		}
		$product = Product::where('id' , $request->get('id'))->with('banner')->get();
		return response()->json(["meta" => ['success' => TRUE , 'message' => "" ,] , "data" => ['product' => $product ,] , "error" => FALSE]);
	}

}
