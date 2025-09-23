<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:project_manager']);
    }

    public function index()
    {
        $projects = Project::with('manager')
            ->where('manager_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('project_manager.dashboard', compact('projects'));
    }
}


