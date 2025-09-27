<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedTo', 'creator']);

        // Filter by project if specified
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by status if specified
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user if specified
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by priority if specified
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);

            $tasks = Task::with(['project', 'assignee']) // relations pour éviter N+1
        ->orderBy('created_at', 'desc')
        ->get();

        $todo       = $tasks->where('status', 'todo');
        $inProgress = $tasks->where('status', 'in_progress');
        $done       = $tasks->where('status', 'done');

        return view('project_manager.dashboard', compact('todo', 'inProgress', 'done'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            $validated = $request->validate([
                'title'           => 'required|string|max:255',
                'description'     => 'nullable|string',
                'project_id'      => 'required|exists:projects,id',
                'assigned_to'     => 'nullable|exists:users,id',
                'priority'        => 'required|in:low,medium,high,urgent',
                'due_date'        => 'nullable|date|after:today',
                'estimated_hours' => 'nullable|integer|min:1',
                'notes'           => 'nullable|string',
            ]);

            $validated['created_by'] = Auth::id();
            $validated['status']     = 'todo';

            $task = Task::create($validated);
            return redirect()->route('project_manager.dashboard', compact('task'))->with('success', 'Tâche créée avec succès');
    }
        public function dashboard()
    {
        $tasks = Task::with(['project', 'assignee']) // relations pour éviter N+1
            ->orderBy('created_at', 'desc')
            ->get();

        $todo       = $tasks->where('status', 'todo');
        $inProgress = $tasks->where('status', 'in_progress');
        $completed   = $tasks->where('status', 'completed');

        return view('project_manager.dashboard', compact('todo', 'inProgress', 'completed'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'assignedTo', 'creator']);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:todo,in_progress,review,completed,cancelled',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|integer|min:1',
            'actual_hours' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tâche mise à jour avec succès',
            'task' => $task->load(['project', 'assignedTo', 'creator'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tâche supprimée avec succès'
        ]);
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,review,completed,cancelled'
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Statut de la tâche mis à jour',
            'task' => $task->load(['project', 'assignedTo', 'creator'])
        ]);
    }

    /**
     * Assign task to user
     */
    public function assign(Request $request, Task $task)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tâche assignée avec succès',
            'task' => $task->load(['project', 'assignedTo', 'creator'])
        ]);
    }

    /**
     * Get tasks for a specific project
     */
    public function projectTasks(Project $project)
    {
        $tasks = $project->tasks()
            ->with(['assignedTo', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tasks);
    }

    /**
     * Get user's assigned tasks
     */
    public function myTasks()
    {
        $tasks = Auth::user()->assignedTasks()
            ->with(['project', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tasks);
    }
}
