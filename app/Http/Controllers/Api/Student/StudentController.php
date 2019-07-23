<?php

namespace App\Http\Controllers\Api\Student;

use App\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
	public function __construct ()
	{
	}

	public function fileUpload(Request $request){

		$validate   =   Validator::make($request->all(), [
			'file' =>  'required|file'
		]);


		if ($validate->fails()){
			return response()->json(["meta" => ["message" => "Validation Errors"] , "errors" => $validate->getMessageBag() , 'error' => TRUE]);
		}



		$name   =   customUnique().'.'. $request->file('file')->getClientOriginalExtension();
		/*
		* Store user
		*/
		$request->file('file')->move(public_path(studentUploads()), $name);


		Data::create([
			'filePath' =>  $name,
			'fileName' => $request->file('file')->getClientOriginalName(),
			'user_id'   =>  $request->user()->id
		]);
		$files  =   Data::where('user_id', $request->user()->id)->orderBy('id', 'desc');
		return response()->json([
			"meta" =>
				[
					"message" => "Upload Successful"
				] ,
			"data"  =>  [
				"files" => $files
			],
			'error' => FALSE
		]);
	}

	public function files(Request $request){
		$files  =   Data::where('user_id', $request->user()->id)->orderBy('id', 'desc');
		if ($files  ==  NULL){
			return response()->json([
				"error" =>  TRUE,
				"meta"  =>  [
					"message"   =>  "File not found"
				],
			], 404);
		}

		return response()->json([
			"error" =>  FALSE,
			"data"  =>  [
				"files" =>  $files
			]
		]);
	}

	public function deleteFile(Request $request){
		$fileId =   $request->get('fileId');
		$data   =   Data::find($fileId);
		if ($data   ==  NULL){
			return response()->json([
				'error' =>  TRUE,
				"meta"  =>  [
					"message"   =>  "File not found"
				]
			], 404);
		}
		$data->delete();
		$path   =   public_path(studentUploads(). $data->filePath);
		if (file_exists($path)) {
			\Illuminate\Support\Facades\File::delete($path);
		}
		return response()->json([
			"error" =>  FALSE,
			"meta"  =>  [
				"message"   =>  "File deleted successfully"
			]
		]);
	}
}
