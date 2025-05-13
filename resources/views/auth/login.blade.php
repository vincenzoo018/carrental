<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bridge Method - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <div class="bridge-logo">
                            <div class="bridge-icon">
                                <span class="bridge-span"></span>
                                <span class="bridge-span"></span>
                                <span class="bridge-span"></span>
                            </div>
                            <div class="bridge-text">Bridge Method</div>
                        </div>
                    </div>
                    <h1>Welcome Back</h1>
                    <p>Sign in to your Bridge Method account</p>
                </div>

                <div class="login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Enter your email">
                            </div>
                            @error('email')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="password-header">
                                <label for="password">Password</label>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    Forgot password?
                                </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required autocomplete="current-password"
                                    placeholder="Enter your password">
                                <button type="button" class="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group remember-me">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="remember" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember me</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="login-button">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <div class="login-footer">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </div>
            </div>

            <div class="login-image">
                <div class="image-overlay"></div>
                <div class="car-animation">
                    <div class="car-body"></div>
                    <div class="car-top"></div>
                    <div class="car-window"></div>
                    <div class="car-wheel wheel-left">
                        <div class="wheel-center"></div>
                    </div>
                    <div class="car-wheel wheel-right">
                        <div class="wheel-center"></div>
                    </div>
                </div>
                <div class="login-image-text">
                    <h2>Bridge Method</h2>
                    <p>Welcome to your journey</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const inputField = this.closest('.input-group').querySelector('input');

                    if (inputField) {
                        inputField.type = inputField.type === 'password' ? 'text' : 'password';

                        // Toggle the eye icon
                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye-slash');
                        icon.classList.toggle('fa-eye');
                    }
                });
            });
        });
    </script>
</body>

</html>