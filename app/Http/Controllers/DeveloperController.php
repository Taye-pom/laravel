<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class DeveloperController extends Controller
{
    // Route-level middleware is applied in routes/web.php

    // Show Dashboard
    public function index()
    {
        $user = Auth::user();
        $developer = Developer::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'title' => 'Developer',
                'experience_level' => 'Junior',
                'skills' => '',
                'bio' => '',
                'rating' => 0.0,
                'active_tasks' => 0,
                'completed_projects' => 0,
                'hours_logged' => 0,
            ]
        );
        // dd('Developer dashboard accessed'); // This will show if the method is reached

        //  $user = Auth::user();
        $projects = $user->projects()->where('status','!=','completed')->orderByDesc('created_at')->limit(10)->get();
        
        // Get assigned tasks
        $assignedTasks = $user->assignedTasks()
            ->with(['project', 'creator'])
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        // Get task statistics
        $taskStats = [
            'total' => $user->assignedTasks()->count(),
            'completed' => $user->assignedTasks()->where('status', 'completed')->count(),
            'in_progress' => $user->assignedTasks()->where('status', 'in_progress')->count(),
            'todo' => $user->assignedTasks()->where('status', 'todo')->count(),
            'overdue' => $user->assignedTasks()
                ->where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
        ];

        return view('developer.dashboard', compact('developer', 'projects', 'assignedTasks', 'taskStats'));
    }

    // Update Developer Profile
    public function update(Request $request)
    {
        $request->validate([
            'skills' => 'nullable|string|max:255',

        ]);

        $developer = Developer::where('user_id', Auth::id())->first();
        $developer->update([
            'skills' => $request->skills,

        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
