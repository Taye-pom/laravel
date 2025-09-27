<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\ProjectInvitationMail;
use Illuminate\Support\Facades\Mail;
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

             $developers = User::where('role', 'developer')->get();

        $tasks = Task::orderBy('created_at', 'desc')->paginate(15);

            $tasks = Task::with(['project', 'assignedTo']) // relations pour éviter N+1
        ->orderBy('created_at', 'desc')
        ->get();

        $todo       = $tasks->where('status', 'todo');
        $inProgress = $tasks->where('status', 'in_progress');
        $completed   = $tasks->where('status', 'completed');

        return view('project_manager.dashboard', compact('projects', 'developers', 'todo', 'inProgress', 'completed'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'priority' => 'required|in:high,medium,low',
        'description' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'users' => 'array',
        'invite_emails' => 'nullable|string',
        'budget' => 'nullable|numeric',
    ]);

    $project = Project::create([
        'name' => $validated['name'],
        'priority' => $validated['priority'],
        'description' => $validated['description'] ?? null,
        'start_date' => $validated['start_date'] ?? null,
        'end_date' => $validated['end_date'] ?? null,
        'manager_id' => auth()->id(), // assuming manager is logged in
        'created_by' => auth()->id(),
        'budget' => $validated['budget'] ?? null,
    ]);

    // Attach existing developers
    if (!empty($validated['users'])) {
        $project->users()->attach($validated['users']);
    }

    // Handle invitations
    if (!empty($validated['invite_emails'])) {
        $emails = array_map('trim', explode(',', $validated['invite_emails']));
        foreach ($emails as $email) {
            // Send invitation with unique token
            $token = Str::uuid();
            \DB::table('project_invitations')->insert([
                'project_id' => $project->id,
                'email' => $email,
                'token' => $token,
                'created_at' => now(),
            ]);

            // Send email (Mailable)
            // Mail::to($email)->send(new ProjectInvitationMail($project, $token));
        }
    }
    return redirect()->route('project_manager.dashboard')->with('success', 'Project created successfully!');
}

}


