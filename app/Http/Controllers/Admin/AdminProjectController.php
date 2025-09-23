<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['manager', 'creator','users'])->orderByDesc('created_at')->paginate(12);

        return view('admin.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planned,active,completed,on-hold',
            'priority' => 'required|in:low,medium,high',
            'progress' => 'nullable|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $validated['created_by'] = Auth::id();

        Project::create($validated);

        return back()->with('status', 'Project created');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planned,active,completed,on-hold',
            'priority' => 'required|in:low,medium,high',
            'progress' => 'nullable|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $project->update($validated);

        return back()->with('status', 'Project updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('status', 'Project deleted');
    }

    public function assign(Project $project, Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required','exists:users,id'],
        ]);
        $project->users()->syncWithoutDetaching([$data['user_id']]);

        return back()->with('status', 'Developer assigned');
    }

    public function unassign(Project $project, Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required','exists:users,id'],
        ]);
        $project->users()->detach($data['user_id']);

        return back()->with('status', 'Developer unassigned');
    }
}
