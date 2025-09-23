<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectManagerController extends Controller
{
    // Route-level middleware is applied in routes/web.php

    public function index()
    {
        $projects = Project::with('manager')
            ->where('manager_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('project_manager.dashboard', compact('projects'));
    }
}


