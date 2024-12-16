<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home'); // or wherever you want to redirect
        }
    
        return view('layouts.admin.login');
    }
    
    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);


        // Attempt to authenticate the user
        $user = User::where('name', $request->name)
            ->where('phone_number', $request->phone_number)
            ->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return $user->role === 'admin'
                    ? redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!')
                    : redirect()->route('user.dashboard')->with('success', 'Welcome, User!');
            } else {
                return back()->withErrors(['password' => 'Incorrect password.']);
            }
        }

        return back()->withErrors(['login' => 'User not found.']);
    }

    /**
     * Handle logout request.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
