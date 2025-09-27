<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(10);
        $projects = Project::orderByDesc('created_at')->paginate(10);

        $stats = [
            'totalUsers' => User::count(),
            'totalDevelopers' => User::where('role', 'developer')->count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalProjectManagers' => User::where('role', 'project_manager')->count(),
            'activeProjects' => Project::where('status', 'planned')->count(),
            'completedTasks' => Task::where('status', 'completed')->count(),
        ];

        $managers = User::where('role', 'project_manager')->orderBy('name')->get(['id', 'name']);

        return view('admin.dashboard', compact('users', 'stats', 'managers', 'projects'));
    }
}
