<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $validated = $request->validateWithBag('register', [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,developer,user,project_manager',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        if ($user && $user->role === 'developer') {
            Developer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'title' => null,
                    'experience_level' => 'Junior',
                    'skills' => null,
                    'bio' => null,
                    'rating' => 0.0,
                    'active_tasks' => 0,
                    'completed_projects' => 0,
                    'hours_logged' => 0,
                ]
            );
        }

        if (! $user) {
            return redirect()->back()->withErrors(['email' => 'Registration failed.'])->withInput();
        }

        return redirect()->route('home')->with('auth_success', 'Registration successful. Please login.');
    }

    // Handle user login
    public function login(Request $request)
    {
        $credentials = $request->validateWithBag('login', [
            'email' => 'required|email',
            'password' => 'required',
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
            'project_manager' => route('project_manager.dashboard'),
            default => route('home'),
        };
    }
}
