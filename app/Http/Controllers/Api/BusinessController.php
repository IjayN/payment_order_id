<?php

namespace App\Http\Controllers\Api;

use App\Business;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
	public function index (Request $request)
	{
		$businesses = Business::where('user_id' , $request->user()->id)->orderBy('id' , 'desc')->get();
		return response()->json(['meta' => ['message' => "All user Businesses"] , 'data' => ["businesses" => $businesses] , 'error' => FALSE] , 200);
	}

	public function business (Request $request)
	{
		$business = Business::find($request->get('id'));
		if ( $business == NULL ) {
			return \response()->json(["meta" => ["message" => "Business not found"] , 'error' => TRUE] , 404);
		}
		return response()->json(['meta' => ["message" => "Business"] , 'data' => ['business' => $business] , 'error' => FALSE]);
	}

	public function create (Request $request)
	{
		$validate = Validator::make($request->only('name' , 'contact' , 'location', 'location_name') , ['name' => 'required' ,
			'location' => 'required',
			'location_name' => 'required']);
		/*
		 * Validate API REQUEST
		 */
		if ( $validate->fails() ) {
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}

		$business = $request->user()->businesses()->create(['name' => $request->get('name') ,
			'location' => $request->get('location') ,
			'location_name' =>  $request->get('location_name'),
			'contact' => $request->get('phone' , $request->user()->phone)]);
		return response()->json(['meta' => ["message" => "Business Created successfully"] , "data" => ['business' => $business] , 'error' => FALSE] , 201);

	}

	public function update (Request $request)
	{
		$business = Business::find($request->get('id'));
		if ( $business == NULL ) {
			return response()->json(["meta" => ["message" => "Business not found"] , 'error' => TRUE] , 404);
		}
		$business->update(['name' => $request->get('name' , $business->name) ,
			'contact' => $request->get('phone' , $business->contact) ,
			'location' => $request->get('location' , $business->location),
			'location_name' => $request->get('location_name' , $business->location_name)
		]);

		return response()->json(["meta" => ["message" => "Business details updated successfully"] , "data" => ["business" => $business] , 'error' => FALSE] , 201);
	}

	public function delete (Request $request)
	{
		$business = Business::find($request->get('id'));
		if ( $business == NULL ) {
			return \response()->json(["meta" => ["message" => "Business not found"] , "error" => TRUE]);
		}
		$business->delete();
		return response(["meta" => ["message" => "Business Deleted successfully"] , "error" => FALSE] , 201);
	}


}
