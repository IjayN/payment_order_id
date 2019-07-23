<?php
	
	namespace App\Http\Controllers\Admin;
	
	use App\Data;
	use App\User;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	
	class JijengeController extends Controller
	{
		public $v = 'admin.';
		
		public function __construct ()
		{
		}
		
		public function students ()
		{
			$students = User::where ('student', true)->orderBy ('id', 'desc')->paginate (10);
			return view ($this->v . 'students', compact ('students'));
		}
		
		public function verified ()
		{
			$students = User::where ('student', true)->where ('verified', true)->orderBy ('id', 'desc')->paginate (10);
			return view ($this->v . 'students', compact ('students'));
		}
		
		public function unverified ()
		{
			$students = User::where ('student', true)->where ('verified', false)->orderBy ('id', 'desc')->paginate (10);
			return view ($this->v . 'students', compact ('students'));
		}
		
		public function downloadFile ($id)
		{
			$data = Data::find ($id);
			
			if (is_null ($data)) {
				flash ("File not found");
				return redirect ()->back ();
			}
			$path = public_path (studentUploads () . $data->filePath);
			
			return response ()->download ($path);
		}
		
		public function verify ($id)
		{
			$data = User::find ($id);
			$data->verified = true;
			$data->save ();
			flash ("Account activated successfully")->important ()->warning ();
			return redirect ()->back ();
		}
		public function unverify ($id)
		{
			$data = User::find ($id);
			$data->verified = false;
			$data->save ();
			flash ("Account deactivated successfully")->important ()->warning ();
			return redirect ()->back ();
		}
		
		public function student ($id)
		{
			$user = User::find ($id);
			$data = Data::where ('user_id', $id)->get ();
			
			if (is_null ($user)) {
				flash ("student not found")->important ()->warning ();
				return redirect ()->back ();
			}
			
			return view ($this->v . 'student', compact ('user', 'data'));
		}
	}
