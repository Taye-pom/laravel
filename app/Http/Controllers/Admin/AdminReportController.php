<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;

class AdminReportController extends Controller
{
    public function index()
    {
        $byRole = [
            'admin' => User::where('role','admin')->count(),
            'developer' => User::where('role','developer')->count(),
            'project_manager' => User::where('role','project_manager')->count(),
            'user' => User::where('role','user')->count(),
        ];

        $byProjectStatus = [
            'planned' => Project::where('status','planned')->count(),
            'active' => Project::where('status','active')->count(),
            'completed' => Project::where('status','completed')->count(),
            'on_hold' => Project::where('status','on-hold')->count(),
        ];

        $totals = [
            'users' => array_sum($byRole),
            'projects' => array_sum($byProjectStatus),
        ];

        return view('admin.reports.index', compact('byRole','byProjectStatus','totals'));
    }
}


