@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100 py-5">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <i class="bi bi-people-fill text-primary" style="font-size: 3rem;"></i>
                <h2 class="mt-2 fw-bold">MMS - Membership Management System</h2>
                <p class="text-muted">Sign in to access your account</p>
            </div>
            
            <div class="card shadow-lg border-0 rounded-4 login-card">
                <div class="card-body p-5">
                    <h4 class="card-title text-center mb-4 fw-bold">Welcome Back</h4>
                    
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope-fill text-muted"></i>
                                </span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                <button type="button" class="input-group-text bg-light border-start-0" id="togglePassword">
                                    <i class="bi bi-eye-slash-fill text-muted"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Sign In') }}
                            </button>
                        </div>
                        
                        @if (Route::has('register'))
                        <div class="text-center mt-4">
                            <span class="text-muted">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none ms-1">Register now</a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4 text-muted small">
                <p>&copy; {{ date('Y') }} MMS - All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
    }
    
    .login-card {
        transition: all 0.3s ease;
    }
    
    .login-card:hover {
        transform: translateY(-5px);
    }
    
    .form-control {
        padding: 0.75rem 1rem;
    }
    
    .input-group-text {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .btn-primary {
        background: linear-gradient(to right, #1a237e, #283593);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(to right, #283593, #1a237e);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function () {
            // Toggle the password visibility
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the icon
            this.querySelector('i').classList.toggle('bi-eye-fill');
            this.querySelector('i').classList.toggle('bi-eye-slash-fill');
        });
    });
</script>
@endsection
@endsection
