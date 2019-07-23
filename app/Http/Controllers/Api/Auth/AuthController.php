<?php

	namespace App\Http\Controllers\Api\Auth;

	use App\Http\Controllers\OTP;
	use App\User;
	use Carbon\Carbon;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use Laravolt\Avatar\Avatar;
	use Tymon\JWTAuth\Exceptions\JWTException;
	use Tymon\JWTAuth\Exceptions\TokenExpiredException;
	use Tymon\JWTAuth\Exceptions\TokenInvalidException;
	use Tymon\JWTAuth\Facades\JWTAuth;

	class AuthController extends Controller
	{


		/**
		 * @var OTP
		 */
		public $OTP;

		public function __construct (OTP $OTP)
		{

			$this->OTP = $OTP;
		}

		public function register (Request $request)
		{
			/*
			 * Validate User request
			 */
			$validate = Validator::make ($request->only ('name', 'phone', 'password'), ['name' => 'required', 'phone' => 'required|unique:users', 'password' => 'required|min:6',]);
			/*
			 * If validation fails, return error bag
			 */
			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation error",], "message" => "Registration was not successful", "errors" => $validate->getMessageBag (), "error" => TRUE], 400);
			}
			/*
			 * Create a new user
			 */


			$user = User::create (['name' => $request->get ('name'), 'phone' => $request->get ('phone'), 'password' => Hash::make ($request->get ('password')),]);
			/*
			 * Save and Send OTP
			 */
			$this
				->setPermissions ($request, $user);
			$this
				->generateAvatar ($user);
			$this
				->sendOTP ($user);
			$credentials = $request->only ('phone', 'password');
			try {
				if (!$token = JWTAuth::attempt ($credentials)) {
					return response ()->json (['error' => 'Unauthorised'], 401);
				}
			} catch (JWTException $e) {
				return response ()->json (['User could not be authenticated', $e->getMessage ()], $e->getStatusCode ());
			}
			return response ()->json (['token' => $token, 'token_type' => 'bearer', 'user' => Auth::user (), "error" => FALSE

			]);
		}

		public function login (Request $request)
		{
			$validate = Validator::make ($request->only ('phone', 'password'), ['phone' => 'required', 'password' => 'required',]);

			if ($validate->fails ()) {
				return response ()->json (["meta" => ["message" => "Validation error",], "errors" => $validate->getMessageBag (),], 400);
			}

			$credentials = $request->only ('phone', 'password');
			try {
				if (!$token = JWTAuth::attempt ($credentials)) {
					return response ()->json (['error' => 'Unauthorised'], 401);
				}
			} catch (JWTException $e) {
				return response ()->json (['User could not be authenticated', $e->getMessage ()], $e->getStatusCode ());
            }

            if (!$request->user()->validated) {
                 $this->sendOTP($request->user());/*  */
            }

			return response ()->json (['token' => $token, 'token_type' => 'bearer', 'user' => Auth::user (),
				"error" => FALSE
			]);
		}


		public function sendOTP ($user)
		{
			$otp = generateOTP (4);
			$user->otp = $otp;
			$user->validated = FALSE;
			$user->save ();

			$message = "Your Sembe verification code is " . $otp;
			/*
			 * Send OTP MESSAGE
			 */
			$this->OTP->sendSms ($user->phone, $message);
			return $otp;
		}

		public function generateAvatar ($user)
		{
			$path = '/users/avatar/' . uniqid () . '.png';
			$avatar = new Avatar();
			$avatar->create ($user->name)->save (public_path () . $path);

			$user->update (['avatar' => $path,]);
			return TRUE;
		}

		public function setPermissions ($request, $user)
		{
			if ($request->get ('user') == TRUE) {
				$user->update (['user' => TRUE,]);
				return $this;
			}
			if ($request->get ('driver') == TRUE) {
				$user->update (['driver' => TRUE,]);
				return $this;
			}

			if ($request->get ('admin') == TRUE) {
				$user->update (['admin' => TRUE,]);
				return $this;
			}

			if ($request->get ('marketer') == TRUE) {
				$user->update (['marketer' => TRUE,]);
				return $this;
			}
			if ($request->get ('student') == TRUE) {
				$user->update (['student' => TRUE,]);
				return $this;
			}
			$user->update (['user' => TRUE,]);
			return $this;
		}

		public function validateOtp (Request $request)
		{
			$validate = Validator::make ($request->only ('otp'), ['otp' => 'required']);
			if ($validate->fails ()) {
				return response ()->json ([["meta" => ["message" => "Validation error"], "message" => "Please enter the verification code", "errors" => $validate->getMessageBag (),]]);
			}
			$user = User::where ('otp', $request->get ('otp'))->first ();
			if ($user == NULL) {
				return response ()->json (["message" => "Verification code is invalid"]);
			}
			if ($user->validated) {
				return \response ()->json (['message' => "This verification code has already been used or expired, Resend verification code"]);
			}


			$user->validated = TRUE;
			$user->save ();
			return response ()->json (["data" => ['message' => "Verification successful"]]);
		}

		public function resendCode (Request $request)
		{
			$user = JWTAuth::authenticate ($request->token);
			$this->sendOTP ($user);
			return response ()->json (NULL, 200);
		}

		public function update (Request $request)
		{
			$user = $request->user ();
			if ($request->user ()->phone != $request->get ('phone')) {
				$this->sendOTP ($user);
			}
			$user->update (['name' => $request->get ('name', $user->name), 'phone' => $request->get ('phone', $user->phone)]);
			$this->generateAvatar ($user);


			return \response ()->json (["meta" => ["message" => "User Updated Successfully"], "data" => ['user' => $user]]);
		}

		public function logout (Request $request)
		{
			try {
				if (JWTAuth::invalidate ($request->token)) {
					return response ()->json (['success' => TRUE, 'message' => 'User logged out successfully']);
				}
				return \response ()->json (['message' => 'unauthorised'], 401);
			} catch (JWTException $exception) {
				return response ()->json (['success' => FALSE, 'message' => 'Sorry, the user cannot be logged out'], 500);
			}
		}

		public function search (Request $request)
		{
			$user = User::where ('phone', $request->get ('phone'))->first ();
			if ($user == NULL) {
				return \response ()->json (["error" => "User not found"]);
			}

			return \response ()->json (['success' => "User available"]);
		}

		public function initResetPassword (Request $request)
		{
			$validate = Validator::make ($request->only ('phone'), [
				'phone' => 'required'
			]);

			if ($validate->fails ()) {
				return \response ()->json ([
					'error' => true,
					"errors" => $validate->getMessageBag (),
					"meta" => [
						"message" => "User not found"
					]
				]);
			}

			$userExists = User::where ('phone', $request->get ('phone'))->first ();

			if ($userExists == null) {
				return response ()->json ([
					'error' => true,
					"meta" => [
						"message" => "User does not exist"
					]
				], 404);
			}

			$reset = DB::table ('password_resets')->where ('phone', $request->get ('phone'))->first ();

			if ($reset == null) {
				DB::table ('password_resets')->insert ([
					'phone' => $request->get ('phone'),
					'token' => generateOTP (4),
				]);
				$user = DB::table ('password_resets')->where ('phone', $request->get ('phone'))->first ();
			} else {
				$user = $reset;
				if (Carbon::parse ($reset->created_at)->diffInHours (Carbon::now ()) < 2) {
					$this
						->sendToken ($user);
					return \response ()->json ([
						'error' => false,

						'resetToken' => $user->token,
						"meta" => [
							"message" => "Reset password token"
						]
					]);
				} else {
					DB::table ('password_resets')->where ('phone', $request->get ('phone'))->update ([
						'token' => generateOTP (4),
					]);
					$user = DB::table ('password_resets')->where ('phone', $request->get ('phone'))->first ();
					$this
						->sendToken ($user);
					return \response ()->json ([
						'error' => false,

						'resetToken' => $user->token,
						"meta" => [
							"message" => "Reset password token"
						]
					]);
				}
			}
			$this
				->sendToken ($user);
			return \response ()->json ([
				'error' => false,

				'resetToken' => $user->token,
				"meta" => [
					"message" => "Reset password token"
				]
			]);
		}

		public function resetPassword (Request $request)
		{
			$validate = Validator::make ($request->all (), [
				'password' => 'required|confirmed',
				'token' => 'required',
			]);

			if ($validate->fails ()) {
				return \response ()->json ([
					'error' => true,
					"errors" => $validate->getMessageBag (),
					"meta" => [
						"message" => "User not found"
					]
				]);
			}

			$resetToken = DB::table ('password_resets')->where ('token', $request->get ('token'))->first ();

			if ($resetToken == null || Carbon::parse ($resetToken->created_at)->diffInHours () > 2) {
				return response ()->json ([
					'error' => true,
					"meta" => [
						"message" => "Token Expired"
					]
				]);
			}
			$userExists = User::where ('phone', $resetToken->phone)->first ();

			if ($userExists == null) {
				return response ()->json ([
					'error' => true,
					"meta" => [
						"message" => "User does not exist"
					]
				], 404);
			}


			$userExists->update ([
				'password' => Hash::make ($request->get ('password'))
			]);

			return response ()->json ([
				"error" => false,
				"meta" => [
					"message" => "Password reset successful"
				]
			]);
		}

		public function sendToken ($resetPassword)
		{
			$message = "Your Sembe Reset Password code is " . $resetPassword->token;
			/*
			 * Send OTP MESSAGE
			 */
			$this
				->OTP
				->sendSms ($resetPassword->phone, $message);

			return $resetPassword->token;
		}

		public function checkAuth (Request $request)
		{
			try {
				JWTAuth::parseToken ()->authenticate ();

			} catch (TokenExpiredException $e) {

				return response ()->json ([
					'authenticated' =>  false
				]);

			} catch (TokenInvalidException $e) {

				return response ()->json ([
					'authenticated' =>  false
				]);

			} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

				return response ()->json ([
					'authenticated' =>  false
				]);

			}
			return response ()->json ([
				'authenticated' =>  true
			]);

		}
	}
