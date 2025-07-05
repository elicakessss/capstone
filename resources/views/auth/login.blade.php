@extends('layouts.auth')

@section('title', 'Login - E-Portfolio System')

@section('page-title', 'Welcome Back!')

@section('page-description', 'Sign in to your account to access your portfolio and manage your student government activities.')

@section('content')
<div class="max-w-md">
    <!-- Login Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">LOGIN</h1>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- ID Number or Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                ID Number or Email
            </label>
            <input
                id="email"
                name="email"
                type="text"
                autocomplete="email"
                required
                class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('email') bg-red-50 focus:bg-red-50 @enderror"
                placeholder=""
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                Password
            </label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('password') bg-red-50 focus:bg-red-50 @enderror"
                placeholder=""
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Login Button -->
        <div>
            <x-button type="submit" variant="auth" size="lg" full-width="true">
                LOGIN
            </x-button>
        </div>

        <!-- Forgot Password -->
        <div class="text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-green-800 transition-colors">
                Forgot Password
            </a>
        </div>

        <!-- Mobile Sign Up Section -->
        <div class="md:hidden text-center mt-4 pt-4 border-t border-gray-200">
            <span class="text-sm text-gray-600">Don't have an account? </span>
            <div class="mt-2">
                <x-button variant="auth" size="sm" href="{{ route('register') }}">
                    Sign Up
                </x-button>
            </div>
        </div>

        <!-- Organization Logos -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-center space-x-6">
                <!-- OSA Logo -->
                <div class="flex items-center space-x-1.5">
                    <img src="/images/osa.png" alt="OSA Logo" class="h-5 w-5">
                    <span class="text-xs font-medium text-gray-600">Office of Student Affairs</span>
                </div>

                <!-- PSG Logo -->
                <div class="flex items-center space-x-1.5">
                    <img src="/images/psg.png" alt="PSG Logo" class="h-5 w-5">
                    <span class="text-xs font-medium text-gray-600">Paulinian Student Government</span>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
