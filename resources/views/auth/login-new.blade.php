@extends('layouts.auth')

@section('title', 'Login - E-Portfolio System')

@section('page-title', 'Welcome Back!')

@section('page-description', 'Sign in to your account to access your portfolio and manage your student government activities.')

@section('content')
<div class="fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Log in</h1>
        <p class="text-gray-600">Enter your credentials to access your account</p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email Address
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    value="{{ old('email') }}"
                    class="form-input pl-10 @error('email') border-red-500 @enderror"
                    placeholder="Enter your email address"
                >
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    class="form-input pl-10 pr-10 @error('password') border-red-500 @enderror"
                    placeholder="Enter your password"
                >
                <button
                    type="button"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    onclick="togglePassword()"
                >
                    <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input
                    id="remember_me"
                    name="remember"
                    type="checkbox"
                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                    Remember me
                </label>
            </div>

            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                    Forgot your password?
                </a>
            </div>
        </div>

        <!-- Login Button -->
        <div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Log In
            </button>
        </div>
    </form>

    <!-- Social Login -->
    <div class="mt-8">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <div class="mt-6 flex justify-center space-x-4">
            <button class="social-btn">
                <i class="fab fa-google text-red-500"></i>
            </button>
            <button class="social-btn">
                <i class="fab fa-facebook text-blue-600"></i>
            </button>
            <button class="social-btn">
                <i class="fab fa-microsoft text-blue-500"></i>
            </button>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
