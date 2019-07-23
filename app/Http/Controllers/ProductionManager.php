<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductionManager extends Controller
{
    public function getProducts()
    {
        $products = Product::all();
        return view('admin.add-production', compact('products'));
    }

    public function addProducts(Request $request)
    {
        $product = Product::find($request->get('product'));
        if ($product == null) {
            flash("Product not found")->warning();
            return redirect()->back();
        }

        $product->update([
            'qty' => $request->get('qty') + $product->qty
        ]);
        flash("Production added successfully")->important();
        return redirect()->back();
    }
}
