<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Category;
use App\Item;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	public function allProducts ()
	{
		$products = Product::orderBy('created_at' , 'desc')->get();
		return view('admin.products' , compact('products'));
	}
	public function product($id){
		$product    =   Product::find($id);
		if ($product == NULL){
			flash("Product not found")->important()->warning();
			return redirect()->back();
		}
		$quantityOnOrder      =        OrderItem::where('product_id', $id)->where('dispatched', FALSE)->sum('quantity');
		$quantityDelivered    =        OrderItem::where('product_id', $id)->where('dispatched', TRUE)->sum('quantity');
		$totalSales           =       OrderItem::where('product_id', $id)->where('dispatched', TRUE)->sum('total');

		$quantityOnCart      =  Item::where('product_id', $id)->sum('quantity');
		$banner               = Banner::where('product_id', $id)->first();
		$categories         =   Category::orderBy('name', 'asc')->get();
		if ($banner == NULL){
			$src    =   productUploads().'default.png';
		}else{
			$src    = $banner->src;
		}
		return view('product.product', compact('product','quantityDelivered','quantityOnOrder','totalSales','quantityOnCart', 'src','categories'));
	}

	public function update(Request $request, $id){
		$product    =   Product::find($id);
		if ($product == NULL){
			flash("Product not found")->important()->warning();
			return redirect()->back();
		}

		$product->update([
			'title' =>  $request->get('title', $product->title),
			'price' =>  $request->get('price', $product->price),
			'qty'   =>  $request->get('qty', $product->qty),
			'weight'    =>  $request->get('weight', $product->weight),
			'description'   =>  $request->get('description', $product->description),
			'category_id'   =>  $request->get('category', $product->category_id)
		]);
		if ($request->get('qty') > 0){
			$product->update([
				'available' =>  TRUE
			]);
		}else{
			$product->update([
				'available' =>  false
			]);
		}
		if ($request->has('file')){
			$name = customUnique() . '.' . $request->file('file')->getClientOriginalExtension();

			$request->file('file')->move(public_path(productUploads()) , $name);
			$banner =   Banner::where('product_id', $product->id)->first();
			if ($banner == NULL){
				$product->banner()->create(['src' => $name , 'name' => $request->file('file')->getClientOriginalName() ,]);
			}else{
				$banner->update([
					'src'   =>  $name,
					'name' => $request->file('file')->getClientOriginalName()
				]);
			}

		}
		flash("Product updated successfully")->important()->success();
		return redirect()->back();
	}

	public function destroy($id){
		$product    =   Product::find($id);
		if ($product == NULL){
			flash("Product not found")->important()->warning();
			return redirect()->back();
		}
		$quantityOnOrder      =        OrderItem::where('product_id', $id)->where('delivered', FALSE)->get();
		if ($quantityOnOrder->count() > 0){
			flash("Failed to delete, This product is currently on other orders")->important()->warning();
			return redirect()->back();
		}
		//$product->delete();
		flash("Feature coming soon")->important()->success();
		return redirect()->to('/products');
	}

}
