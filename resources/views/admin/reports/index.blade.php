<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Reports & Analytics</h1>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="display-6">{{ $totals['users'] }}</div>
                        <div class="text-muted">Total Users</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="display-6">{{ $byRole['developer'] }}</div>
                        <div class="text-muted">Developers</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="display-6">{{ $byRole['project_manager'] }}</div>
                        <div class="text-muted">Project Managers</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="display-6">{{ $byRole['admin'] }}</div>
                        <div class="text-muted">Admins</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Projects by Status</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Planned <span class="badge bg-secondary">{{ $byProjectStatus['planned'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Active <span class="badge bg-primary">{{ $byProjectStatus['active'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Completed <span class="badge bg-success">{{ $byProjectStatus['completed'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        On Hold <span class="badge bg-warning text-dark">{{ $byProjectStatus['on_hold'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back</a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>


