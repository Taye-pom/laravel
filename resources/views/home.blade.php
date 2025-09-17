<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous">
    <link rel="shortcut icon" href="project/logo.png" type="image/x-icon">
    <title>Yachad | Collaborate Smarter</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            transition: all 0.3s ease-in-out;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            font-weight: 500;
            color: #4e4d4d !important;
            transition: all 0.3s ease-in-out;
        }
        .nav-link:hover {
            color: #ffc107 !important;
            transform: scale(1.1);
        }
        .navbar-brand img {
            width: 30px;
            margin-right: 10px;
        }
        #home {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        #home::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://source.unsplash.com/random/1920x1080/?teamwork') no-repeat center center/cover;
            opacity: 0.2;
            z-index: 1;
        }
        #home .container {
            position: relative;
            z-index: 2;
        }
        h1, h2 {
            color: #272626;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        .hero-img {
            max-width: 100%;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .card-dev {
            border-radius: 1rem;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid rgba(255, 193, 7, 0.7);
            background: #fff;
        }
        .card-dev:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }
        .badge-skill {
            background-color: seagreen;
            margin-right: 5px;
            padding: 6px 12px;
            border-radius: 12px;
        }
        .card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-title {
            font-weight: bold;
        }
        footer {
            background-color: #1b1b1b;
            color: #fff;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #272626;
            font-weight: 500;
        }
        .btn-warning:hover {
            background-color: #ffca2c;
            border-color: #ffca2c;
            color: #272626;
        }
        .btn-outline-warning {
            border-color: #ffc107;
            color: #ffc107;
        }
        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #272626;
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            background-color: #ffc107;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }
        @media (max-width: 768px) {
            #home {
                height: auto;
                padding: 50px 0;
            }
            .hero-img {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning px-4 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#home"><img src="{{ asset('project/logo.png') }}" alt="Yachad Logo">Yachad</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks" aria-controls="navLinks" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navLinks">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features"><i class="fas fa-star me-1"></i>Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#developers"><i class="fas fa-users me-1"></i>Developers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact"><i class="fas fa-phone me-1"></i>Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#signupModal"><i class="fas fa-user-plus me-1"></i>Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login to Yachad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="userType" class="form-label">User Type</label>
                            <select class="form-select" id="userType" name="userType" required>
                                <option value="" disabled selected>Select user type</option>
                                <option value="developer">Developer</option>
                                <option value="project_manager">Project Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div> --}}
                        <button type="submit" class="btn btn-warning w-100">Login</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot Password?</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Your Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm" action="/reset-password" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="forgotPasswordEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="forgotPasswordEmail" name="email" required>
                            <small class="form-text text-muted">Enter your email address, and we'll send you a link to reset your password.</small>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Send Reset Link</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <p>Back to <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupModalLabel">Sign Up for Yachad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" action="{{route('signup')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="signupName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="signupName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="signupEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="signupPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="signupUserType" class="form-label">User Type</label>
                            <select class="form-select" id="signupUserType" name="userType" required>
                                <option value="" disabled selected>Select user type</option>
                                <option value="developer">Developer</option>
                                <option value="project_manager">Project Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Sign Up</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <p>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <section id="home" class="container-fluid py-5 d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center text-md-start p-4">
                    <h1 class="fw-bold mb-3 animate__animated animate__fadeIn">Collaborate, Build & Deliver Better with Yachad</h1>
                    <p class="lead mb-4">A modern task management platform for software teams to collaborate efficiently — faster, simpler, and more powerful than ever.</p>
                    <div class="mt-4">
                        <a href="#" class強="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#signupModal">Start for Free</a>
                        <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('project/twoP.jpg') }}" alt="Teamwork illustration" class="img-fluid hero-img">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5 bg-white text-center">
        <div class="container">
            <h2 class="mb-5 fw-bold">Why Choose Yachad?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">All-in-One Collaboration</h5>
                            <p class="card-text">Manage projects, track tasks, review code, and communicate seamlessly in one unified platform.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-code fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Advanced Code Review</h5>
                            <p class="card-text">AI-assisted code suggestions and detailed merge insights to ship quality code faster.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Built for Teams</h5>
                            <p class="card-text">Real-time chat, shared repositories, team dashboards, and smart permissions for secure collaboration.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="developers" class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="mb-5 fw-bold">Our Talented Developers</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-dev h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Kom Laura</h5>
                            <p><strong>Skills:</strong>
                                <span class="badge badge-skill">Node.js</span>
                                <span class="badge badge-skill">Django</span>
                                <span class="badge badge-skill">React</span>
                            </p>
                            <p><strong>Rating:</strong> <span class="text-warning">★★★★☆ (4.0)</span></p>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Select Developer</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-dev h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Tatezieu Briel</h5>
                            <p><strong>Skills:</strong>
                                <span class="badge badge-skill">Node.js</span>
                                <span class="badge badge-skill">Laravel</span>
                                <span class="badge badge-skill">React</span>
                            </p>
                            <p><strong>Rating:</strong> <span class="text-warning">★★★☆☆ (3.0)</span></p>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Select Developer</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-dev h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Ngadeu Grace</h5>
                            <p><strong>Skills:</strong>
                                <span class="badge badge-skill">Node.js</span>
                                <span class="badge badge-skill">React</span>
                                <span class="badge badge-skill">MySQL</span>
                            </p>
                            <p><strong>Rating:</strong> <span class="text-warning">★★☆☆☆ (2.5)</span></p>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Select Developer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-5 bg-white text-center">
        <div class="container">
            <h2 class="mb-5 fw-bold">Get in Touch</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="/contact" method="POST">
                        <div class="mb-3">
                            <label for="contactName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="contactName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="contactEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactMessage" class="form-label">Message</label>
                            <textarea class="form-control" id="contactMessage" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light text-center py-4">
        <p class="mb-1">© 2025 Yachad. All Rights Reserved.</p>
        <p class="small">Made with ❤️ for developers who build together.</p>
        <div class="mt-2">
            <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-light me-3"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="text-light"><i class="fab fa-github"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Smooth scrolling for nav links
        document.querySelectorAll('a.nav-link[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Form submission handling (placeholder for frontend demo)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const userType = document.getElementById('userType').value;
            alert(`Logging in as ${userType}! Redirecting to ${userType} dashboard...`);
            // In a real app, this would send a request to the backend
            window.location.href = `/dashboard/${userType}`;
        });

        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Sign up successful! Please log in.');
            // Close signup modal and open login modal
            const signupModal = bootstrap.Modal.getInstance(document.getElementById('signupModal'));
            signupModal.hide();
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });

        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('forgotPasswordEmail').value;
            alert(`Password reset link sent to ${email}!`);
            // Close forgot password modal and open login modal
            const forgotPasswordModal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
            forgotPasswordModal.hide();
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });
    </script>
</body>
</html>