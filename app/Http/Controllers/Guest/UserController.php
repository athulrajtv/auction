<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Login()
    {
        return view('guest.login.userloginpage');
    }

    public function Register()
    {
        return view('guest.login.userregister');
    }

    public function post_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Ensure email is unique 
            'phone' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'user_type' => $request->user_type,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with('success', 'Registration Successfully');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return redirect(route('guest.login'))->with('success', 'Successfully logged out');
    }
}
