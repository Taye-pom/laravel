<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ControllerUsignup extends Controller
{
     public function showSignupForm()
    {
        return view('auth.Signup');
    }
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,project_manager,developer',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        if ($user->save()) {
            return redirect('/login')->with('success', 'Registration successful. Please login.');
        } else {
            return redirect('/register')->withErrors(['email' => 'Registration failed']);
        }
        auth()->login($user);
        return redirect()->route('dashboard');
    }
}
