<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developers - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Developers</h1>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Experience</th>
                                <th>Skills</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($developers as $dev)
                                <tr>
                                    <td>{{ $dev->id }}</td>
                                    <td>{{ $dev->user?->name ?? '-' }}</td>
                                    <td>{{ $dev->title ?? '-' }}</td>
                                    <td>{{ $dev->experience_level }}</td>
                                    <td>{{ $dev->skills }}</td>
                                    <td>{{ number_format((float)$dev->rating, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No developers</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $developers->links() }}
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>


