@extends('layouts.register')

@section('content')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">

<div class="registration-container">
    <div class="registration-card">
        <div class="brand-area">
            <h1 class="brand-title">Bridge Method</h1>
            <p class="brand-tagline">Premium Car Rental Service</p>

        </div>

        <div class="form-area">
            <h2 class="form-title">Create Your Account</h2>
            <p class="form-subtitle">Join us to start renting premium vehicles</p>

            @if($errors->any())
            <div class="alert-error">
                <strong>Please fix these errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group half">
                        <label for="firstName">First Name</label>
                        <div class="input-group">
                            <i class="input-icon fas fa-user"></i>
                            <input type="text" id="firstName" name="first_name"
                                value="{{ old('first_name') }}" required>
                        </div>
                        @error('first_name')
                        <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="lastName">Last Name</label>
                        <div class="input-group">
                            <i class="input-icon fas fa-user"></i>
                            <input type="text" id="lastName" name="last_name"
                                value="{{ old('last_name') }}" required>
                        </div>
                        @error('last_name')
                        <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-phone"></i>
                        <input type="tel" id="phone" name="phone_number"
                            value="{{ old('phone_number') }}" required>
                    </div>
                    @error('phone_number')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-map-marker-alt"></i>
                        <input type="text" id="address" name="address"
                            value="{{ old('address') }}" required>
                    </div>
                    @error('address')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="license">Driver's License Number</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-id-card"></i>
                        <input type="text" id="license" name="license"
                            value="{{ old('license') }}" required>
                    </div>
                    @error('license')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                    <div class="input-hint">Minimum 8 characters with at least one number</div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="confirmPassword" name="password_confirmation" required>
                        <button type="button" class="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="{{ route('terms') }}">Terms and Conditions</a>
                    </label>
                    @error('terms')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>

                <div class="login-link">
                    <p>Already have an account?</p>
                    <a href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const inputField = this.closest('.input-group').querySelector('input');

                if (inputField) {
                    inputField.type = inputField.type === 'password' ? 'text' : 'password';

                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye-slash');
                    icon.classList.toggle('fa-eye');
                }
            });
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            const x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    });
</script>
@endsection
@endsection
