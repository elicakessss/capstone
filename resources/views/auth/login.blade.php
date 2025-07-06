@extends('layouts.auth')

@section('title', 'Login - E-Portfolio System')

@section('content')
<div class="mx-auto" style="max-width:600px;">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">LOGIN</h1>
    </div>
    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">ID Number or Email</label>
            <input
                id="email"
                name="email"
                type="text"
                autocomplete="email"
                required
                class="form-input @error('email') bg-red-50 focus:bg-red-50 @enderror"
                placeholder="Enter ID number or email"
            >
            @error('email')
                <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="form-input @error('password') bg-red-50 focus:bg-red-50 @enderror"
                placeholder="Enter password"
            >
            @error('password')
                <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>
            <div>
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-green-800 underline">Forgot Password?</a>
            </div>
        </div>
        <div class="mb-4">
            <button type="submit" class="btn btn-green w-full">
                LOGIN
            </button>
        </div>
    </form>
    <!-- Mobile Auth Actions (shown on small screens) -->
    <div class="md:hidden text-center mt-4 pt-4 border-t border-gray-200">
        <span class="text-sm text-gray-600">Don't have an account? </span>
        <div class="mt-2">
            <a href="{{ route('register') }}" class="btn btn-green w-full text-sm">Sign Up</a>
        </div>
    </div>
    <!-- Organization Logos below form -->
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
</div>
@endsection
