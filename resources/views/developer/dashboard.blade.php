<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Dashboard - DevCollab</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-yellow: #ffc107;
            --dark-yellow: #ffb300;
            --light-yellow: #fff3cd;
            --text-dark: #212529;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--dark-yellow) 100%);
            box-shadow: 0 4px 20px rgba(255, 193, 7, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark) !important;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }

        .sidebar {
            background: linear-gradient(180deg, #fff 0%, #f8f9fa 100%);
            border-right: 3px solid var(--primary-yellow);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 76px);
            position: sticky;
            top: 76px;
        }

        .sidebar-item {
            padding: 15px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-item:hover {
            background: var(--light-yellow);
            border-left-color: var(--primary-yellow);
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background: var(--light-yellow);
            border-left-color: var(--primary-yellow);
            font-weight: 600;
        }

        .sidebar-item i {
            width: 20px;
            color: var(--dark-yellow);
        }

        .main-content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--dark-yellow) 100%);
            color: var(--text-dark);
            font-weight: 600;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--dark-yellow) 100%);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--dark-yellow) 100%);
            color: var(--text-dark);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .progress-custom {
            height: 10px;
            border-radius: 10px;
            background: #e9ecef;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary-yellow) 0%, var(--dark-yellow) 100%);
            border-radius: 10px;
        }

        .task-item {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid var(--primary-yellow);
            transition: all 0.3s ease;
        }

        .task-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .badge-priority-high {
            background: #dc3545;
        }

        .badge-priority-medium {
            background: #fd7e14;
        }

        .badge-priority-low {
            background: #28a745;
        }

        .chat-container {
            height: 400px;
            overflow-y: auto;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 80%;
        }

        .message-sent {
            background: var(--primary-yellow);
            margin-left: auto;
            text-align: right;
        }

        .message-received {
            background: #fff;
            margin-right: auto;
        }

        .form-control:focus {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-dark);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                width: 250px;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('developer.dashboard')}}"><i class="fas fa-code"></i> DevCollab</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#dashboard" onclick="showSection('dashboard')">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects" onclick="showSection('projects')">
                            <i class="fas fa-project-diagram"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tasks" onclick="showSection('tasks')">
                            <i class="fas fa-tasks"></i> Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#chat" onclick="showSection('chat')">
                            <i class="fas fa-comments"></i> Chat
                            <span class="notification-badge">3</span>
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="avatar">JD</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#profile" onclick="showSection('profile')">
                                <i class="fas fa-user"></i> Profile
                            </a></li>
                            <li><a class="dropdown-item" href="#settings" onclick="showSection('settings')">
                                <i class="fas fa-cog"></i> Settings
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 p-0">
                <div class="sidebar">
                    <div class="sidebar-item active" onclick="showSection('dashboard')">
                        <i class="fas fa-home"></i>
                        <span>Overview</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('projects')">
                        <i class="fas fa-folder-open"></i>
                        <span>My Projects</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('tasks')">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Task Management</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('chat')">
                        <i class="fas fa-message"></i>
                        <span>Team Chat</span>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('codeReview')">
                        <i class="fas fa-code-branch"></i>
                        <span>Code Reviews</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('timeTracking')">
                        <i class="fas fa-clock"></i>
                        <span>Time Tracking</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('reports')">
                        <i class="fas fa-chart-line"></i>
                        <span>Reports</span>
                    </div>
                    <div class="sidebar-item" onclick="showSection('profile')">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <div class="main-content">
                    <!-- Dashboard Section -->
                    <div id="dashboard" class="section active">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Developer Dashboard</h2>
                                <p class="text-muted">Welcome back, John Doe! Here's your development overview.</p>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number">8</div>
                                    <div>Active Tasks</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number">3</div>
                                    <div>Projects</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number">12</div>
                                    <div>Completed</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stats-card">
                                    <div class="stats-number">85%</div>
                                    <div>Efficiency</div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Tasks and Progress -->
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-tasks"></i> Recent Tasks</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="task-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Implement User Authentication</h6>
                                                    <small class="text-muted">E-Commerce Platform</small>
                                                </div>
                                                <span class="badge badge-priority-high">High</span>
                                            </div>
                                            <div class="progress-custom mt-2">
                                                <div class="progress-bar" style="width: 75%"></div>
                                            </div>
                                            <small class="text-muted">Due: Tomorrow</small>
                                        </div>

                                        <div class="task-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Fix Payment Gateway Bug</h6>
                                                    <small class="text-muted">Mobile App</small>
                                                </div>
                                                <span class="badge badge-priority-medium">Medium</span>
                                            </div>
                                            <div class="progress-custom mt-2">
                                                <div class="progress-bar" style="width: 45%"></div>
                                            </div>
                                            <small class="text-muted">Due: Friday</small>
                                        </div>

                                        <div class="task-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Update Documentation</h6>
                                                    <small class="text-muted">API Project</small>
                                                </div>
                                                <span class="badge badge-priority-low">Low</span>
                                            </div>
                                            <div class="progress-custom mt-2">
                                                <div class="progress-bar" style="width: 20%"></div>
                                            </div>
                                            <small class="text-muted">Due: Next Week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-calendar"></i> This Week</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <small>Tasks Completed</small>
                                                <small>5/8</small>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 62.5%"></div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <small>Code Reviews</small>
                                                <small>3/4</small>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 75%"></div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <small>Hours Logged</small>
                                                <small>32/40</small>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 80%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-bell"></i> Notifications</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 pb-3 border-bottom">
                                            <small class="text-warning fw-bold">New Task Assigned</small>
                                            <p class="mb-1 small">API Integration for Payment Module</p>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                        <div class="mb-3 pb-3 border-bottom">
                                            <small class="text-info fw-bold">Code Review Request</small>
                                            <p class="mb-1 small">Sarah requested review for user-auth branch</p>
                                            <small class="text-muted">4 hours ago</small>
                                        </div>
                                        <div>
                                            <small class="text-success fw-bold">Task Completed</small>
                                            <p class="mb-1 small">Database migration successfully deployed</p>
                                            <small class="text-muted">Yesterday</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Section -->
                    <div id="projects" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-project-diagram"></i> My Projects</h2>
                                <button class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#createProjectModal">
                                    <i class="fas fa-plus"></i> Create New Project
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">E-Commerce Platform</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">Full-stack web application for online shopping</p>
                                        <div class="mb-3">
                                            <small class="text-muted">Progress: 78%</small>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 78%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-primary me-1">React</span>
                                            <span class="badge bg-success me-1">Node.js</span>
                                            <span class="badge bg-info">MongoDB</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Due: Dec 15, 2024</small>
                                            <button class="btn btn-warning btn-sm">View Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Mobile Task Manager</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">Cross-platform mobile app for task management</p>
                                        <div class="mb-3">
                                            <small class="text-muted">Progress: 45%</small>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 45%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-primary me-1">React Native</span>
                                            <span class="badge bg-warning me-1">Firebase</span>
                                            <span class="badge bg-secondary">Redux</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Due: Jan 30, 2025</small>
                                            <button class="btn btn-warning btn-sm">View Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">API Gateway</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">Microservices API gateway with authentication</p>
                                        <div class="mb-3">
                                            <small class="text-muted">Progress: 92%</small>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 92%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-success me-1">Express.js</span>
                                            <span class="badge bg-danger me-1">Redis</span>
                                            <span class="badge bg-dark">Docker</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Due: Oct 25, 2024</small>
                                            <button class="btn btn-warning btn-sm">View Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Section -->
                    <div id="tasks" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-tasks"></i> Task Management</h2>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                            <i class="fas fa-plus"></i> Create Task
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-secondary active" onclick="filterTasks('all')">All</button>
                                            <button class="btn btn-outline-secondary" onclick="filterTasks('todo')">To Do</button>
                                            <button class="btn btn-outline-secondary" onclick="filterTasks('inprogress')">In Progress</button>
                                            <button class="btn btn-outline-secondary" onclick="filterTasks('done')">Done</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search tasks..." id="taskSearch">
                                            <button class="btn btn-warning"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Task</th>
                                                        <th>Project</th>
                                                        <th>Priority</th>
                                                        <th>Status</th>
                                                        <th>Due Date</th>
                                                        <th>Progress</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tasksTableBody">
                                                    <tr>
                                                        <td>
                                                            <h6 class="mb-1">Implement User Authentication</h6>
                                                            <small class="text-muted">Create login/register functionality</small>
                                                        </td>
                                                        <td>E-Commerce Platform</td>
                                                        <td><span class="badge badge-priority-high">High</span></td>
                                                        <td><span class="badge bg-warning">In Progress</span></td>
                                                        <td>Oct 15, 2024</td>
                                                        <td>
                                                            <div class="progress-custom">
                                                                <div class="progress-bar" style="width: 100%"></div>
                                                            </div>
                                                            <small>100%</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button class="btn btn-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-success">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Section -->
                    <div id="chat" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-comments"></i> Team Chat</h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-users"></i> Team Members</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex align-items-center border-0 px-0 chat-contact active" onclick="selectChat('pm')">
                                                <div class="avatar me-3">PM</div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Project Manager</h6>
                                                    <small class="text-success">Online</small>
                                                </div>
                                                <span class="badge bg-danger">2</span>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center border-0 px-0 chat-contact" onclick="selectChat('sarah')">
                                                <div class="avatar me-3">SC</div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Sarah Chen</h6>
                                                    <small class="text-success">Online</small>
                                                </div>
                                                <span class="badge bg-danger">1</span>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center border-0 px-0 chat-contact" onclick="selectChat('mike')">
                                                <div class="avatar me-3">MR</div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Mike Rodriguez</h6>
                                                    <small class="text-muted">Away</small>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center border-0 px-0 chat-contact" onclick="selectChat('team')">
                                                <div class="avatar me-3"><i class="fas fa-users"></i></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Team Channel</h6>
                                                    <small class="text-muted">5 members</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <div class="avatar me-3">PM</div>
                                        <div>
                                            <h5 class="mb-0">Project Manager</h5>
                                            <small class="text-success">Online</small>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chat-container">
                                            <div class="message message-received">
                                                <small class="text-muted">Project Manager - 10:30 AM</small>
                                                <p class="mb-0">Hi John! How's the user authentication feature coming along?</p>
                                            </div>
                                            <div class="message message-sent">
                                                <small class="text-muted">You - 10:32 AM</small>
                                                <p class="mb-0">It's going well! I'm about 75% done. Should have it ready by tomorrow.</p>
                                            </div>
                                            <div class="message message-received">
                                                <small class="text-muted">Project Manager - 10:35 AM</small>
                                                <p class="mb-0">Great! Don't forget to include the password reset functionality. The client specifically requested it.</p>
                                            </div>
                                            <div class="message message-sent">
                                                <small class="text-muted">You - 10:37 AM</small>
                                                <p class="mb-0">Already on it! I'm implementing email verification and password reset with JWT tokens.</p>
                                            </div>
                                            <div class="message message-received">
                                                <small class="text-muted">Project Manager - 11:15 AM</small>
                                                <p class="mb-0">Perfect! Also, we need to schedule a code review session for Friday. Are you available at 2 PM?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <form id="chatForm">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Type your message..." id="messageInput">
                                                <button class="btn btn-warning" type="submit">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Code Review Section -->
                    <div id="codeReview" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-code-branch"></i> Code Reviews</h2>
                                <button class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#requestReviewModal">
                                    <i class="fas fa-plus"></i> Request Review
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-eye"></i> Pending Reviews</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">User Authentication Module</h6>
                                                    <small class="text-muted">Branch: feature/user-auth</small><br>
                                                    <small class="text-muted">Requested by: Sarah Chen</small>
                                                </div>
                                                <span class="badge bg-warning">Pending</span>
                                            </div>
                                            <div class="mt-2">
                                                <button class="btn btn-warning btn-sm me-2">Review Code</button>
                                                <button class="btn btn-outline-secondary btn-sm">View Diff</button>
                                            </div>
                                        </div>

                                        <div class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Payment Gateway Integration</h6>
                                                    <small class="text-muted">Branch: feature/payment</small><br>
                                                    <small class="text-muted">Requested by: Mike Rodriguez</small>
                                                </div>
                                                <span class="badge bg-warning">Pending</span>
                                            </div>
                                            <div class="mt-2">
                                                <button class="btn btn-warning btn-sm me-2">Review Code</button>
                                                <button class="btn btn-outline-secondary btn-sm">View Diff</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-history"></i> My Reviews</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">Database Schema Update</h6>
                                                    <small class="text-muted">Branch: feature/db-update</small><br>
                                                    <small class="text-muted">Reviewed by: Project Manager</small>
                                                </div>
                                                <span class="badge bg-success">Approved</span>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-success"><i class="fas fa-check"></i> Approved 2 days ago</small>
                                            </div>
                                        </div>

                                        <div class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">API Response Optimization</h6>
                                                    <small class="text-muted">Branch: optimize/api-response</small><br>
                                                    <small class="text-muted">Reviewed by: Sarah Chen</small>
                                                </div>
                                                <span class="badge bg-info">In Review</span>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-info"><i class="fas fa-clock"></i> Waiting for feedback</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Tracking Section -->
                    <div id="timeTracking" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-clock"></i> Time Tracking</h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-play"></i> Time Logger</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="timeTrackingForm">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Project</label>
                                                    <select class="form-select" required>
                                                        <option value="">Select Project</option>
                                                        <option value="ecommerce">E-Commerce Platform</option>
                                                        <option value="mobile">Mobile Task Manager</option>
                                                        <option value="api">API Gateway</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Task</label>
                                                    <input type="text" class="form-control" placeholder="What are you working on?" required>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Start Time</label>
                                                    <input type="time" class="form-control" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">End Time</label>
                                                    <input type="time" class="form-control" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Date</label>
                                                    <input type="date" class="form-control" value="2024-10-12" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" rows="3" placeholder="Describe what you worked on..."></textarea>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-save"></i> Log Time
                                                </button>
                                                <button type="button" class="btn btn-success" id="startTimer">
                                                    <i class="fas fa-play"></i> Start Timer
                                                </button>
                                                <button type="button" class="btn btn-danger" id="stopTimer" style="display: none;">
                                                    <i class="fas fa-stop"></i> Stop Timer
                                                </button>
                                            </div>
                                            
                                            <div class="mt-3" id="timerDisplay" style="display: none;">
                                                <h4 class="text-warning">Timer: <span id="timerTime">00:00:00</span></h4>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-history"></i> Recent Time Entries</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Project</th>
                                                        <th>Task</th>
                                                        <th>Duration</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Oct 12, 2024</td>
                                                        <td>E-Commerce Platform</td>
                                                        <td>User Authentication</td>
                                                        <td>3h 45m</td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Oct 11, 2024</td>
                                                        <td>API Gateway</td>
                                                        <td>Database Optimization</td>
                                                        <td>2h 30m</td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Oct 10, 2024</td>
                                                        <td>Mobile Task Manager</td>
                                                        <td>UI Components</td>
                                                        <td>4h 15m</td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-chart-pie"></i> This Week Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Total Hours</span>
                                                <span class="fw-bold">32h 15m</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>E-Commerce Platform</span>
                                                <span>18h 30m</span>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 57%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Mobile Task Manager</span>
                                                <span>8h 45m</span>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 27%"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>API Gateway</span>
                                                <span>5h 00m</span>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 16%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-target"></i> Weekly Goals</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Target: 40 hours</span>
                                                <span>32h / 40h</span>
                                            </div>
                                            <div class="progress-custom">
                                                <div class="progress-bar" style="width: 80%"></div>
                                            </div>
                                        </div>
                                        <p class="text-muted small">You're 8 hours away from your weekly goal. Keep going!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Section -->
                    <div id="reports" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-chart-line"></i> Reports & Analytics</h2>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-tasks fa-2x text-warning mb-2"></i>
                                        <h3 class="fw-bold">24</h3>
                                        <small class="text-muted">Tasks This Month</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                        <h3 class="fw-bold">128h</h3>
                                        <small class="text-muted">Hours This Month</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-code-branch fa-2x text-warning mb-2"></i>
                                        <h3 class="fw-bold">12</h3>
                                        <small class="text-muted">Code Reviews</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-trophy fa-2x text-warning mb-2"></i>
                                        <h3 class="fw-bold">92%</h3>
                                        <small class="text-muted">Completion Rate</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-chart-area"></i> Productivity Trends</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="productivityChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-pie-chart"></i> Time Distribution</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="timeDistributionChart" width="200" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-download"></i> Export Reports</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Report Type</label>
                                                <select class="form-select">
                                                    <option>Time Report</option>
                                                    <option>Task Summary</option>
                                                    <option>Project Progress</option>
                                                    <option>Productivity Analysis</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" value="2024-10-01">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control" value="2024-10-12">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <div class="d-grid">
                                                    <button class="btn btn-warning">
                                                        <i class="fas fa-download"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Section -->
                    <div id="profile" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-user"></i> Profile Management</h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <div class="avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2rem;">
                                            JD
                                        </div>
                                        <h4>John Doe</h4>
                                        <p class="text-muted">Full Stack Developer</p>
                                        <button class="btn btn-warning">Change Avatar</button>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-star"></i> Skills</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <span class="badge bg-primary me-1">JavaScript</span>
                                            <span class="badge bg-success me-1">React</span>
                                            <span class="badge bg-info me-1">Node.js</span>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-warning me-1">Python</span>
                                            <span class="badge bg-danger me-1">MongoDB</span>
                                            <span class="badge bg-secondary me-1">AWS</span>
                                        </div>
                                        <div class="mb-3">
                                            <span class="badge bg-dark me-1">Docker</span>
                                            <span class="badge bg-primary me-1">Git</span>
                                            <span class="badge bg-success me-1">REST APIs</span>
                                        </div>
                                        <button class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-plus"></i> Add Skill
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Profile</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="profileForm">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" value="John" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" value="Doe" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="john.doe@company.com" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="tel" class="form-control" value="+1 (555) 123-4567">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Job Title</label>
                                                <input type="text" class="form-control" value="Full Stack Developer" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Department</label>
                                                <select class="form-select" required>
                                                    <option value="development" selected>Development</option>
                                                    <option value="frontend">Frontend</option>
                                                    <option value="backend">Backend</option>
                                                    <option value="mobile">Mobile</option>
                                                    <option value="devops">DevOps</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Bio</label>
                                                <textarea class="form-control" rows="4" placeholder="Tell us about yourself...">Experienced full-stack developer with 5+ years of experience in React, Node.js, and cloud technologies. Passionate about creating efficient and scalable web applications.</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">LinkedIn</label>
                                                    <input type="url" class="form-control" placeholder="https://linkedin.com/in/johndoe">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">GitHub</label>
                                                    <input type="url" class="form-control" placeholder="https://github.com/johndoe">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <h6>Change Password</h6>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <input type="password" class="form-control" placeholder="Current Password">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <input type="password" class="form-control" placeholder="New Password">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <input type="password" class="form-control" placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-save"></i> Save Changes
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary">
                                                    <i class="fas fa-undo"></i> Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div id="settings" class="section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="mb-4"><i class="fas fa-cog"></i> Settings</h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-bell"></i> Notification Preferences</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                            <label class="form-check-label" for="emailNotifications">
                                                Email Notifications
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="taskAssignments" checked>
                                            <label class="form-check-label" for="taskAssignments">
                                                Task Assignments
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="codeReviewRequests" checked>
                                            <label class="form-check-label" for="codeReviewRequests">
                                                Code Review Requests
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="projectUpdates">
                                            <label class="form-check-label" for="projectUpdates">
                                                Project Updates
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="teamMessages" checked>
                                            <label class="form-check-label" for="teamMessages">
                                                Team Messages
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-palette"></i> Appearance</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Theme</label>
                                            <select class="form-select">
                                                <option value="light" selected>Light</option>
                                                <option value="dark">Dark</option>
                                                <option value="auto">Auto</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Sidebar Position</label>
                                            <select class="form-select">
                                                <option value="left" selected>Left</option>
                                                <option value="right">Right</option>
                                            </select>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="compactMode">
                                            <label class="form-check-label" for="compactMode">
                                                Compact Mode
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-shield-alt"></i> Security</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <h6>Two-Factor Authentication</h6>
                                            <p class="text-muted small">Add an extra layer of security to your account</p>
                                            <button class="btn btn-warning">Enable 2FA</button>
                                        </div>

                                        <div class="mb-4">
                                            <h6>Active Sessions</h6>
                                            <div class="border rounded p-3 mb-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>Current Session</strong>
                                                        <br><small class="text-muted">Chrome on Windows • 192.168.1.100</small>
                                                    </div>
                                                    <span class="badge bg-success">Active</span>
                                                </div>
                                            </div>
                                            <div class="border rounded p-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>Mobile Session</strong>
                                                        <br><small class="text-muted">Safari on iPhone • Last seen 2 days ago</small>
                                                    </div>
                                                    <button class="btn btn-outline-danger btn-sm">Revoke</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h6>API Keys</h6>
                                            <p class="text-muted small">Manage your API keys for integrations</p>
                                            <button class="btn btn-outline-warning">Manage API Keys</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-download"></i> Data & Privacy</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h6>Export Data</h6>
                                            <p class="text-muted small">Download a copy of your data</p>
                                            <button class="btn btn-outline-warning">Request Export</button>
                                        </div>

                                        <div class="mb-3">
                                            <h6>Data Retention</h6>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="retainLogs" checked>
                                                <label class="form-check-label" for="retainLogs">
                                                    Keep activity logs for 90 days
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <h6 class="text-danger">Danger Zone</h6>
                                            <button class="btn btn-outline-danger">Delete Account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Create New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Project</label>
                                <select class="form-select" required>
                                    <option value="">Select Project</option>
                                    <option value="ecommerce">E-Commerce Platform</option>
                                    <option value="mobile">Mobile Task Manager</option>
                                    <option value="api">API Gateway</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priority</label>
                                <select class="form-select" required>
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estimated Hours</label>
                                <input type="number" class="form-control" min="1" step="0.5">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createTaskForm" class="btn btn-warning">Create Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" class="form-control" value="Implement User Authentication" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3">Create login/register functionality with JWT authentication</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" required>
                                    <option value="todo">To Do</option>
                                    <option value="inprogress" selected>In Progress</option>
                                    <option value="review">In Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Progress (%)</label>
                                <input type="number" class="form-control" value="75" min="0" max="100">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="2">JWT implementation complete. Working on password reset functionality.</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editTaskForm" class="btn btn-warning">Update Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Code Review Modal -->
    <div class="modal fade" id="requestReviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-code-branch"></i> Request Code Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="requestReviewForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pull Request Title</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <input type="text" class="form-control" placeholder="feature/branch-name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" placeholder="Describe the changes made..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reviewers</label>
                            <select class="form-select" multiple>
                                <option value="pm">Project Manager</option>
                                <option value="sarah">Sarah Chen</option>
                                <option value="mike">Mike Rodriguez</option>
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple reviewers</small>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="urgentReview">
                            <label class="form-check-label" for="urgentReview">
                                Urgent Review Required
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="requestReviewForm" class="btn btn-warning">Request Review</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Create New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createProjectForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Technologies</label>
                            <input type="text" class="form-control" placeholder="React, Node.js, MongoDB">
                            <small class="text-muted">Separate with commas</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Team Members</label>
                            <select class="form-select" multiple>
                                <option value="sarah">Sarah Chen</option>
                                <option value="mike">Mike Rodriguez</option>
                                <option value="pm">Project Manager</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createProjectForm" class="btn btn-warning">Create Project</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <script>
        // Global variables
        let currentSection = 'dashboard';
        let timerInterval;
        let timerSeconds = 0;
        let isTimerRunning = false;

        // Navigation Functions
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionName).classList.add('active');
            
            // Update navbar active state
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector(`[href="#${sectionName}"]`).classList.add('active');
            
            // Update sidebar active state
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });
            
            currentSection = sectionName;
            
            // Initialize charts when reports section is shown
            if (sectionName === 'reports') {
                initializeCharts();
            }
        }

        // Sidebar Functions
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Task Management Functions
        function filterTasks(status) {
            // Remove active class from all filter buttons
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            // Add active class to clicked button
            event.target.classList.add('active');
            
            // Filter logic would go here
            console.log('Filtering tasks by:', status);
        }

        // Chat Functions
        function selectChat(contactId) {
            document.querySelectorAll('.chat-contact').forEach(contact => {
                contact.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // Update chat header and messages based on contact
            console.log('Selected chat:', contactId);
        }

        // Chat form submission
        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
            if (message) {
                // Add message to chat
                const chatContainer = document.querySelector('.chat-container');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message message-sent';
                messageDiv.innerHTML = `
                    <small class="text-muted">You - ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                    <p class="mb-0">${message}</p>
                `;
                chatContainer.appendChild(messageDiv);
                chatContainer.scrollTop = chatContainer.scrollHeight;
                
                messageInput.value = '';
            }
        });

        // Timer Functions
        document.getElementById('startTimer').addEventListener('click', function() {
            if (!isTimerRunning) {
                isTimerRunning = true;
                document.getElementById('startTimer').style.display = 'none';
                document.getElementById('stopTimer').style.display = 'inline-block';
                document.getElementById('timerDisplay').style.display = 'block';
                
                timerInterval = setInterval(function() {
                    timerSeconds++;
                    updateTimerDisplay();
                }, 1000);
            }
        });

        document.getElementById('stopTimer').addEventListener('click', function() {
            if (isTimerRunning) {
                isTimerRunning = false;
                clearInterval(timerInterval);
                document.getElementById('startTimer').style.display = 'inline-block';
                document.getElementById('stopTimer').style.display = 'none';
                
                // Auto-populate time tracking form
                const now = new Date();
                const startTime = new Date(now.getTime() - timerSeconds * 1000);
                document.querySelector('input[type="time"]').value = startTime.toTimeString().slice(0, 5);
                document.querySelectorAll('input[type="time"]')[1].value = now.toTimeString().slice(0, 5);
            }
        });

        function updateTimerDisplay() {
            const hours = Math.floor(timerSeconds / 3600);
            const minutes = Math.floor((timerSeconds % 3600) / 60);
            const seconds = timerSeconds % 60;
            
            const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('timerTime').textContent = timeString;
        }

        // Form Submissions
        document.getElementById('timeTrackingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Reset timer
            timerSeconds = 0;
            isTimerRunning = false;
            document.getElementById('startTimer').style.display = 'inline-block';
            document.getElementById('stopTimer').style.display = 'none';
            document.getElementById('timerDisplay').style.display = 'none';
            
            // Show success message
            alert('Time logged successfully!');
            this.reset();
        });

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Profile updated successfully!');
        });

        document.getElementById('createTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Task created successfully!');
            bootstrap.Modal.getInstance(document.getElementById('createTaskModal')).hide();
            this.reset();
        });

        document.getElementById('editTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Task updated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
        });

        document.getElementById('requestReviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Code review requested successfully!');
            bootstrap.Modal.getInstance(document.getElementById('requestReviewModal')).hide();
            this.reset();
        });

        document.getElementById('createProjectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Project created successfully!');
            bootstrap.Modal.getInstance(document.getElementById('createProjectModal')).hide();
            this.reset();
        });

        // Charts Initialization
        function initializeCharts() {
            // Productivity Chart
            const productivityCtx = document.getElementById('productivityChart');
            if (productivityCtx) {
                new Chart(productivityCtx, {
                    type: 'line',
                    data: {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        datasets: [{
                            label: 'Hours Worked',
                            data: [8, 7.5, 8.5, 6, 9, 4, 2],
                            borderColor: '#ffc107',
                            backgroundColor: 'rgba(255, 193, 7, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Tasks Completed',
                            data: [3, 2, 4, 2, 5, 2, 1],
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Time Distribution Chart
            const timeDistCtx = document.getElementById('timeDistributionChart');
            if (timeDistCtx) {
                new Chart(timeDistCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['E-Commerce', 'Mobile App', 'API Gateway'],
                        datasets: [{
                            data: [57, 27, 16],
                            backgroundColor: ['#ffc107', '#28a745', '#17a2b8']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        }

        // Search functionality
        document.getElementById('taskSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            // Search logic would go here
            console.log('Searching for:', searchTerm);
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date for forms
            const today = new Date().toISOString().split('T')[0];
            document.querySelectorAll('input[type="date"]').forEach(input => {
                if (!input.value) {
                    input.value = today;
                }
            });

            // Show dashboard by default
            showSection('dashboard');
        });

        // Responsive sidebar toggle
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }

        // Add mobile menu toggle
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.navbar-toggler');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>
                