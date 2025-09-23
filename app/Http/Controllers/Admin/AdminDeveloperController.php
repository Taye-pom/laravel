<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;

class AdminDeveloperController extends Controller
{
    public function index()
    {
        $developers = Developer::with('user')->orderByDesc('created_at')->paginate(20);

        return view('admin.developers.index', compact('developers'));
    }
}
