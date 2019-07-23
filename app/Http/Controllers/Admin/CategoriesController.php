<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
	private $dir = 'category.';

	public function categories ()
	{
		$categories = Category::orderBy('id' , 'desc')->get();
		return view($this->dir . 'all' , compact('categories'));
	}

	public function createCategory(Request $request){
		$validate   =   Validator::make($request->only('name'), [
			'name'  =>  'required|unique:categories'
		]);

		if ($validate->fails()){
			flash("Please provide a unique category name before submitting")->important()->warning();
			return redirect()->back();
		}

		Category::create([
			'name'  =>  $request->get('name')
		]);
		flash("Category created successfully")->important()->success();
		return redirect()->back();
	}

	public function editCategory(Request $request, $id){
		$validate   =   Validator::make($request->only('name'), [
			'name'  =>  'required|unique:categories'
		]);

		if ($validate->fails()){
			flash("Please provide a unique category name before submitting")->important()->warning();
			return redirect()->back();
		}

		$category   =   Category::find($id);
		if ($category == NULL){
			flash("Category not found")->important()->warning();
			return redirect()->back();
		}
		$category->update([
			'name'  =>  $request->get('name')
		]);
		flash("Category Edited successfully")->important()->success();
		return redirect()->back();
	}

	public function deleteCategory($id){
		$category   =   Category::find($id);
		if ($category == NULL){
			flash("Category not found")->important()->warning();
			return redirect()->back();
		}
		if ($category->product->count() > 0){
			flash("Category not deletd, We are working on this")->important()->warning();
			return redirect()->back();
		}
		$category->delete();

		flash("Category deleted successfully")->important()->success();
		return redirect()->back();
	}

	public function categoryProducts($id){
		$category   =   Category::find($id);
		if ($category == NULL){
			flash("Category not found")->important()->warning();
			return redirect()->back();
		}
		$message    =   $category->name;
		$products   =   Product::where('category_id', $id)->orderBy('created_at', 'desc')->get();
		$categories = Category::orderBy('name', 'asc')->get();
		return view('admin.products', compact('products','categories','message'));
	}
}
