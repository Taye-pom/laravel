<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDeveloperController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\TaskController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

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
// Logout route is handled by Livewire in routes/auth.php

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
    Route::get('/admin/projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::post('/admin/projects', [AdminProjectController::class, 'store'])->name('admin.projects.store');
    Route::put('/admin/projects/{project}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');
    Route::post('/admin/projects/{project}/assign', [AdminProjectController::class, 'assign'])->name('admin.projects.assign');
    Route::post('/admin/projects/{project}/unassign', [AdminProjectController::class, 'unassign'])->name('admin.projects.unassign');
    Route::get('/admin/developers', [AdminDeveloperController::class, 'index'])->name('admin.developers.index');
    Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
});

// Developer Dashboard
Route::middleware(['auth', 'role:developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [DeveloperController::class, 'index'])->name('developer.dashboard');
    Route::put('/profile', [DeveloperController::class, 'update'])->name('developer.update');
    Route::get('/tasks', \App\Livewire\TaskManagement::class)->name('developer.tasks');
    Route::get('/profile', \App\Livewire\DeveloperProfile::class)->name('developer.profile');
    Route::get('/time-tracking', \App\Livewire\TimeTracking::class)->name('developer.time-tracking');
    Route::get('/reports', \App\Livewire\Reports::class)->name('developer.reports');
});

// Project manager Dashboard
Route::middleware(['auth', 'role:project_manager'])->get('/project_manager/dashboard', [ProjectManagerController::class, 'index'])->name('project_manager.dashboard');

// User Dashboard (basic placeholder)
Route::middleware(['auth', 'role:user'])->get('/user/dashboard', function () {
    return view('dashboard');
})->name('user.dashboard');

// Task Management Routes
Route::middleware(['auth'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::patch('/tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
    Route::get('/projects/{project}/tasks', [TaskController::class, 'projectTasks'])->name('projects.tasks');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');
    Route::get('/notifications', \App\Livewire\Notifications::class)->name('notifications');
});

require __DIR__.'/auth.php';
