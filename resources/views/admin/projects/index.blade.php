<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Projects</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">Create Project</div>
            <div class="card-body">
                <form action="{{ route('admin.projects.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" name="progress" class="form-control" min="0" max="100" value="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="planned">Planned</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="on-hold">On hold</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Manager</label>
                        <select name="manager_id" class="form-select">
                            <option value="">-- none --</option>
                            @foreach(\App\Models\User::where('role','project_manager')->orderBy('name')->get(['id','name']) as $m)
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary">Create</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">All Projects</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Manager</th>
                                <th>Progress</th>
                                <th>Dates</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ ucfirst($project->status) }}</td>
                                <td>{{ ucfirst($project->priority) }}</td>
                                <td>{{ $project->manager?->name ?? '-' }}</td>
                                <td>
                                    <small>
                                        {{ optional($project->start_date)->format('Y-m-d') }} → {{ optional($project->end_date)->format('Y-m-d') }}
                                    </small>
                                </td>
                                <td style="min-width:140px;">
                                    <div class="progress" style="height:8px;">
                                        <div class="progress-bar" style="width: {{ (int)($project->progress ?? 0) }}%"></div>
                                    </div>
                                    <small>{{ (int)($project->progress ?? 0) }}%</small>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.projects.assign', $project) }}" method="POST" class="d-inline">
                                        @csrf
                                        <div class="input-group input-group-sm" style="max-width: 280px;">
                                            <select name="user_id" class="form-select">
                                                <option value="">Assign developer...</option>
                                                @foreach(\App\Models\User::where('role','developer')->orderBy('name')->get(['id','name']) as $dev)
                                                    <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-primary">Assign</button>
                                        </div>
                                    </form>
                                    @if($project->users?->count())
                                        <div class="mt-2">
                                            @foreach($project->users as $u)
                                                <form action="{{ route('admin.projects.unassign', $project) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $u->id }}">
                                                    <span class="badge bg-secondary">{{ $u->name }}</span>
                                                    <button class="btn btn-sm btn-link text-danger">remove</button>
                                                </form>
                                            @endforeach
                                        </div>
                                    @endif
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted">No projects</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $projects->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>


