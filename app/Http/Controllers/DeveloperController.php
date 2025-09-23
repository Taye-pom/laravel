<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class DeveloperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:developer']);
    }

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
        $projects = Project::where('status','!=','completed')->orderByDesc('created_at')->limit(10)->get();

        return view('developer.dashboard', compact('developer','projects'));
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
