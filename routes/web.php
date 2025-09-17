<?php

use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;

// Home page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.redirect');
    }
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
        default:
            return redirect()->route('home');
    }
})->name('dashboard.redirect');

// Admin Dashboard
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Developer Dashboard
Route::middleware(['auth', 'role:developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [DeveloperController::class, 'index'])->name('developer.dashboard');
    Route::put('/profile', [DeveloperController::class, 'update'])->name('developer.update');
});

// Project manager Dashboard (placeholder for now)
Route::middleware(['auth', 'role:project_manager'])->get('/project_manager/dashboard', function () {
    return view('project_manager.dashboard');
})->name('project_manager.dashboard');

require __DIR__.'/auth.php';
