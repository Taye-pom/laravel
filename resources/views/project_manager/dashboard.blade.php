<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevCollab - Project Manager Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-yellow: #ffc107;
            --dark-yellow: #f0a500;
            --light-yellow: #fff3cd;
            --text-dark: #212529;
            --sidebar-bg: #1a1a1a;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar .brand {
            padding: 1.5rem;
            border-bottom: 1px solid #333;
            color: var(--primary-yellow);
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 1rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: var(--primary-yellow);
            background: rgba(255, 193, 7, 0.1);
            border-left-color: var(--primary-yellow);
            transform: translateX(5px);
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        .top-navbar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            padding: 1rem 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary-yellow);
            margin-bottom: 2rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dark-yellow);
        }

        .page-section {
            display: none;
            animation: fadeInUp 0.5s ease;
        }

        .page-section.active {
            display: block;
        }

        .btn-yellow {
            background: var(--primary-yellow);
            border: none;
            color: var(--text-dark);
            font-weight: 600;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-yellow:hover {
            background: var(--dark-yellow);
            color: white;
            transform: translateY(-2px);
        }

        .task-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .task-card:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 25px rgba(0,0,0,0.12);
        }

        .priority-high { border-left: 5px solid #dc3545; }
        .priority-medium { border-left: 5px solid var(--primary-yellow); }
        .priority-low { border-left: 5px solid #28a745; }

        .chat-container {
            height: 400px;
            overflow-y: auto;
            background: white;
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .chat-message {
            padding: 0.5rem 1rem;
            margin: 0.5rem 0;
            border-radius: 15px;
            max-width: 70%;
        }

        .chat-message.sent {
            background: var(--light-yellow);
            margin-left: auto;
            text-align: right;
        }

        .chat-message.received {
            background: #f8f9fa;
            margin-right: auto;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }

        .table-custom {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .table-custom thead {
            background: var(--light-yellow);
        }

        .progress-modern {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar-yellow {
            background: linear-gradient(45deg, var(--primary-yellow), var(--dark-yellow));
        }

        .rating-stars .rating-star {
            font-size: 2rem;
            color: #dee2e6;
            cursor: pointer;
            transition: color 0.3s ease;
            margin: 0 0.2rem;
        }

        .rating-stars .rating-star:hover,
        .rating-stars .rating-star.active {
            color: var(--primary-yellow);
        }

        .stars-rating .fa-star,
        .stars-rating .fa-star-half-alt {
            color: var(--primary-yellow);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fas fa-code-branch me-2"></i>DevCollab PM
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="#" onclick="showSection('dashboard')">
                <i class="fas fa-tachometer-alt me-3"></i>Dashboard
            </a>
            <a class="nav-link" href="#" onclick="showSection('projects')">
                <i class="fas fa-project-diagram me-3"></i>Projects
            </a>
            <a class="nav-link" href="#" onclick="showSection('tasks')">
                <i class="fas fa-tasks me-3"></i>Task Management
            </a>
            <a class="nav-link" href="#" onclick="showSection('team')">
                <i class="fas fa-users me-3"></i>Team Management
            </a>
            <a class="nav-link" href="#" onclick="showSection('reports')">
                <i class="fas fa-chart-bar me-3"></i>Reports & Analytics
            </a>
            <a class="nav-link" href="#" onclick="showSection('chat')">
                <i class="fas fa-comments me-3"></i>Team Chat
            </a>
            <a class="nav-link" href="#" onclick="showSection('calendar')">
                <i class="fas fa-calendar-alt me-3"></i>Calendar
            </a>
            <a class="nav-link" href="#" onclick="showSection('settings')">
                <i class="fas fa-cog me-3"></i>Settings
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-outline-secondary d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0 ms-3 d-inline">Welcome back, Alex!</h4>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown me-3">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-warning rounded-pill">3</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">New task assigned</a></li>
                        <li><a class="dropdown-item" href="#">Project deadline approaching</a></li>
                        <li><a class="dropdown-item" href="#">Team member joined</a></li>
                    </ul>
                </div>
                <img src="https://via.placeholder.com/40x40" class="rounded-circle" alt="Profile">
            </div>
        </div>

        <!-- Dashboard Section -->
        <div class="page-section active" id="dashboard">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card animate__animated animate__fadeInUp">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted">Active Projects</h6>
                                <div class="stat-number">12</div>
                            </div>
                            <i class="fas fa-project-diagram fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted">Total Tasks</h6>
                                <div class="stat-number">148</div>
                            </div>
                            <i class="fas fa-tasks fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted">Team Members</h6>
                                <div class="stat-number">24</div>
                            </div>
                            <i class="fas fa-users fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted">Completion Rate</h6>
                                <div class="stat-number">78%</div>
                            </div>
                            <i class="fas fa-chart-line fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="stat-card">
                        <h5 class="mb-3">Recent Projects</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Progress</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>E-commerce Platform</td>
                                        <td>
                                            <div class="progress progress-modern">
                                                <div class="progress-bar progress-bar-yellow" style="width: 85%"></div>
                                            </div>
                                            <small>85%</small>
                                        </td>
                                        <td>Dec 15, 2024</td>
                                        <td><span class="badge bg-success">On Track</span></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile App</td>
                                        <td>
                                            <div class="progress progress-modern">
                                                <div class="progress-bar progress-bar-yellow" style="width: 60%"></div>
                                            </div>
                                            <small>60%</small>
                                        </td>
                                        <td>Jan 20, 2025</td>
                                        <td><span class="badge bg-warning">At Risk</span></td>
                                    </tr>
                                    <tr>
                                        <td>API Integration</td>
                                        <td>
                                            <div class="progress progress-modern">
                                                <div class="progress-bar progress-bar-yellow" style="width: 95%"></div>
                                            </div>
                                            <small>95%</small>
                                        </td>
                                        <td>Nov 30, 2024</td>
                                        <td><span class="badge bg-success">On Track</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="stat-card">
                        <h5 class="mb-3">Team Activity</h5>
                        <div class="activity-item d-flex align-items-center mb-3">
                            <div class="activity-icon bg-warning rounded-circle me-3 p-2">
                                <i class="fas fa-check text-dark"></i>
                            </div>
                            <div>
                                <small class="text-muted">2 hours ago</small>
                                <p class="mb-0">Sarah completed "User Authentication"</p>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-center mb-3">
                            <div class="activity-icon bg-info rounded-circle me-3 p-2">
                                <i class="fas fa-code text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted">4 hours ago</small>
                                <p class="mb-0">Mike pushed new commits</p>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-center mb-3">
                            <div class="activity-icon bg-success rounded-circle me-3 p-2">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted">6 hours ago</small>
                                <p class="mb-0">New team member added</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="page-section" id="projects">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Project Management</h3>
                <button class="btn btn-yellow" data-bs-toggle="modal" data-bs-target="#createProjectModal">
                    <i class="fas fa-plus me-2"></i>Create New Project
                </button>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5>E-commerce Platform</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="editProject('1')">Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewProject('1')">View Details</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteProject('1')">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted">Full-stack e-commerce solution with modern UI/UX</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small>Progress</small>
                                <small>85%</small>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar progress-bar-yellow" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Tasks</small>
                                <div class="fw-bold">24/28</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Team</small>
                                <div class="fw-bold">6</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Days Left</small>
                                <div class="fw-bold">12</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5>Mobile App</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="editProject('2')">Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewProject('2')">View Details</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteProject('2')">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted">React Native mobile application</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small>Progress</small>
                                <small>60%</small>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar progress-bar-yellow" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Tasks</small>
                                <div class="fw-bold">15/25</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Team</small>
                                <div class="fw-bold">4</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Days Left</small>
                                <div class="fw-bold">45</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5>API Integration</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="editProject('3')">Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="viewProject('3')">View Details</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteProject('3')">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted">REST API development and integration</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small>Progress</small>
                                <small>95%</small>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar progress-bar-yellow" style="width: 95%"></div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <small class="text-muted">Tasks</small>
                                <div class="fw-bold">18/19</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Team</small>
                                <div class="fw-bold">3</div>
                            </div>
                            <div class="col-4">
                                <small class="text-muted">Days Left</small>
                                <div class="fw-bold">5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Section -->
        <div class="page-section" id="tasks">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Task Management</h3>
                <button class="btn btn-yellow" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    <i class="fas fa-plus me-2"></i>Create New Task
                </button>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <select class="form-select" id="projectFilter">
                        <option value="">All Projects</option>
                        <option value="1">E-commerce Platform</option>
                        <option value="2">Mobile App</option>
                        <option value="3">API Integration</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="todo">To Do</option>
                        <option value="progress">In Progress</option>
                        <option value="review">In Review</option>
                        <option value="done">Done</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="priorityFilter">
                        <option value="">All Priorities</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <h5 class="mb-3">To Do</h5>
                    <div class="task-card priority-high">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6>Fix payment gateway bug</h6>
                            <span class="badge bg-danger">High</span>
                        </div>
                        <p class="text-muted small">E-commerce Platform</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://via.placeholder.com/30x30" class="rounded-circle me-1" alt="User">
                                <small>Sarah Johnson</small>
                            </div>
                            <small class="text-muted">Due: Nov 20</small>
                        </div>
                    </div>

                    <div class="task-card priority-medium">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6>Design user profile page</h6>
                            <span class="badge bg-warning">Medium</span>
                        </div>
                        <p class="text-muted small">Mobile App</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://via.placeholder.com/30x30" class="rounded-circle me-1" alt="User">
                                <small>Mike Chen</small>
                            </div>
                            <small class="text-muted">Due: Nov 25</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h5 class="mb-3">In Progress</h5>
                    <div class="task-card priority-high">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6>User authentication system</h6>
                            <span class="badge bg-danger">High</span>
                        </div>
                        <p class="text-muted small">E-commerce Platform</p>
                        <div class="progress progress-modern mb-2">
                            <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://via.placeholder.com/30x30" class="rounded-circle me-1" alt="User">
                                <small>John Doe</small>
                            </div>
                            <small class="text-muted">70% Complete</small>
                        </div>
                    </div>

                    <div class="task-card priority-low">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6>API documentation</h6>
                            <span class="badge bg-success">Low</span>
                        </div>
                        <p class="text-muted small">API Integration</p>
                        <div class="progress progress-modern mb-2">
                            <div class="progress-bar progress-bar-yellow" style="width: 30%"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://via.placeholder.com/30x30" class="rounded-circle me-1" alt="User">
                                <small>Emma Wilson</small>
                            </div>
                            <small class="text-muted">30% Complete</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h5 class="mb-3">Done</h5>
                    <div class="task-card priority-medium">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6>Database schema design</h6>
                            <span class="badge bg-success">Completed</span>
                        </div>
                        <p class="text-muted small">E-commerce Platform</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://via.placeholder.com/30x30" class="rounded-circle me-1" alt="User">
                                <small>Alex Rodriguez</small>
                            </div>
                            <small class="text-success">Completed</small>
                        </div>
                    </div>

                    <div class="task-card priority-low">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6>Unit tests implementation</h6>
                            <span class="badge bg-success">Completed</span>
                        </div>
                        <p class="text-muted small">API Integration</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="https://via.placeholder.com/30x30" class="rounded-circle me-1" alt="User">
                                <small>Lisa Park</small>
                            </div>
                            <small class="text-success">Completed</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Management Section -->
        <div class="page-section" id="team">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Team Management</h3>
                <button class="btn btn-yellow" data-bs-toggle="modal" data-bs-target="#inviteTeamModal">
                    <i class="fas fa-user-plus me-2"></i>Invite Team Member
                </button>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="stat-card">
                        <h5 class="mb-3">Team Members</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Projects</th>
                                        <th>Tasks</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="User">
                                                <div>
                                                    <div class="fw-bold">Sarah Johnson</div>
                                                    <small class="text-muted">sarah@company.com</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Frontend Developer</td>
                                        <td>3</td>
                                        <td>8</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="stars-rating me-2">
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                </div>
                                                <small class="text-muted">4.5 (4)</small>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" onclick="viewTeamMember('1')">View</button>
                                            <button class="btn btn-sm btn-outline-warning me-1" onclick="editTeamMember('1')">Edit</button>
                                            <button class="btn btn-sm btn-outline-success" onclick="rateTeamMember('1')">Rate</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="User">
                                                <div>
                                                    <div class="fw-bold">Mike Chen</div>
                                                    <small class="text-muted">mike@company.com</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Backend Developer</td>
                                        <td>2</td>
                                        <td>12</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="stars-rating me-2">
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                </div>
                                                <small class="text-muted">4.6 (3)</small>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" onclick="viewTeamMember('2')">View</button>
                                            <button class="btn btn-sm btn-outline-warning me-1" onclick="editTeamMember('2')">Edit</button>
                                            <button class="btn btn-sm btn-outline-success" onclick="rateTeamMember('2')">Rate</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="User">
                                                <div>
                                                    <div class="fw-bold">John Doe</div>
                                                    <small class="text-muted">john@company.com</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Full Stack Developer</td>
                                        <td>4</td>
                                        <td>15</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="stars-rating me-2">
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="far fa-star text-warning"></i>
                                                </div>
                                                <small class="text-muted">4.4 (5)</small>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-warning">Busy</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" onclick="viewTeamMember('3')">View</button>
                                            <button class="btn btn-sm btn-outline-warning me-1" onclick="editTeamMember('3')">Edit</button>
                                            <button class="btn btn-sm btn-outline-success" onclick="rateTeamMember('3')">Rate</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="User">
                                                <div>
                                                    <div class="fw-bold">Emma Wilson</div>
                                                    <small class="text-muted">emma@company.com</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>UI/UX Designer</td>
                                        <td>2</td>
                                        <td>6</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="stars-rating me-2">
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <i class="fas fa-star text-warning"></i>
                                                </div>
                                                <small class="text-muted">4.8 (2)</small>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" onclick="viewTeamMember('4')">View</button>
                                            <button class="btn btn-sm btn-outline-warning me-1" onclick="editTeamMember('4')">Edit</button>
                                            <button class="btn btn-sm btn-outline-success" onclick="rateTeamMember('4')">Rate</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="stat-card mb-4">
                        <h5 class="mb-3">Team Statistics</h5>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Frontend Developers</span>
                                <strong>8</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Backend Developers</span>
                                <strong>6</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Full Stack Developers</span>
                                <strong>4</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>UI/UX Designers</span>
                                <strong>3</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>DevOps Engineers</span>
                                <strong>2</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>QA Testers</span>
                                <strong>1</strong>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <h5 class="mb-3">Top Rated Developers</h5>
                        <div class="top-developers">
                            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/35x35" class="rounded-circle me-2" alt="User">
                                    <div>
                                        <div class="fw-bold small">Emma Wilson</div>
                                        <div class="stars-rating">
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-warning">4.8</span>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/35x35" class="rounded-circle me-2" alt="User">
                                    <div>
                                        <div class="fw-bold small">Mike Chen</div>
                                        <div class="stars-rating">
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-warning">4.6</span>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/35x35" class="rounded-circle me-2" alt="User">
                                    <div>
                                        <div class="fw-bold small">Sarah Johnson</div>
                                        <div class="stars-rating">
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star-half-alt text-warning small"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-warning">4.5</span>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between p-2 border rounded">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/35x35" class="rounded-circle me-2" alt="User">
                                    <div>
                                        <div class="fw-bold small">John Doe</div>
                                        <div class="stars-rating">
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="far fa-star text-warning small"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge bg-warning">4.4</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div class="page-section" id="reports">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Reports & Analytics</h3>
                <div>
                    <button class="btn btn-outline-secondary me-2">
                        <i class="fas fa-download me-2"></i>Export PDF
                    </button>
                    <button class="btn btn-yellow">
                        <i class="fas fa-chart-line me-2"></i>Generate Report
                    </button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card text-center">
                        <i class="fas fa-project-diagram fa-2x text-warning mb-3"></i>
                        <h4 class="stat-number">12</h4>
                        <p class="text-muted">Active Projects</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card text-center">
                        <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                        <h4 class="stat-number">148</h4>
                        <p class="text-muted">Completed Tasks</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card text-center">
                        <i class="fas fa-clock fa-2x text-info mb-3"></i>
                        <h4 class="stat-number">1,240</h4>
                        <p class="text-muted">Hours Logged</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card text-center">
                        <i class="fas fa-percentage fa-2x text-warning mb-3"></i>
                        <h4 class="stat-number">87%</h4>
                        <p class="text-muted">Efficiency Rate</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="stat-card">
                        <h5 class="mb-3">Project Timeline</h5>
                        <div class="timeline-container" style="height: 400px; overflow-y: auto;">
                            <div class="timeline-item d-flex align-items-center mb-3">
                                <div class="timeline-marker bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>E-commerce Platform - Phase 1</strong>
                                        <small class="text-muted">Completed</small>
                                    </div>
                                    <p class="text-muted mb-1">Database design and backend API development</p>
                                    <small class="text-muted">Sep 1 - Oct 15, 2024</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item d-flex align-items-center mb-3">
                                <div class="timeline-marker bg-warning rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>Mobile App - UI Development</strong>
                                        <small class="text-warning">In Progress</small>
                                    </div>
                                    <p class="text-muted mb-1">React Native interface implementation</p>
                                    <small class="text-muted">Oct 20 - Nov 30, 2024</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item d-flex align-items-center mb-3">
                                <div class="timeline-marker bg-info rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>API Integration - Testing</strong>
                                        <small class="text-info">Planned</small>
                                    </div>
                                    <p class="text-muted mb-1">Integration testing and documentation</p>
                                    <small class="text-muted">Dec 1 - Dec 15, 2024</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="stat-card">
                        <h5 class="mb-3">Performance Metrics</h5>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Task Completion Rate</span>
                                <strong>92%</strong>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar progress-bar-yellow" style="width: 92%"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>On-time Delivery</span>
                                <strong>85%</strong>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Code Quality Score</span>
                                <strong>78%</strong>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar bg-info" style="width: 78%"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Team Satisfaction</span>
                                <strong>94%</strong>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar bg-success" style="width: 94%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Section -->
        <div class="page-section" id="chat">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Team Chat</h3>
                <div>
                    <select class="form-select d-inline-block" style="width: auto;" id="chatChannel">
                        <option value="general">General</option>
                        <option value="ecommerce">E-commerce Team</option>
                        <option value="mobile">Mobile App Team</option>
                        <option value="api">API Team</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="chat-container mb-3">
                        <div id="chatMessages">
                            <div class="chat-message received">
                                <strong>Sarah Johnson</strong> <small class="text-muted">10:30 AM</small>
                                <div>Good morning everyone! Ready for today's sprint review?</div>
                            </div>
                            <div class="chat-message sent">
                                <strong>You</strong> <small class="text-muted">10:32 AM</small>
                                <div>Morning Sarah! Yes, looking forward to seeing the progress on the payment module.</div>
                            </div>
                            <div class="chat-message received">
                                <strong>Mike Chen</strong> <small class="text-muted">10:35 AM</small>
                                <div>I've finished the API endpoints for user authentication. Ready for testing!</div>
                            </div>
                            <div class="chat-message received">
                                <strong>John Doe</strong> <small class="text-muted">10:40 AM</small>
                                <div>Great work Mike! I'll start integration testing this afternoon.</div>
                            </div>
                            <div class="chat-message sent">
                                <strong>You</strong> <small class="text-muted">10:42 AM</small>
                                <div>Excellent progress team! Let's schedule a quick standup at 2 PM to sync up.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="chatInput" placeholder="Type your message...">
                        <button class="btn btn-yellow" onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="stat-card">
                        <h6 class="mb-3">Online Team Members</h6>
                        <div class="online-users">
                            <div class="d-flex align-items-center mb-2">
                                <div class="position-relative me-2">
                                    <img src="https://via.placeholder.com/30x30" class="rounded-circle" alt="User">
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" style="width: 8px; height: 8px;"></span>
                                </div>
                                <small>Sarah Johnson</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="position-relative me-2">
                                    <img src="https://via.placeholder.com/30x30" class="rounded-circle" alt="User">
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" style="width: 8px; height: 8px;"></span>
                                </div>
                                <small>Mike Chen</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="position-relative me-2">
                                    <img src="https://via.placeholder.com/30x30" class="rounded-circle" alt="User">
                                    <span class="position-absolute bottom-0 end-0 bg-warning rounded-circle" style="width: 8px; height: 8px;"></span>
                                </div>
                                <small>John Doe (Away)</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="position-relative me-2">
                                    <img src="https://via.placeholder.com/30x30" class="rounded-circle" alt="User">
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" style="width: 8px; height: 8px;"></span>
                                </div>
                                <small>Emma Wilson</small>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card mt-3">
                        <h6 class="mb-3">Quick Actions</h6>
                        <button class="btn btn-outline-primary btn-sm w-100 mb-2">
                            <i class="fas fa-video me-2"></i>Start Video Call
                        </button>
                        <button class="btn btn-outline-success btn-sm w-100 mb-2">
                            <i class="fas fa-share-alt me-2"></i>Share Screen
                        </button>
                        <button class="btn btn-outline-info btn-sm w-100">
                            <i class="fas fa-file-alt me-2"></i>Share Files
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="page-section" id="calendar">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Project Calendar</h3>
                <button class="btn btn-yellow" data-bs-toggle="modal" data-bs-target="#createEventModal">
                    <i class="fas fa-plus me-2"></i>Add Event
                </button>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5>November 2024</h5>
                            <div>
                                <button class="btn btn-outline-secondary btn-sm me-1">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="calendar-grid">
                            <div class="row text-center border-bottom pb-2 mb-2">
                                <div class="col">Sun</div>
                                <div class="col">Mon</div>
                                <div class="col">Tue</div>
                                <div class="col">Wed</div>
                                <div class="col">Thu</div>
                                <div class="col">Fri</div>
                                <div class="col">Sat</div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col p-2 text-muted">27</div>
                                <div class="col p-2 text-muted">28</div>
                                <div class="col p-2 text-muted">29</div>
                                <div class="col p-2 text-muted">30</div>
                                <div class="col p-2">1</div>
                                <div class="col p-2">2</div>
                                <div class="col p-2">3</div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col p-2">4</div>
                                <div class="col p-2">5</div>
                                <div class="col p-2">6</div>
                                <div class="col p-2">7</div>
                                <div class="col p-2">8</div>
                                <div class="col p-2">9</div>
                                <div class="col p-2">10</div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col p-2">11</div>
                                <div class="col p-2">12</div>
                                <div class="col p-2">13</div>
                                <div class="col p-2">14</div>
                                <div class="col p-2 bg-warning rounded">15
                                    <small class="d-block text-dark">Sprint Review</small>
                                </div>
                                <div class="col p-2 bg-info rounded text-white">16
                                    <small class="d-block">Today</small>
                                </div>
                                <div class="col p-2">17</div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col p-2">18</div>
                                <div class="col p-2">19</div>
                                <div class="col p-2 bg-danger rounded text-white">20
                                    <small class="d-block">Deadline</small>
                                </div>
                                <div class="col p-2">21</div>
                                <div class="col p-2">22</div>
                                <div class="col p-2">23</div>
                                <div class="col p-2">24</div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col p-2 bg-success rounded text-white">25
                                    <small class="d-block">Demo Day</small>
                                </div>
                                <div class="col p-2">26</div>
                                <div class="col p-2">27</div>
                                <div class="col p-2">28</div>
                                <div class="col p-2">29</div>
                                <div class="col p-2 bg-warning rounded">30
                                    <small class="d-block text-dark">Planning</small>
                                </div>
                                <div class="col p-2 text-muted">1</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="stat-card mb-3">
                        <h6 class="mb-3">Upcoming Events</h6>
                        <div class="event-item border-start border-warning border-3 ps-3 mb-3">
                            <strong>Sprint Review Meeting</strong>
                            <div class="text-muted small">Nov 15, 2024 - 2:00 PM</div>
                            <p class="small mb-0">Review progress on E-commerce Platform</p>
                        </div>
                        <div class="event-item border-start border-danger border-3 ps-3 mb-3">
                            <strong>Payment Module Deadline</strong>
                            <div class="text-muted small">Nov 20, 2024 - 5:00 PM</div>
                            <p class="small mb-0">Final submission for payment integration</p>
                        </div>
                        <div class="event-item border-start border-success border-3 ps-3 mb-3">
                            <strong>Project Demo</strong>
                            <div class="text-muted small">Nov 25, 2024 - 10:00 AM</div>
                            <p class="small mb-0">Client presentation for Mobile App</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <h6 class="mb-3">Event Legend</h6>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-warning rounded me-2" style="width: 12px; height: 12px;"></div>
                            <small>Meetings & Reviews</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-danger rounded me-2" style="width: 12px; height: 12px;"></div>
                            <small>Deadlines</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded me-2" style="width: 12px; height: 12px;"></div>
                            <small>Demos & Presentations</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded me-2" style="width: 12px; height: 12px;"></div>
                            <small>Planning Sessions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div class="page-section" id="settings">
            <h3 class="mb-4">Settings & Preferences</h3>

            <div class="row">
                <div class="col-lg-8">
                    <div class="stat-card mb-4">
                        <h5 class="mb-3">Profile Settings</h5>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" value="Alex">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" value="Rodriguez">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="alex@company.com">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" value="+1 (555) 123-4567">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Time Zone</label>
                                        <select class="form-select">
                                            <option>UTC-5 (Eastern Time)</option>
                                            <option>UTC-6 (Central Time)</option>
                                            <option>UTC-7 (Mountain Time)</option>
                                            <option>UTC-8 (Pacific Time)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-yellow">Update Profile</button>
                        </form>
                    </div>

                    <div class="stat-card mb-4">
                        <h5 class="mb-3">Notification Settings</h5>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                            <label class="form-check-label" for="emailNotifications">
                                Email Notifications
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="pushNotifications" checked>
                            <label class="form-check-label" for="pushNotifications">
                                Push Notifications
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="taskDeadlines" checked>
                            <label class="form-check-label" for="taskDeadlines">
                                Task Deadline Reminders
                            </label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="weeklyReports">
                            <label class="form-check-label" for="weeklyReports">
                                Weekly Progress Reports
                            </label>
                        </div>
                        <button class="btn btn-yellow">Save Preferences</button>
                    </div>

                    <div class="stat-card">
                        <h5 class="mb-3">Security Settings</h5>
                        <div class="mb-3">
                            <button class="btn btn-outline-warning me-2">Change Password</button>
                            <button class="btn btn-outline-info">Enable 2FA</button>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Two-factor authentication is not currently enabled. We recommend enabling it for enhanced security.
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="stat-card mb-3">
                        <h6 class="mb-3">Account Information</h6>
                        <div class="text-center mb-3">
                            <img src="https://via.placeholder.com/80x80" class="rounded-circle mb-2" alt="Profile">
                            <div>
                                <strong>Alex Rodriguez</strong>
                                <div class="text-muted small">Project Manager</div>
                            </div>
                        </div>
                        <hr>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Member Since:</span>
                                <strong>Jan 2023</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Projects Managed:</span>
                                <strong>24</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Team Size:</span>
                                <strong>18 members</strong>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <h6 class="mb-3">System Information</h6>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Version:</span>
                                <span class="badge bg-success">v2.1.0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Last Login:</span>
                                <span>Nov 16, 10:30 AM</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Storage Used:</span>
                                <span>2.1 GB / 10 GB</span>
                            </div>
                            <div class="progress progress-modern">
                                <div class="progress-bar progress-bar-yellow" style="width: 21%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    
    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createProjectForm">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Project Name *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="form-select">
                                        <option value="high">High</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Assign Team Members</label>
                            <select class="form-select" multiple>
                                <option value="1">Sarah Johnson - Frontend Developer</option>
                                <option value="2">Mike Chen - Backend Developer</option>
                                <option value="3">John Doe - Full Stack Developer</option>
                                <option value="4">Emma Wilson - UI/UX Designer</option>
                            </select>
                            <small class="form-text text-muted">Hold Ctrl to select multiple members</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Budget (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="createProject()">Create Project</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm">
                        <div class="mb-3">
                            <label class="form-label">Task Title *</label>
                            <input type="text" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Project</label>
                                    <select class="form-select" required>
                                        <option value="">Select Project</option>
                                        <option value="1">E-commerce Platform</option>
                                        <option value="2">Mobile App</option>
                                        <option value="3">API Integration</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="form-select">
                                        <option value="high">High</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Assign To</label>
                                    <select class="form-select">
                                        <option value="">Select Developer</option>
                                        <option value="1">Sarah Johnson</option>
                                        <option value="2">Mike Chen</option>
                                        <option value="3">John Doe</option>
                                        <option value="4">Emma Wilson</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Estimated Hours</label>
                            <input type="number" class="form-control" min="1" max="100">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="createTask()">Create Task</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invite Team Modal -->
    <div class="modal fade" id="inviteTeamModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invite Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="inviteTeamForm">
                        <div class="mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select">
                                <option value="frontend">Frontend Developer</option>
                                <option value="backend">Backend Developer</option>
                                <option value="fullstack">Full Stack Developer</option>
                                <option value="designer">UI/UX Designer</option>
                                <option value="devops">DevOps Engineer</option>
                                <option value="qa">QA Tester</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Assign to Projects (Optional)</label>
                            <select class="form-select" multiple>
                                <option value="1">E-commerce Platform</option>
                                <option value="2">Mobile App</option>
                                <option value="3">API Integration</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Personal Message (Optional)</label>
                            <textarea class="form-control" rows="3" placeholder="Welcome to our team..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="inviteTeamMember()">Send Invitation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Event Modal -->
    <div class="modal fade" id="createEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Calendar Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createEventForm">
                        <div class="mb-3">
                            <label class="form-label">Event Title *</label>
                            <input type="text" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Time</label>
                                    <input type="time" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Event Type</label>
                            <select class="form-select">
                                <option value="meeting">Meeting</option>
                                <option value="deadline">Deadline</option>
                                <option value="demo">Demo/Presentation</option>
                                <option value="planning">Planning Session</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Related Project (Optional)</label>
                            <select class="form-select">
                                <option value="">No Project</option>
                                <option value="1">E-commerce Platform</option>
                                <option value="2">Mobile App</option>
                                <option value="3">API Integration</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Attendees</label>
                            <select class="form-select" multiple>
                                <option value="1">Sarah Johnson</option>
                                <option value="2">Mike Chen</option>
                                <option value="3">John Doe</option>
                                <option value="4">Emma Wilson</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="createEvent()">Create Event</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Rate Team Member Modal -->
    <div class="modal fade" id="rateTeamMemberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rate Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://via.placeholder.com/80x80" class="rounded-circle mb-3" alt="User" id="rateUserImage">
                        <h5 id="rateUserName">Team Member Name</h5>
                        <p class="text-muted" id="rateUserRole">Role</p>
                    </div>
                    
                    <form id="rateTeamMemberForm">
                        <input type="hidden" id="rateMemberId">
                        
                        <div class="mb-3">
                            <label class="form-label">Project Completed</label>
                            <select class="form-select" id="rateProject" required>
                                <option value="">Select Project</option>
                                <option value="1">E-commerce Platform</option>
                                <option value="2">Mobile App</option>
                                <option value="3">API Integration</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Overall Rating</label>
                            <div class="rating-stars text-center">
                                <i class="fas fa-star rating-star" data-rating="1"></i>
                                <i class="fas fa-star rating-star" data-rating="2"></i>
                                <i class="fas fa-star rating-star" data-rating="3"></i>
                                <i class="fas fa-star rating-star" data-rating="4"></i>
                                <i class="fas fa-star rating-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" id="selectedRating" value="5">
                            <small class="text-muted d-block text-center mt-2" id="ratingText">Excellent (5/5)</small>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Code Quality (1-5)</label>
                                <select class="form-select" id="codeQuality">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Communication (1-5)</label>
                                <select class="form-select" id="communication">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Punctuality (1-5)</label>
                                <select class="form-select" id="punctuality">
                                    <option value="5">5 - Always On Time</option>
                                    <option value="4">4 - Usually On Time</option>
                                    <option value="3">3 - Sometimes Late</option>
                                    <option value="2">2 - Often Late</option>
                                    <option value="1">1 - Always Late</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Problem Solving (1-5)</label>
                                <select class="form-select" id="problemSolving">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Comments & Feedback</label>
                            <textarea class="form-control" rows="4" id="ratingComments" placeholder="Share specific feedback about this developer's performance..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="recommendForFuture">
                                <label class="form-check-label" for="recommendForFuture">
                                    I would recommend this developer for future projects
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="submitRating()">Submit Rating</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Team Member Details Modal -->
    <div class="modal fade" id="viewTeamMemberModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Team Member Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="https://via.placeholder.com/120x120" class="rounded-circle mb-3" alt="User" id="viewUserImage">
                            <h5 id="viewUserName">Team Member Name</h5>
                            <p class="text-muted" id="viewUserRole">Role</p>
                            <div class="mb-3">
                                <div class="stars-rating mb-1" id="viewUserRating">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </div>
                                <small class="text-muted" id="viewUserRatingText">4.5 out of 5 (4 ratings)</small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <strong>Email:</strong>
                                    <div id="viewUserEmail">email@company.com</div>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Status:</strong>
                                    <div><span class="badge bg-success" id="viewUserStatus">Active</span></div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <strong>Active Projects:</strong>
                                    <div id="viewUserProjects">3</div>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Total Tasks:</strong>
                                    <div id="viewUserTasks">8</div>
                                </div>
                            </div>
                            
                            <h6 class="mb-3">Performance Breakdown</h6>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <small>Code Quality</small>
                                    <small><strong>4.6/5</strong></small>
                                </div>
                                <div class="progress progress-modern">
                                    <div class="progress-bar progress-bar-yellow" style="width: 92%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <small>Communication</small>
                                    <small><strong>4.8/5</strong></small>
                                </div>
                                <div class="progress progress-modern">
                                    <div class="progress-bar progress-bar-yellow" style="width: 96%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <small>Punctuality</small>
                                    <small><strong>4.3/5</strong></small>
                                </div>
                                <div class="progress progress-modern">
                                    <div class="progress-bar progress-bar-yellow" style="width: 86%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <small>Problem Solving</small>
                                    <small><strong>4.7/5</strong></small>
                                </div>
                                <div class="progress progress-modern">
                                    <div class="progress-bar progress-bar-yellow" style="width: 94%"></div>
                                </div>
                            </div>
                            
                            <h6 class="mb-2">Recent Project Ratings</h6>
                            <div class="recent-ratings">
                                <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                                    <div>
                                        <small class="fw-bold">E-commerce Platform</small>
                                        <div class="text-muted small">Frontend Development</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="stars-rating">
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                        </div>
                                        <small class="text-muted">4.6</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                                    <div>
                                        <small class="fw-bold">Mobile App</small>
                                        <div class="text-muted small">UI Components</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="stars-rating">
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="fas fa-star text-warning small"></i>
                                            <i class="far fa-star text-warning small"></i>
                                        </div>
                                        <small class="text-muted">4.2</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Latest Feedback Comments</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-2"><strong>From E-commerce Platform:</strong></p>
                            <p class="small text-muted mb-0">"Excellent work on the frontend components. Clean code, responsive design, and delivered ahead of schedule. Great communication throughout the project."</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-yellow" onclick="rateTeamMember(document.getElementById('viewUserId').value)">Rate Performance</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <!-- Notification Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="notificationToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    <!-- Message will be injected here -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables for data storage
        let projects = [
            { id: 1, name: 'E-commerce Platform', description: 'Full-stack e-commerce solution', progress: 85, team: 6, tasks: 28, completedTasks: 24 },
            { id: 2, name: 'Mobile App', description: 'React Native mobile application', progress: 60, team: 4, tasks: 25, completedTasks: 15 },
            { id: 3, name: 'API Integration', description: 'REST API development', progress: 95, team: 3, tasks: 19, completedTasks: 18 }
        ];

        let tasks = [
            { id: 1, title: 'Fix payment gateway bug', project: 1, priority: 'high', status: 'todo', assignee: 'Sarah Johnson', dueDate: '2024-11-20' },
            { id: 2, title: 'Design user profile page', project: 2, priority: 'medium', status: 'todo', assignee: 'Mike Chen', dueDate: '2024-11-25' },
            { id: 3, title: 'User authentication system', project: 1, priority: 'high', status: 'progress', assignee: 'John Doe', dueDate: '2024-11-18', progress: 70 },
            { id: 4, title: 'API documentation', project: 3, priority: 'low', status: 'progress', assignee: 'Emma Wilson', dueDate: '2024-12-01', progress: 30 }
        ];

        let teamMembers = [
            { id: 1, name: 'Sarah Johnson', email: 'sarah@company.com', role: 'Frontend Developer', projects: 3, tasks: 8, status: 'Active', 
              ratings: [4.5, 4.8, 4.2, 4.6], averageRating: 4.5, totalRatings: 4 },
            { id: 2, name: 'Mike Chen', email: 'mike@company.com', role: 'Backend Developer', projects: 2, tasks: 12, status: 'Active',
              ratings: [4.7, 4.9, 4.3], averageRating: 4.6, totalRatings: 3 },
            { id: 3, name: 'John Doe', email: 'john@company.com', role: 'Full Stack Developer', projects: 4, tasks: 15, status: 'Busy',
              ratings: [4.2, 4.4, 4.6, 4.1, 4.8], averageRating: 4.4, totalRatings: 5 },
            { id: 4, name: 'Emma Wilson', email: 'emma@company.com', role: 'UI/UX Designer', projects: 2, tasks: 6, status: 'Active',
              ratings: [4.9, 4.7], averageRating: 4.8, totalRatings: 2 }
        ];

        let chatMessages = [
            { sender: 'Sarah Johnson', message: 'Good morning everyone! Ready for today\'s sprint review?', time: '10:30 AM', type: 'received' },
            { sender: 'You', message: 'Morning Sarah! Yes, looking forward to seeing the progress on the payment module.', time: '10:32 AM', type: 'sent' },
            { sender: 'Mike Chen', message: 'I\'ve finished the API endpoints for user authentication. Ready for testing!', time: '10:35 AM', type: 'received' }
        ];

        // Navigation functions
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Update navigation
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Project management functions
        function createProject() {
            const form = document.getElementById('createProjectForm');
            const formData = new FormData(form);
            
            // Here you would normally send data to backend
            console.log('Creating project:', Object.fromEntries(formData));
            
            // Close modal and show success message
            const modal = bootstrap.Modal.getInstance(document.getElementById('createProjectModal'));
            modal.hide();
            
            showNotification('Project created successfully!', 'success');
        }

        function editProject(projectId) {
            console.log('Editing project:', projectId);
            // You would populate a modal with existing project data
            showNotification('Edit project functionality would open here', 'info');
        }

        function viewProject(projectId) {
            console.log('Viewing project:', projectId);
            showNotification('Project details would be displayed here', 'info');
        }

        function deleteProject(projectId) {
            if (confirm('Are you sure you want to delete this project?')) {
                console.log('Deleting project:', projectId);
                showNotification('Project deleted successfully!', 'success');
            }
        }

        // Task management functions
        function createTask() {
            const form = document.getElementById('createTaskForm');
            const formData = new FormData(form);
            
            console.log('Creating task:', Object.fromEntries(formData));
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('createTaskModal'));
            modal.hide();
            
            showNotification('Task created successfully!', 'success');
        }

        // Team management functions
        function inviteTeamMember() {
            const form = document.getElementById('inviteTeamForm');
            const formData = new FormData(form);
            
            console.log('Inviting team member:', Object.fromEntries(formData));
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('inviteTeamModal'));
            modal.hide();
            
            showNotification('Invitation sent successfully!', 'success');
        }

        function viewTeamMember(memberId) {
            const member = teamMembers.find(m => m.id == memberId);
            if (member) {
                // Populate the view modal with member data
                document.getElementById('viewUserName').textContent = member.name;
                document.getElementById('viewUserRole').textContent = member.role;
                document.getElementById('viewUserEmail').textContent = member.email;
                document.getElementById('viewUserProjects').textContent = member.projects;
                document.getElementById('viewUserTasks').textContent = member.tasks;
                document.getElementById('viewUserRatingText').textContent = `${member.averageRating} out of 5 (${member.totalRatings} ratings)`;
                
                // Add hidden field for rating button
                let viewUserIdField = document.getElementById('viewUserId');
                if (!viewUserIdField) {
                    viewUserIdField = document.createElement('input');
                    viewUserIdField.type = 'hidden';
                    viewUserIdField.id = 'viewUserId';
                    document.querySelector('#viewTeamMemberModal .modal-body').appendChild(viewUserIdField);
                }
                viewUserIdField.value = memberId;
                
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('viewTeamMemberModal'));
                modal.show();
            }
        }

        function editTeamMember(memberId) {
            console.log('Editing team member:', memberId);
            showNotification('Edit team member functionality would open here', 'info');
        }

        function rateTeamMember(memberId) {
            const member = teamMembers.find(m => m.id == memberId);
            if (member) {
                // Populate the rating modal
                document.getElementById('rateUserName').textContent = member.name;
                document.getElementById('rateUserRole').textContent = member.role;
                document.getElementById('rateMemberId').value = memberId;
                
                // Reset form
                document.getElementById('rateTeamMemberForm').reset();
                document.getElementById('selectedRating').value = '5';
                updateRatingStars(5);
                
                // Hide view modal if open
                const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewTeamMemberModal'));
                if (viewModal) {
                    viewModal.hide();
                }
                
                // Show rating modal
                const ratingModal = new bootstrap.Modal(document.getElementById('rateTeamMemberModal'));
                ratingModal.show();
            }
        }

        function updateRatingStars(rating) {
            const stars = document.querySelectorAll('.rating-star');
            const ratingTexts = ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
            
            document.getElementById('ratingText').textContent = `${ratingTexts[rating - 1]} (${rating}/5)`;
        }

        function submitRating() {
            const form = document.getElementById('rateTeamMemberForm');
            const formData = new FormData(form);
            const memberId = document.getElementById('rateMemberId').value;
            const rating = parseFloat(document.getElementById('selectedRating').value);
            
            // Find the team member and update their ratings
            const memberIndex = teamMembers.findIndex(m => m.id == memberId);
            if (memberIndex !== -1) {
                teamMembers[memberIndex].ratings.push(rating);
                teamMembers[memberIndex].totalRatings = teamMembers[memberIndex].ratings.length;
                
                // Calculate new average rating
                const totalRating = teamMembers[memberIndex].ratings.reduce((sum, r) => sum + r, 0);
                teamMembers[memberIndex].averageRating = Math.round((totalRating / teamMembers[memberIndex].totalRatings) * 10) / 10;
                
                // Update the UI
                updateTeamMemberDisplay();
                
                console.log('Rating submitted:', {
                    memberId: memberId,
                    rating: rating,
                    project: formData.get('rateProject'),
                    codeQuality: formData.get('codeQuality'),
                    communication: formData.get('communication'),
                    punctuality: formData.get('punctuality'),
                    problemSolving: formData.get('problemSolving'),
                    comments: formData.get('ratingComments'),
                    recommend: formData.get('recommendForFuture')
                });
            }
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('rateTeamMemberModal'));
            modal.hide();
            
            showNotification('Rating submitted successfully!', 'success');
        }

        function updateTeamMemberDisplay() {
            // This would update the team member table with new ratings
            // For now, we'll just refresh the page section
            console.log('Updated team member ratings in memory');
        }

        // Chat functions
        function sendMessage() {
            const chatInput = document.getElementById('chatInput');
            const message = chatInput.value.trim();
            
            if (message) {
                const chatMessages = document.getElementById('chatMessages');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'chat-message sent';
                messageDiv.innerHTML = `
                    <strong>You</strong> <small class="text-muted">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                    <div>${message}</div>
                `;
                
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                chatInput.value = '';
            }
        }

        // Calendar functions
        function createEvent() {
            const form = document.getElementById('createEventForm');
            const formData = new FormData(form);
            
            console.log('Creating event:', Object.fromEntries(formData));
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('createEventModal'));
            modal.hide();
            
            showNotification('Event created successfully!', 'success');
        }

        // Utility functions
        function showNotification(message, type = 'info') {
            // Create and show a toast notification
            const toastHTML = `
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            // Create toast container if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }
            
            // Add toast to container
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            
            // Remove toast after it's hidden
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }

        // Filter functions for tasks
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for filters
            document.getElementById('projectFilter').addEventListener('change', filterTasks);
            document.getElementById('statusFilter').addEventListener('change', filterTasks);
            document.getElementById('priorityFilter').addEventListener('change', filterTasks);
            
            // Add enter key support for chat
            document.getElementById('chatInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        });

        function filterTasks() {
            const projectFilter = document.getElementById('projectFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const priorityFilter = document.getElementById('priorityFilter').value;
            
            console.log('Filtering tasks:', { projectFilter, statusFilter, priorityFilter });
            showNotification('Task filters applied', 'info');
        }

        // Initialize tooltips and other Bootstrap components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Auto-scroll chat to bottom
            const chatContainer = document.querySelector('.chat-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
            
            // Initialize rating stars click handlers
            const ratingStars = document.querySelectorAll('.rating-star');
            ratingStars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = index + 1;
                    document.getElementById('selectedRating').value = rating;
                    updateRatingStars(rating);
                });
                
                star.addEventListener('mouseenter', function() {
                    const rating = index + 1;
                    updateRatingStars(rating);
                });
            });
            
            // Reset rating stars on mouse leave
            const ratingContainer = document.querySelector('.rating-stars');
            if (ratingContainer) {
                ratingContainer.addEventListener('mouseleave', function() {
                    const selectedRating = document.getElementById('selectedRating').value;
                    updateRatingStars(selectedRating);
                });
            }
        });
    </script>
</body>
</html>