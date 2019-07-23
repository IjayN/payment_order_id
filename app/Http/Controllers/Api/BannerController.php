<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Image;

class BannerController extends Controller
{
	public function __construct ()
	{

	}

	public function uploadBanner (Request $request , $product)
	{
		$name = customUnique() . '.' . $request->file('file')->getClientOriginalExtension();

		$request->file('file')->move(public_path(productUploads()) , $name);
		/*
		 * Resize and sve banner File
		 */
		Image::make(public_path(productUploads() . $name))
			->resize(400 , NULL , function ($constraint) {
				$constraint
					->aspectRatio()
					->upsize();
			})
			->text('Sembe.' , 0 , 200)
			->save(public_path(bannerResized() . $name));
		/*
		 * Delete Original Image File
		 */
		deleteFile(public_path(productUploads() . $name));
		/*
		 * Save Banner Image
		 */
		$product->banner()->create([
			'url' => $name ,
			'name' => $request->file('file')->getClientOriginalName() ,
		]);
	}
}
