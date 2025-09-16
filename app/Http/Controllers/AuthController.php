<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //  public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6|confirmed',
    //         'role' => 'required|in:admin,developer,user',
    //     ]);

    //     $validated['password'] = bcrypt($validated['password']);

    //     $user = User::create($validated);
    //     if (!$user) {
    //         return redirect('/register')->with(['email' => 'Registration failed']);
    //     }else{
    //         return redirect('/login')->with('success', 'Registration successful. Please login.');
    //     }

    //     // return redirect($this->redirectByRole($user->role));
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'role' => 'required|in:admin,developer,user',
    //     ]);

    //     if (Auth::attempt([
    //         'email' => $request->email,
    //         'password' => $request->password,
    //         'role' => $request->role
    //     ])) {
    //         $request->session()->regenerate();
    //         return redirect()->to($this->redirectByRole($request->role));
    //     }
    //     // if ($request->role === 'developer') {
    //     //     return redirect()->route('developer.dashboard');
    //     // }

    //     return back()->withErrors(['email' => 'Invalid credentials']);
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/');
    // }

    // private function redirectByRole($role)
    // {
    //     return match($role) {
    //         'admin' => route('admin.dashboard'),
    //         'developer' => route('developer.dashboard'),
    //         default => route('user.dashboard'),
    //     };
    // }
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Show signup/registration form
    public function showSignup()
    {
        return view('auth.signup');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,developer,user',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Registration failed.']);
        }

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    // Handle user login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,developer,user',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect user based on role
            return redirect($this->redirectByRole(Auth::user()->role));
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // Role-based redirection helper
    private function redirectByRole($role)
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'developer' => route('developer.dashboard'),
            'user' => route('user.dashboard'),
            default => route('home'),
        };
    }
}
