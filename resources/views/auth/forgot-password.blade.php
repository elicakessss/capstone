@extends('layouts.auth')

@section('title', 'Forgot Password - E-Portfolio System')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">FORGOT PASSWORD</h1>
        <p class="text-gray-600 text-sm">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <input
                id="email"
                name="email"
                type="email"
                autocomplete="email"
                required
                value="{{ old('email') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror"
                placeholder="Enter your email address"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition duration-200"
            >
                Email Password Reset Link
            </button>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center text-sm text-gray-600 pt-4">
            <a href="{{ route('login') }}" class="text-green-600 hover:text-green-500 font-medium">
                ← Back to Login
            </a>
        </div>
    </form>
</div>
