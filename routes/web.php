<?php

use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;

// Home page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

// Authentication Routes (avoid conflicting with Livewire routes defined in auth.php)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.fallback');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout.controller');

// Settings Routes (authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Role-based dashboard redirection helper
Route::middleware(['auth'])->get('/dashboard', function () {
    $role = auth()->user()->role;
    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'developer':
            return redirect()->route('developer.dashboard');
        case 'user':
            return redirect()->route('user.dashboard');
        case 'project_manager':
            return redirect()->route('project_manager.dashboard');
        default:
            return redirect()->route('home');
    }
})->name('dashboard');

// Admin Dashboard + Users
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.role');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

// Developer Dashboard
Route::middleware(['auth', 'role:developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [DeveloperController::class, 'index'])->name('developer.dashboard');
    Route::put('/profile', [DeveloperController::class, 'update'])->name('developer.update');
});

// Project manager Dashboard (placeholder for now)
Route::middleware(['auth', 'role:project_manager'])->get('/project_manager/dashboard', function () {
    return view('project_manager.dashboard');
})->name('project_manager.dashboard');

// User Dashboard (basic placeholder)
Route::middleware(['auth', 'role:user'])->get('/user/dashboard', function () {
    return view('dashboard');
})->name('user.dashboard');

require __DIR__.'/auth.php';
