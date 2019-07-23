<?php

namespace App\Http\Controllers;

use App\Assigned;
use App\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Avatar;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.create-user');
    }

    public function allUsers()
    {
        $users = User::where('student', false)->orderBy('created_at', 'desc')->get();
        $message = "All users";
        return view('admin.users', compact('users', 'message'));
    }

    public function createUser(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'phone' => 'required|unique:users', 'password' => 'required|min:6', 'type' => 'required',]);

        $user = User::create(['name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);

        $this->setPermissions($request, $user);
        $this->generateAvatar($user);
        Log::create([
            'type' => "Account Created",
            'info' => "New Account for " . $user->name . " phone " . $user->phone . " created by " . Auth::user()->name
        ]);
        flash("User Created Successfully, Password: " . $request->get('password'))->important();
        return redirect()->route('users');
    }

    public function setPermissions($request, $user)
    {
        $otP = generateOTP(4);
        if ($request->get('type') == 'user') {
            $user->update([
                'user' => TRUE,
                'admin' => FALSE,
                'marketer' => FALSE,
                'driver' => FALSE,
                'validated' => TRUE,
                'otp' => $otP
            ]);
        }
        if ($request->get('type') == 'production') {
            $user->update([
                'user' => false,
                'admin' => true,
                'production' => true,
                'marketer' => FALSE,
                'driver' => FALSE,
                'validated' => TRUE,
                'otp' => $otP
            ]);
        }
        if ($request->get('type') == 'accountant') {
            $user->update([
                'user' => false,
                'accountant' => true,
                'admin' => true,
                'marketer' => FALSE,
                'driver' => FALSE,
                'validated' => TRUE,
                'otp' => $otP
            ]);
        }
        if ($request->get('type') == 'driver') {
            $user->update(['driver' => TRUE,
                'user' => FALSE,
                'admin' => FALSE,
                'marketer' => FALSE,
                'validated' => TRUE,
                'otp' => $otP]);
        }

        if ($request->get('type') == 'admin') {
            $user->update([
                'admin' => TRUE,
                'driver' => TRUE,
                'user' => TRUE,
                'marketer' => TRUE,
                'validated' => TRUE,
                'otp' => $otP]);
        }

        if ($request->get('type') == 'marketer') {
            $user->update(['marketer' => TRUE,
                'user' => FALSE,
                'admin' => FALSE,
                'driver' => FALSE,
                'validated' => TRUE,
                'otp' => $otP]);
        }
    }

    public function marketers()
    {
        $users = User::where('marketer', TRUE)->paginate(10);
        $message = "Marketers";
        return view('admin.users', compact('users', 'message'));
    }

    public function users()
    {
        $users = User::where('user', TRUE)->get();
        $message = "Customers";
        return view('admin.users', compact('users', 'message'));
    }

    public function drivers()
    {
        $users = User::where('driver', TRUE)->paginate(10);
        $message = 'Drivers';
        return view('admin.users', compact('users', 'message'));
    }

    public function production()
    {
        $users = User::where('admin', TRUE)->where('production', true)->where('accountant', false)->get();
        $message = "Production Manager(s)";
        return view('admin.users', compact('users', 'message'));
    }
    public function accountant()
    {
        $users = User::where('admin', TRUE)->where('production', false)->where('accountant', true)->get();
        $message = "Accountants";
        return view('admin.users', compact('users', 'message'));
    }

    public function admin()
    {
        $users = User::where('admin', TRUE)->where('production', false)->where('accountant', false)->get();
        $message = "Administrators";
        return view('admin.users', compact('users', 'message'));
    }

    public function generateAvatar($user)
    {
        $path = '/users/avatar/' . uniqid() . '.png';
        $avatar = new Avatar();
        $avatar->create($user->name)->save(public_path() . $path);

        $user->update(['avatar' => $path,]);
        return TRUE;
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.edit-user', compact('user'));
    }

    public function editUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->update(['name' => $request->get('name'), 'phone' => $request->get('phone'),]);
        $this->setPermissions($request, $user);
        $this->generateAvatar($user);
        flash("User Details Updated successfully")->important();
        return redirect()->route('users');
    }

    public function profile($id)
    {
        $user = User::find($id);
        return view('admin.profile', compact('user'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/');
    }

    public function user($id)
    {
        $user = User::find($id);
        if ($user == NULL) {
            flash("User not found")->important()->warning();
            return redirect()->back();
        }
        if ($user->admin) {
            return view('user.admin', compact('user'));
        }
        if ($user->user) {
            return view('user.user', compact('user'));
        }

        if ($user->driver) {
            $assigned = Assigned::where('driver_id', $user->id)->get();
            return view('user.driver', compact('user', 'assigned'));
        }

        if ($user->marketer) {
            $accounts = User::where('created_by', $user->id)->orderBy('id', 'desc')->get();
            return view('user.marketer', compact('user', 'accounts'));
        }

        flash("User has no roles")->important()->warning();
        return redirect()->back();
    }
}
