<?php
session_start();
if(isset($_SESSION['login_user']) || isset($_SESSION['login_employer']) || isset($_SESSION['login_admin'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobBoard | Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #18303B;
            --secondary-color: #e9c46a;
            --accent-color: #257059;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Sora', sans-serif;
            background-color: var(--primary-color);
            color: white;
        }
        
        .auth-container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .btn-gold {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .btn-gold:hover {
            background-color: #d4b15f;
            color: var(--primary-color);
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            box-shadow: none;
            border-color: var(--secondary-color);
        }
        
        .nav-tabs .nav-link {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .nav-tabs .nav-link.active {
            color: var(--secondary-color);
            background-color: transparent;
            border-color: var(--secondary-color);
        }
        
        .role-selector .card {
            cursor: pointer;
            transition: all 0.3s;
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .role-selector .card:hover {
            transform: translateY(-5px);
            background-color: rgba(233, 196, 106, 0.1);
        }
        
        .role-selector .card.selected {
            border: 2px solid var(--secondary-color);
            background-color: rgba(233, 196, 106, 0.2);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, 15px); }
            100% { transform: translate(0, -0px); }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 text-center mb-5">
                <!-- <img src="img/jobsConnect.svg" alt="JobsConnect Logo" width="80" class="mb-3"> -->
                <h1 class="display-4">Welcome to JobsBoard</h1>
                <p class="lead">Find your dream job or the perfect candidate</p>
            </div>
            
            <div class="col-md-8 auth-container p-5">
                <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Register</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="authTabsContent">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <form id="loginForm" method="post" action="auth.php">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="loginEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleLoginPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-gold btn-lg" name="login">Login</button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Register Tab -->
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <div class="role-selector mb-4">
                            <h5 class="text-center mb-3">I want to register as:</h5>
                            <div class="row text-center">
                                <div class="col-md-6 mb-3">
                                    <div class="card p-3 role-card" data-role="employer">
                                        <i class="fas fa-briefcase fa-3x mb-2"></i>
                                        <h5>Employer</h5>
                                        <p>Hire talented professionals</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card p-3 role-card" data-role="seeker">
                                        <i class="fas fa-user-tie fa-3x mb-2"></i>
                                        <h5>Job Seeker</h5>
                                        <p>Find your dream job</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Employer Registration Form (Hidden by default) -->
                        <form id="employerRegisterForm" method="post" action="auth.php" style="display: none;">
                            <input type="hidden" name="role" value="employer">
                            <div class="mb-3">
                                <label for="empName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="empName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="empEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="empEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="empPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="empPassword" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleEmpPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-gold btn-lg" name="register">Register as Employer</button>
                            </div>
                        </form>
                        
                        <!-- Job Seeker Registration Form (Hidden by default) -->
                        <form id="seekerRegisterForm" method="post" action="auth.php" style="display: none;">
                            <input type="hidden" name="role" value="seeker">
                            <div class="mb-3">
                                <label for="seekName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="seekName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="seekEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="seekEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="seekPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="seekPassword" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleSeekPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="seekQualification" class="form-label">Qualification</label>
                                <input type="text" class="form-control" id="seekQualification" name="qlf" required>
                            </div>
                            <div class="mb-3">
                                <label for="seekDob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="seekDob" name="dob" required>
                            </div>
                            <div class="mb-3">
                                <label for="seekSkills" class="form-label">Skills (comma separated)</label>
                                <input type="text" class="form-control" id="seekSkills" name="skills" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-gold btn-lg" name="register">Register as Job Seeker</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Role selection
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                
                const role = this.getAttribute('data-role');
                document.getElementById('employerRegisterForm').style.display = role === 'employer' ? 'block' : 'none';
                document.getElementById('seekerRegisterForm').style.display = role === 'seeker' ? 'block' : 'none';
            });
        });

        // Password visibility toggle
        function setupPasswordToggle(buttonId, inputId) {
            const toggleButton = document.getElementById(buttonId);
            const passwordInput = document.getElementById(inputId);
            const icon = toggleButton.querySelector('i');
            
            toggleButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }

        setupPasswordToggle('toggleLoginPassword', 'loginPassword');
        setupPasswordToggle('toggleEmpPassword', 'empPassword');
        setupPasswordToggle('toggleSeekPassword', 'seekPassword');

        // Handle form submissions with fetch API
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, 'login');
        });

        document.getElementById('employerRegisterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, 'register');
        });

        document.getElementById('seekerRegisterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, 'register');
        });

        function submitForm(form, action) {
            const formData = new FormData(form);
            formData.append(action, 'true');
            
            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const toast = new bootstrap.Toast(document.getElementById('liveToast'));
                document.getElementById('toastTitle').textContent = data.type === 'success' ? 'Success' : 'Error';
                document.getElementById('toastMessage').textContent = data.text;
                
                if (data.type === 'success') {
                    document.getElementById('toastTitle').className = 'me-auto text-success';
                    if (action === 'login') {
                        window.location.href = 'dashboard.php';
                    } else {
                        // Show success message and switch to login tab
                        document.getElementById('register-tab').classList.remove('active');
                        document.getElementById('register').classList.remove('show', 'active');
                        document.getElementById('login-tab').classList.add('active');
                        document.getElementById('login').classList.add('show', 'active');
                    }
                } else {
                    document.getElementById('toastTitle').className = 'me-auto text-danger';
                }
                
                toast.show();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Check for URL parameters to show messages
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('message')) {
            const toast = new bootstrap.Toast(document.getElementById('liveToast'));
            document.getElementById('toastTitle').textContent = 'Notification';
            document.getElementById('toastMessage').textContent = decodeURIComponent(urlParams.get('message'));
            
            if (urlParams.has('type') && urlParams.get('type') === 'success') {
                document.getElementById('toastTitle').className = 'me-auto text-success';
            } else {
                document.getElementById('toastTitle').className = 'me-auto text-danger';
            }
            
            toast.show();
        }
    </script>
</body>
</html>
