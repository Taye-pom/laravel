<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerProject extends Controller
{
//     public function store(Request $request)
// {
//     $validated = $request->validate([
//         'name' => 'required|string|max:255',
//         'priority' => 'required|in:high,medium,low',
//         'description' => 'nullable|string',
//         'start_date' => 'nullable|date',
//         'end_date' => 'nullable|date|after_or_equal:start_date',
//         'users' => 'array',
//         'invite_emails' => 'nullable|string',
//         'budget' => 'nullable|numeric',
//     ]);

//     $project = Project::create([
//         'name' => $validated['name'],
//         'priority' => $validated['priority'],
//         'description' => $validated['description'] ?? null,
//         'start_date' => $validated['start_date'] ?? null,
//         'end_date' => $validated['end_date'] ?? null,
//         'manager_id' => auth()->id(), // assuming manager is logged in
//         'created_by' => auth()->id(),
//         'budget' => $validated['budget'] ?? null,
//     ]);

//     // Attach existing developers
//     if (!empty($validated['users'])) {
//         $project->users()->attach($validated['users']);
//     }

//     // Handle invitations
//     if (!empty($validated['invite_emails'])) {
//         $emails = array_map('trim', explode(',', $validated['invite_emails']));
//         foreach ($emails as $email) {
//             // Send invitation with unique token
//             $token = Str::uuid();
//             \DB::table('project_invitations')->insert([
//                 'project_id' => $project->id,
//                 'email' => $email,
//                 'token' => $token,
//                 'created_at' => now(),
//             ]);

//             // Send email (Mailable)
//             Mail::to($email)->send(new ProjectInvitationMail($project, $token));
//         }
//     }

//     return redirect()->route('projects.index')->with('success', 'Project created successfully!');
// }
}
