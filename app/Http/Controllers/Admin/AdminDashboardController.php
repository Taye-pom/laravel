<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(10);

        $stats = [
            'totalUsers' => User::count(),
            'totalDevelopers' => User::where('role', 'developer')->count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalProjectManagers' => User::where('role', 'project_manager')->count(),
        ];

        return view('admin.dashboard', compact('users', 'stats'));
    }
}


