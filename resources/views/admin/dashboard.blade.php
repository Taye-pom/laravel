<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevCollab Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-yellow: #ffc107;
            --dark-yellow: #ffb300;
            --light-yellow: #fff3cd;
            --yellow-gradient: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            --dark-bg: #1a1a1a;
            --card-bg: #ffffff;
            --text-dark: #333;
            --text-muted: #6c757d;
            --shadow: 0 10px 30px rgba(255, 193, 7, 0.1);
            --hover-shadow: 0 15px 35px rgba(255, 193, 7, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* Navigation Styles */
        .navbar {
            background: var(--yellow-gradient) !important;
            box-shadow: 0 2px 20px rgba(255, 193, 7, 0.3);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--dark-bg) !important;
            text-shadow: none;
        }

        .navbar-nav .nav-link {
            color: var(--dark-bg) !important;
            font-weight: 600;
            margin: 0 0.5rem;
            padding: 0.7rem 1.2rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Main Container */
        .main-container {
            margin-top: 100px;
            padding: 2rem;
        }

        /* Page Sections */
        .page-section {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }

        .page-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dashboard Header */
        .dashboard-header {
            background: var(--yellow-gradient);
            color: var(--dark-bg);
            padding: 2.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .dashboard-header h1 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stats-card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--yellow-gradient);
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-yellow);
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-yellow);
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 1.1rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .stats-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 2rem;
            color: var(--primary-yellow);
            opacity: 0.3;
        }

        /* Content Cards */
        .content-card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 193, 7, 0.1);
        }

        .content-card-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-yellow);
        }

        .content-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        /* Buttons */
        .btn-yellow {
            background: var(--yellow-gradient);
            border: none;
            color: var(--dark-bg);
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }

        .btn-yellow:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
            color: var(--dark-bg);
        }

        .btn-outline-yellow {
            border: 2px solid var(--primary-yellow);
            color: var(--primary-yellow);
            background: transparent;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-outline-yellow:hover {
            background: var(--primary-yellow);
            color: var(--dark-bg);
            transform: translateY(-2px);
        }

        /* Tables */
        .custom-table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .custom-table thead {
            background: var(--yellow-gradient);
            color: var(--dark-bg);
        }

        .custom-table thead th {
            font-weight: 700;
            padding: 1.2rem;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background: var(--light-yellow);
            transform: scale(1.01);
        }

        .custom-table tbody td {
            padding: 1rem 1.2rem;
            border-color: rgba(255, 193, 7, 0.1);
            vertical-align: middle;
        }

        /* Forms */
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.8rem;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: var(--yellow-gradient);
            color: var(--dark-bg);
            border-radius: 15px 15px 0 0;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .modal-body {
            padding: 2rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background: var(--light-yellow);
            color: #856404;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .btn-edit {
            background: #17a2b8;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-view {
            background: #28a745;
            color: white;
        }

        /* Search and Filter */
        .search-filter-section {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .search-input {
            position: relative;
        }

        .search-input i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-input input {
            padding-left: 45px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
                margin-top: 80px;
            }

            .dashboard-header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .content-card {
                padding: 1.5rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-yellow);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-yellow);
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 193, 7, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-yellow);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Alert Styles */
        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
        }

        .alert-warning {
            background: var(--light-yellow);
            color: #856404;
            border-left: 4px solid var(--primary-yellow);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" onclick="showPage('dashboard')">
                <i class="fas fa-shield-alt"></i> DevCollab Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="showPage('dashboard')">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPage('users')">
                            <i class="fas fa-users"></i> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPage('projects')">
                            <i class="fas fa-project-diagram"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPage('developers')">
                            <i class="fas fa-code"></i> Developers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPage('reports')">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPage('settings')">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-shield"></i> Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> Notifications</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Dashboard Page -->
        <div id="dashboardPage" class="page-section active">
            <div class="dashboard-header">
                <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
                <p>Welcome back! Here's what's happening with your development platform today.</p>
            </div>

            <div class="stats-grid">
                <div class="stats-card">
                    <i class="fas fa-users stats-icon"></i>
                    <div class="stats-number" id="totalUsers">156</div>
                    <div class="stats-label">Total Users</div>
                </div>
                <div class="stats-card">
                    <i class="fas fa-project-diagram stats-icon"></i>
                    <div class="stats-number" id="activeProjects">23</div>
                    <div class="stats-label">Active Projects</div>
                </div>
                <div class="stats-card">
                    <i class="fas fa-code stats-icon"></i>
                    <div class="stats-number" id="totalDevelopers">89</div>
                    <div class="stats-label">Developers</div>
                </div>
                <div class="stats-card">
                    <i class="fas fa-tasks stats-icon"></i>
                    <div class="stats-number" id="completedTasks">342</div>
                    <div class="stats-label">Completed Tasks</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">Recent Activity</h3>
                        </div>
                        <div id="recentActivity">
                            <div class="d-flex align-items-center mb-3 p-3 rounded" style="background: var(--light-yellow);">
                                <i class="fas fa-user-plus text-warning me-3 fs-4"></i>
                                <div>
                                    <strong>New developer registered:</strong> John Smith
                                    <br><small class="text-muted">2 hours ago</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <i class="fas fa-project-diagram text-info me-3 fs-4"></i>
                                <div>
                                    <strong>Project completed:</strong> E-commerce Platform
                                    <br><small class="text-muted">5 hours ago</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <i class="fas fa-exclamation-triangle text-danger me-3 fs-4"></i>
                                <div>
                                    <strong>System maintenance:</strong> Database backup completed
                                    <br><small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">Quick Actions</h3>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-yellow" onclick="showCreateUserModal()">
                                <i class="fas fa-user-plus"></i> Add New User
                            </button>
                            <button class="btn btn-outline-yellow" onclick="showCreateProjectModal()">
                                <i class="fas fa-plus"></i> Create Project
                            </button>
                            <button class="btn btn-outline-yellow" onclick="showPage('reports')">
                                <i class="fas fa-download"></i> Generate Report
                            </button>
                            <button class="btn btn-outline-yellow" onclick="showPage('settings')">
                                <i class="fas fa-cog"></i> System Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management Page -->
        <div id="usersPage" class="page-section">
            <div class="dashboard-header">
                <h1><i class="fas fa-users"></i> User Management</h1>
                <p>Manage user accounts, roles, and permissions across the platform.</p>
            </div>

            <div class="search-filter-section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="userSearch" placeholder="Search users...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="pm">Project Manager</option>
                            <option value="developer">Developer</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-yellow w-100" onclick="showCreateUserModal()">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="table-responsive">
                    <table class="table custom-table" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <tr>
                                <td>#001</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                        <strong>John Smith</strong>
                                    </div>
                                </td>
                                <td>john.smith@email.com</td>
                                <td><span class="badge bg-info">Developer</span></td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>Jan 15, 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view" onclick="viewUser(1)" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn btn-edit" onclick="editUser(1)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-delete" onclick="deleteUser(1)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                        <strong>Sarah Johnson</strong>
                                    </div>
                                </td>
                                <td>sarah.johnson@email.com</td>
                                <td><span class="badge bg-primary">Project Manager</span></td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>Feb 10, 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view" onclick="viewUser(2)" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn btn-edit" onclick="editUser(2)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-delete" onclick="deleteUser(2)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#003</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                                        <strong>Mike Wilson</strong>
                                    </div>
                                </td>
                                <td>mike.wilson@email.com</td>
                                <td><span class="badge bg-info">Developer</span></td>
                                <td><span class="status-badge status-inactive">Inactive</span></td>
                                <td>Mar 05, 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view" onclick="viewUser(3)" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn btn-edit" onclick="editUser(3)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-delete" onclick="deleteUser(3)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Projects Page -->
        <div id="projectsPage" class="page-section">
            <div class="dashboard-header">
                <h1><i class="fas fa-project-diagram"></i> Project Management</h1>
                <p>Monitor and manage all development projects in the system.</p>
            </div>

            <div class="search-filter-section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="projectSearch" placeholder="Search projects...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="projectStatusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="on-hold">On Hold</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="priorityFilter">
                            <option value="">All Priorities</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-yellow w-100" onclick="showCreateProjectModal()">
                            <i class="fas fa-plus"></i> New Project
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" id="projectsGrid">
                <div class="col-md-4 mb-3">
                    <div class="content-card h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">E-Commerce Platform</h5>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <p class="text-muted">Full-stack web application for online retail business with payment integration.</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Progress</span>
                                <span>75%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 75%; background: var(--yellow-gradient);"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-3">
                            <small><i class="fas fa-calendar"></i> Due: Dec 30, 2024</small>
                            <small><i class="fas fa-users"></i> 5 Developers</small>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-yellow" onclick="viewProject(1)">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-yellow" onclick="editProject(1)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteProject(1)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="content-card h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">Mobile Banking App</h5>
                            <span class="badge bg-warning">In Progress</span>
                        </div>
                        <p class="text-muted">Secure mobile application for banking services with biometric authentication.</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Progress</span>
                                <span>45%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 45%;"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-3">
                            <small><i class="fas fa-calendar"></i> Due: Jan 15, 2025</small>
                            <small><i class="fas fa-users"></i> 3 Developers</small>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-yellow" onclick="viewProject(2)">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-yellow" onclick="editProject(2)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteProject(2)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="content-card h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">CRM System</h5>
                            <span class="badge bg-secondary">Completed</span>
                        </div>
                        <p class="text-muted">Customer relationship management system with advanced analytics.</p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Progress</span>
                                <span>100%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-muted mb-3">
                            <small><i class="fas fa-calendar"></i> Completed: Nov 20, 2024</small>
                            <small><i class="fas fa-users"></i> 4 Developers</small>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-yellow" onclick="viewProject(3)">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-yellow" onclick="editProject(3)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteProject(3)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Developers Page -->
        <div id="developersPage" class="page-section">
            <div class="dashboard-header">
                <h1><i class="fas fa-code"></i> Developer Management</h1>
                <p>View and manage all developers in the platform with their skills and performance.</p>
            </div>

            <div class="search-filter-section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="developerSearch" placeholder="Search developers...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="skillFilter">
                            <option value="">All Skills</option>
                            <option value="javascript">JavaScript</option>
                            <option value="python">Python</option>
                            <option value="react">React</option>
                            <option value="nodejs">Node.js</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="experienceFilter">
                            <option value="">All Experience</option>
                            <option value="junior">Junior (0-2 years)</option>
                            <option value="mid">Mid-level (3-5 years)</option>
                            <option value="senior">Senior (5+ years)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-yellow w-100" onclick="showInviteDeveloperModal()">
                            <i class="fas fa-user-plus"></i> Invite Dev
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" id="developersGrid">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="content-card h-100">
                        <div class="text-center mb-3">
                            <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Developer">
                            <h5>John Smith</h5>
                            <p class="text-muted mb-1">Full-Stack Developer</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="ms-1">(4.2)</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Skills:</small>
                            <div class="mt-1">
                                <span class="badge bg-warning text-dark me-1">JavaScript</span>
                                <span class="badge bg-warning text-dark me-1">React</span>
                                <span class="badge bg-warning text-dark me-1">Node.js</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between text-muted">
                                <small><i class="fas fa-clock"></i> 3 years exp.</small>
                                <small><i class="fas fa-project-diagram"></i> 12 projects</small>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-yellow" onclick="viewDeveloper(1)">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-yellow" onclick="assignProject(1)">
                                <i class="fas fa-plus"></i> Assign
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="suspendDeveloper(1)">
                                <i class="fas fa-ban"></i> Suspend
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="content-card h-100">
                        <div class="text-center mb-3">
                            <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Developer">
                            <h5>Sarah Johnson</h5>
                            <p class="text-muted mb-1">Frontend Specialist</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="ms-1">(4.8)</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Skills:</small>
                            <div class="mt-1">
                                <span class="badge bg-warning text-dark me-1">React</span>
                                <span class="badge bg-warning text-dark me-1">Vue.js</span>
                                <span class="badge bg-warning text-dark me-1">CSS</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between text-muted">
                                <small><i class="fas fa-clock"></i> 5 years exp.</small>
                                <small><i class="fas fa-project-diagram"></i> 18 projects</small>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-yellow" onclick="viewDeveloper(2)">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-yellow" onclick="assignProject(2)">
                                <i class="fas fa-plus"></i> Assign
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="suspendDeveloper(2)">
                                <i class="fas fa-ban"></i> Suspend
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="content-card h-100">
                        <div class="text-center mb-3">
                            <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Developer">
                            <h5>Mike Davis</h5>
                            <p class="text-muted mb-1">Backend Developer</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="ms-1">(4.0)</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Skills:</small>
                            <div class="mt-1">
                                <span class="badge bg-warning text-dark me-1">Python</span>
                                <span class="badge bg-warning text-dark me-1">Django</span>
                                <span class="badge bg-warning text-dark me-1">PostgreSQL</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between text-muted">
                                <small><i class="fas fa-clock"></i> 4 years exp.</small>
                                <small><i class="fas fa-project-diagram"></i> 15 projects</small>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-outline-yellow" onclick="viewDeveloper(3)">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-sm btn-outline-yellow" onclick="assignProject(3)">
                                <i class="fas fa-plus"></i> Assign
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="suspendDeveloper(3)">
                                <i class="fas fa-ban"></i> Suspend
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Page -->
        <div id="reportsPage" class="page-section">
            <div class="dashboard-header">
                <h1><i class="fas fa-chart-bar"></i> Reports & Analytics</h1>
                <p>Generate comprehensive reports and view system analytics.</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">Performance Metrics</h3>
                        </div>
                        <canvas id="performanceChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">Project Distribution</h3>
                        </div>
                        <canvas id="projectChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">Generate Reports</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-yellow" onclick="generateReport('users')">
                                        <i class="fas fa-users"></i> User Report
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-yellow" onclick="generateReport('projects')">
                                        <i class="fas fa-project-diagram"></i> Project Report
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-yellow" onclick="generateReport('performance')">
                                        <i class="fas fa-chart-line"></i> Performance Report
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-yellow" onclick="generateReport('financial')">
                                        <i class="fas fa-dollar-sign"></i> Financial Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Page -->
        <div id="settingsPage" class="page-section">
            <div class="dashboard-header">
                <h1><i class="fas fa-cog"></i> System Settings</h1>
                <p>Configure system preferences and platform settings.</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">General Settings</h3>
                        </div>
                        <form id="generalSettingsForm">
                            <div class="mb-3">
                                <label class="form-label">Platform Name</label>
                                <input type="text" class="form-control" value="DevCollab" id="platformName">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Admin Email</label>
                                <input type="email" class="form-control" value="admin@devcollab.com" id="adminEmail">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Time Zone</label>
                                <select class="form-control" id="timeZone">
                                    <option value="UTC">UTC</option>
                                    <option value="EST">Eastern Standard Time</option>
                                    <option value="PST">Pacific Standard Time</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                    <label class="form-check-label" for="maintenanceMode">
                                        Maintenance Mode
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-yellow">Save Changes</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">Security Settings</h3>
                        </div>
                        <form id="securitySettingsForm">
                            <div class="mb-3">
                                <label class="form-label">Session Timeout (minutes)</label>
                                <input type="number" class="form-control" value="30" id="sessionTimeout">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Policy</label>
                                <select class="form-control" id="passwordPolicy">
                                    <option value="standard">Standard</option>
                                    <option value="strong">Strong</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="twoFactorAuth" checked>
                                    <label class="form-check-label" for="twoFactorAuth">
                                        Two-Factor Authentication
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="loginNotifications" checked>
                                    <label class="form-check-label" for="loginNotifications">
                                        Login Notifications
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-yellow">Update Security</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3 class="content-card-title">System Information</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td><strong>Version:</strong></td>
                                        <td>DevCollab v2.1.0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Update:</strong></td>
                                        <td>December 1, 2024</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Server Status:</strong></td>
                                        <td><span class="badge bg-success">Online</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Database:</strong></td>
                                        <td>PostgreSQL 14.2</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td><strong>Disk Usage:</strong></td>
                                        <td>45.6 GB / 100 GB</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Memory Usage:</strong></td>
                                        <td>2.1 GB / 8 GB</td>
                                    </tr>
                                    <tr>
                                        <td><strong>CPU Load:</strong></td>
                                        <td>15%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Uptime:</strong></td>
                                        <td>45 days, 12 hours</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Create New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="userEmail" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-control" id="userRole" required>
                                        <option value="">Select Role</option>
                                        <option value="developer">Developer</option>
                                        <option value="pm">Project Manager</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <select class="form-control" id="userDepartment">
                                        <option value="">Select Department</option>
                                        <option value="development">Development</option>
                                        <option value="management">Management</option>
                                        <option value="qa">Quality Assurance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" id="skillsSection" style="display: none;">
                            <label class="form-label">Skills (comma-separated)</label>
                            <input type="text" class="form-control" id="userSkills" placeholder="JavaScript, React, Node.js">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="userPhone">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendWelcomeEmail" checked>
                                <label class="form-check-label" for="sendWelcomeEmail">
                                    Send welcome email with login credentials
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="createUser()">
                        <i class="fas fa-plus"></i> Create User
                    </button>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createProjectForm">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="projectName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="projectDescription" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="projectStartDate" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="projectEndDate" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="form-control" id="projectPriority" required>
                                        <option value="">Select Priority</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Budget ($)</label>
                                    <input type="number" class="form-control" id="projectBudget">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project Manager</label>
                            <select class="form-control" id="projectManager" required>
                                <option value="">Select Project Manager</option>
                                <option value="1">Sarah Johnson</option>
                                <option value="2">Mike Wilson</option>
                                <option value="3">Lisa Brown</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Technologies/Tags</label>
                            <input type="text" class="form-control" id="projectTags" placeholder="React, Node.js, MongoDB">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="createProject()">
                        <i class="fas fa-plus"></i> Create Project
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user"></i> User Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://via.placeholder.com/100" class="rounded-circle mb-3" alt="User Avatar">
                        <h4 id="viewUserName">John Smith</h4>
                        <p class="text-muted" id="viewUserRole">Developer</p>
                    </div>
                    <div id="userDetails">
                        <div class="row mb-2">
                            <div class="col-4"><strong>Status:</strong></div>
                            <div class="col-8"><span class="status-badge status-active">Active</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Joined:</strong></div>
                            <div class="col-8" id="viewUserJoined">Jan 15, 2024</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Projects:</strong></div>
                            <div class="col-8" id="viewUserProjects">5 Active</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Performance:</strong></div>
                            <div class="col-8">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(4.2/5.0)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-yellow" onclick="editUser()">
                        <i class="fas fa-edit"></i> Edit User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="editFirstName" value="John">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="editLastName" value="Smith">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="editUserEmail" value="john.smith@email.com">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-control" id="editUserRole">
                                        <option value="developer" selected>Developer</option>
                                        <option value="pm">Project Manager</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" id="editUserStatus">
                                        <option value="active" selected>Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <input type="text" class="form-control" id="editUserSkills" value="JavaScript, React, Node.js">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editUserPhone" value="+1 555-0123">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="updateUser()">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invite Developer Modal -->
    <div class="modal fade" id="inviteDeveloperModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Invite Developer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="inviteDeveloperForm">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="inviteEmail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Specialization</label>
                            <select class="form-control" id="inviteSpecialization" required>
                                <option value="">Select Specialization</option>
                                <option value="frontend">Frontend Developer</option>
                                <option value="backend">Backend Developer</option>
                                <option value="fullstack">Full-Stack Developer</option>
                                <option value="mobile">Mobile Developer</option>
                                <option value="devops">DevOps Engineer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Required Skills</label>
                            <input type="text" class="form-control" id="inviteSkills" placeholder="React, Node.js, MongoDB">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message (Optional)</label>
                            <textarea class="form-control" id="inviteMessage" rows="3" placeholder="Welcome to our development team..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-yellow" onclick="sendInvite()">
                        <i class="fas fa-paper-plane"></i> Send Invitation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-warning"></i> <strong>Warning:</strong> This will permanently remove all associated data.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let currentPage = 'dashboard';
        let deleteTarget = null;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            showPage('dashboard');
            setupEventListeners();
            initializeCharts();
            updateStats();
        });

        function setupEventListeners() {
            // Navigation click handlers
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Update active nav state
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Search functionality
            document.getElementById('userSearch')?.addEventListener('input', filterUsers);
            document.getElementById('projectSearch')?.addEventListener('input', filterProjects);
            document.getElementById('developerSearch')?.addEventListener('input', filterDevelopers);

            // Form submissions
            document.getElementById('createUserForm')?.addEventListener('submit', handleCreateUser);
            document.getElementById('createProjectForm')?.addEventListener('submit', handleCreateProject);
            document.getElementById('generalSettingsForm')?.addEventListener('submit', handleGeneralSettings);
            document.getElementById('securitySettingsForm')?.addEventListener('submit', handleSecuritySettings);

            // Role change handler for create user form
            document.getElementById('userRole')?.addEventListener('change', function() {
                const skillsSection = document.getElementById('skillsSection');
                if (this.value === 'developer') {
                    skillsSection.style.display = 'block';
                } else {
                    skillsSection.style.display = 'none';
                }
            });
        }

        function showPage(page) {
            // Hide all pages
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show selected page
            const targetPage = document.getElementById(page + 'Page');
            if (targetPage) {
                targetPage.classList.add('active');
                currentPage = page;
            }
        }

        function updateStats() {
            // Simulate real-time updates
            setInterval(() => {
                const stats = {
                    totalUsers: Math.floor(Math.random() * 10) + 150,
                    activeProjects: Math.floor(Math.random() * 5) + 20,
                    totalDevelopers: Math.floor(Math.random() * 8) + 85,
                    completedTasks: Math.floor(Math.random() * 20) + 340
                };

                Object.keys(stats).forEach(key => {
                    const element = document.getElementById(key);
                    if (element) {
                        element.textContent = stats[key];
                    }
                });
            }, 30000); // Update every 30 seconds
        }

        function initializeCharts() {
            // This is a placeholder for chart initialization
            // In a real application, you would use Chart.js or similar library
            console.log('Charts initialized');
        }

        // User Management Functions
        function showCreateUserModal() {
            const modal = new bootstrap.Modal(document.getElementById('createUserModal'));
            modal.show();
        }

        function createUser() {
            const formData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('userEmail').value,
                role: document.getElementById('userRole').value,
                department: document.getElementById('userDepartment').value,
                skills: document.getElementById('userSkills').value,
                phone: document.getElementById('userPhone').value,
                sendWelcome: document.getElementById('sendWelcomeEmail').checked
            };

            if (validateUserForm(formData)) {
                // Simulate user creation
                addUserToTable(formData);
                
                // Close modal and show success
                const modal = bootstrap.Modal.getInstance(document.getElementById('createUserModal'));
                modal.hide();
                
                showAlert('User created successfully!', 'success');
                document.getElementById('createUserForm').reset();
            }
        }

        function validateUserForm(formData) {
            if (!formData.firstName || !formData.lastName || !formData.email || !formData.role) {
                showAlert('Please fill in all required fields', 'error');
                return false;
            }
            
            if (!isValidEmail(formData.email)) {
                showAlert('Please enter a valid email address', 'error');
                return false;
            }
            
            return true;
        }

        function addUserToTable(userData) {
            const tableBody = document.getElementById('usersTableBody');
            const newRow = document.createElement('tr');
            const userId = Date.now(); // Simple ID generation
            
            newRow.innerHTML = `
                <td>#${String(userId).slice(-3)}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                        <strong>${userData.firstName} ${userData.lastName}</strong>
                    </div>
                </td>
                <td>${userData.email}</td>
                <td><span class="badge ${getRoleBadgeClass(userData.role)}">${userData.role}</span></td>
                <td><span class="status-badge status-active">Active</span></td>
                <td>${new Date().toLocaleDateString()}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewUser(${userId})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn btn-edit" onclick="editUser(${userId})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn btn-delete" onclick="deleteUser(${userId})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        function getRoleBadgeClass(role) {
            const classes = {
                'developer': 'bg-info',
                'pm': 'bg-primary',
                'admin': 'bg-success'
            };
            return classes[role] || 'bg-secondary';
        }

        function viewUser(userId) {
            const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
            modal.show();
        }

        function editUser(userId) {
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        }

        function updateUser() {
            const formData = {
                firstName: document.getElementById('editFirstName').value,
                lastName: document.getElementById('editLastName').value,
                email: document.getElementById('editUserEmail').value,
                role: document.getElementById('editUserRole').value,
                status: document.getElementById('editUserStatus').value,
                skills: document.getElementById('editUserSkills').value,
                phone: document.getElementById('editUserPhone').value
            };

            // Simulate update
            showAlert('User updated successfully!', 'success');
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();
        }

        function deleteUser(userId) {
            deleteTarget = { type: 'user', id: userId };
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
            
            document.getElementById('confirmDeleteBtn').onclick = function() {
                // Remove from table
                const row = event.target.closest('tr');
                if (row) {
                    row.remove();
                }
                
                showAlert('User deleted successfully!', 'success');
                modal.hide();
            };
        }

        // Project Management Functions
        function showCreateProjectModal() {
            const modal = new bootstrap.Modal(document.getElementById('createProjectModal'));
            modal.show();
        }

        function createProject() {
            const formData = {
                name: document.getElementById('projectName').value,
                description: document.getElementById('projectDescription').value,
                startDate: document.getElementById('projectStartDate').value,
                endDate: document.getElementById('projectEndDate').value,
                priority: document.getElementById('projectPriority').value,
                budget: document.getElementById('projectBudget').value,
                manager: document.getElementById('projectManager').value,
                tags: document.getElementById('projectTags').value
            };

            if (validateProjectForm(formData)) {
                addProjectToGrid(formData);
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('createProjectModal'));
                modal.hide();
                
                showAlert('Project created successfully!', 'success');
                document.getElementById('createProjectForm').reset();
            }
        }

        function validateProjectForm(formData) {
            if (!formData.name || !formData.description || !formData.startDate || 
                !formData.endDate || !formData.priority || !formData.manager) {
                showAlert('Please fill in all required fields', 'error');
                return false;
            }
            
            if (new Date(formData.startDate) >= new Date(formData.endDate)) {
                showAlert('End date must be after start date', 'error');
                return false;
            }
            
            return true;
        }

        function addProjectToGrid(projectData) {
            const projectsGrid = document.getElementById('projectsGrid');
            const newProject = document.createElement('div');
            newProject.className = 'col-md-4 mb-3';
            
            newProject.innerHTML = `
                <div class="content-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title">${projectData.name}</h5>
                        <span class="badge bg-warning">New</span>
                    </div>
                    <p class="text-muted">${projectData.description}</p>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Progress</span>
                            <span>0%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: 0%; background: var(--yellow-gradient);"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between text-muted mb-3">
                        <small><i class="fas fa-calendar"></i> Due: ${new Date(projectData.endDate).toLocaleDateString()}</small>
                        <small><i class="fas fa-users"></i> 0 Developers</small>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-sm btn-outline-yellow" onclick="viewProject(${Date.now()})">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-yellow" onclick="editProject(${Date.now()})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteProject(${Date.now()})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;
            
            projectsGrid.appendChild(newProject);
        }

        function viewProject(projectId) {
            showAlert('Project details view - Feature coming soon!', 'info');
        }

        function editProject(projectId) {
            showAlert('Project edit - Feature coming soon!', 'info');
        }

        function deleteProject(projectId) {
            deleteTarget = { type: 'project', id: projectId };
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
            
            document.getElementById('confirmDeleteBtn').onclick = function() {
                const projectCard = event.target.closest('.col-md-4');
                if (projectCard) {
                    projectCard.remove();
                }
                
                showAlert('Project deleted successfully!', 'success');
                modal.hide();
            };
        }

        // Developer Management Functions
        function showInviteDeveloperModal() {
            const modal = new bootstrap.Modal(document.getElementById('inviteDeveloperModal'));
            modal.show();
        }

        function sendInvite() {
            const email = document.getElementById('inviteEmail').value;
            const specialization = document.getElementById('inviteSpecialization').value;
            const skills = document.getElementById('inviteSkills').value;
            const message = document.getElementById('inviteMessage').value;

            if (!email || !specialization) {
                showAlert('Please fill in email and specialization', 'error');
                return;
            }

            if (!isValidEmail(email)) {
                showAlert('Please enter a valid email address', 'error');
                return;
            }

            // Simulate sending invitation
            const modal = bootstrap.Modal.getInstance(document.getElementById('inviteDeveloperModal'));
            modal.hide();
            
            showAlert('Invitation sent successfully!', 'success');
            document.getElementById('inviteDeveloperForm').reset();
        }

        function viewDeveloper(developerId) {
            showAlert('Developer profile view - Feature coming soon!', 'info');
        }

        function assignProject(developerId) {
            showAlert('Project assignment - Feature coming soon!', 'info');
        }

        function suspendDeveloper(developerId) {
            const confirmSuspend = confirm('Are you sure you want to suspend this developer?');
            if (confirmSuspend) {
                showAlert('Developer suspended successfully!', 'warning');
            }
        }

        // Filter Functions
        function filterUsers() {
            const searchTerm = document.getElementById('userSearch').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            
            const rows = document.querySelectorAll('#usersTableBody tr');
            
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                const role = row.cells[3].textContent.toLowerCase();
                const status = row.cells[4].textContent.toLowerCase();
                
                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = !roleFilter || role.includes(roleFilter.toLowerCase());
                const matchesStatus = !statusFilter || status.includes(statusFilter.toLowerCase());
                
                row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
            });
        }

        function filterProjects() {
            const searchTerm = document.getElementById('projectSearch').value.toLowerCase();
            const projects = document.querySelectorAll('#projectsGrid .col-md-4');
            
            projects.forEach(project => {
                const title = project.querySelector('.card-title').textContent.toLowerCase();
                const description = project.querySelector('.text-muted').textContent.toLowerCase();
                
                const matches = title.includes(searchTerm) || description.includes(searchTerm);
                project.style.display = matches ? '' : 'none';
            });
        }

        function filterDevelopers() {
            const searchTerm = document.getElementById('developerSearch').value.toLowerCase();
            const developers = document.querySelectorAll('#developersGrid .col-md-6');
            
            developers.forEach(developer => {
                const name = developer.querySelector('h5').textContent.toLowerCase();
                const role = developer.querySelector('.text-muted').textContent.toLowerCase();
                
                const matches = name.includes(searchTerm) || role.includes(searchTerm);
                developer.style.display = matches ? '' : 'none';
            });
        }

        // Settings Functions
        function handleGeneralSettings(e) {
            e.preventDefault();
            showAlert('General settings saved successfully!', 'success');
        }

        function handleSecuritySettings(e) {
            e.preventDefault();
            showAlert('Security settings updated successfully!', 'success');
        }

        // Report Generation Functions
        function generateReport(type) {
            showAlert(`Generating ${type} report... Please wait.`, 'info');
            
            setTimeout(() => {
                showAlert(`${type.charAt(0).toUpperCase() + type.slice(1)} report generated successfully!`, 'success');
            }, 2000);
        }

        // Utility Functions
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type === 'info' ? 'info' : type === 'warning' ? 'warning' : 'success'} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 120px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Form submission handlers
        function handleCreateUser(e) {
            e.preventDefault();
            createUser();
        }

        function handleCreateProject(e) {
            e.preventDefault();
            createProject();
        }
    </script>
</body>
</html>