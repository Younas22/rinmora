<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rinmora</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #004499;
            --accent-color: #ff6b35;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Floating Background Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-elements::before {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-elements::after {
            width: 150px;
            height: 150px;
            bottom: 10%;
            right: 10%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Theme Toggle */
        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Brand Section */
        .brand-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 102, 204, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 10px 30px rgba(0, 102, 204, 0.3); }
            50% { box-shadow: 0 10px 30px rgba(0, 102, 204, 0.6); }
            100% { box-shadow: 0 10px 30px rgba(0, 102, 204, 0.3); }
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .brand-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* Form Styles */
        .login-form {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
            background: white;
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #e1e5e9;
            border-left: none;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .input-group-text:hover {
            background: rgba(0, 102, 204, 0.1);
        }

        .form-control:focus + .input-group-text {
            border-color: var(--primary-color);
        }

        /* Login Options */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            margin-right: 8px;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #666;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--secondary-color);
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 204, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn .btn-text {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }

        .login-btn .btn-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Loading State */
        body.loading .login-btn .btn-text {
            opacity: 0;
        }

        body.loading .login-btn .btn-spinner {
            opacity: 1;
        }

        body.loading .login-btn {
            cursor: not-allowed;
        }

        /* Error Messages */
        .invalid-feedback {
            display: block;
            font-size: 0.875rem;
            color: var(--danger-color);
            margin-top: 5px;
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        /* Footer */
        .login-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .login-footer p {
            margin-bottom: 5px;
            color: #666;
            font-size: 0.9rem;
        }

        /* Dark Theme */
        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
        }

        [data-bs-theme="dark"] .login-card {
            background: rgba(30, 30, 46, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        [data-bs-theme="dark"] .brand-title {
            color: #4dabf7;
        }

        [data-bs-theme="dark"] .brand-subtitle {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .form-label {
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .form-control {
            background: rgba(255, 255, 255, 0.1);
            border-color: #495057;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #4dabf7;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border-color: #495057;
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .form-check-label {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .login-footer p {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .login-footer {
            border-top: 1px solid #495057;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-container {
                max-width: 100%;
                padding: 15px;
            }

            .login-card {
                padding: 30px 25px;
            }

            .brand-title {
                font-size: 2rem;
            }

            .brand-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements"></div>

    <!-- Theme Toggle -->
    <button class="theme-toggle" onclick="toggleTheme()">
        <i class="bi bi-moon-fill" id="theme-icon"></i>
    </button>

    <!-- Main Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Brand Section -->
            <div class="brand-logo">
<div class="brand-icon">
    <img src="{{ asset('public/assets/images/profile-pic.png') }}" alt="Profile Pic" style="height: 40px; width: 40px; object-fit: cover;">
</div>

                <h1 class="brand-title">Rinmora</h1>
                <p class="brand-subtitle">Admin Portal</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form class="login-form" id="loginForm" method="POST" action="{{ route('admin.signin.post') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="bi bi-person"></i>
                        Email Address
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter your email address" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i>
                        Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password"
                               placeholder="Enter your password" 
                               required>
                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="bi bi-eye" id="password-toggle"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="login-options">
                    <div class="remember-me">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember"
                               class="form-check-input" 
                               {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="form-check-label">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div> -->

                <button type="submit" class="login-btn">
                    <span class="btn-text">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Sign In to Dashboard
                    </span>
                    <div class="btn-spinner">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </button>
            </form>

            <!-- Footer -->
            <!-- <div class="login-footer">
                <p>&copy; 2025 SkyBooking Travel. All rights reserved.</p>
                <p>Secure admin access for authorized personnel only</p>
            </div> -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Theme toggle functionality
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            const themeIcon = document.getElementById('theme-icon');
            
            html.setAttribute('data-bs-theme', newTheme);
            themeIcon.className = newTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            
            // Save theme preference
            localStorage.setItem('theme', newTheme);
        }

        // Load saved theme
        function loadTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            
            html.setAttribute('data-bs-theme', savedTheme);
            if (themeIcon) {
                themeIcon.className = savedTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            }
        }

        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordToggle.className = 'bi bi-eye';
            }
        }

    

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTheme();
            
            // Add focus effects to form controls
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });

        // Floating animation for background elements
        setInterval(() => {
            const elements = document.querySelector('.floating-elements');
            if (elements) {
                elements.style.transform = `rotate(${Math.sin(Date.now() * 0.001) * 2}deg)`;
            }
        }, 50);

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>