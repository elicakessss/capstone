@extends('layouts.auth')

@section('title', 'Registration Pending - E-Portfolio System')

@section('content')
<div class="max-w-md">
    <!-- Success Icon -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Registration Submitted!</h1>
        <p class="text-gray-600">Your account registration request has been successfully submitted.</p>
    </div>

    <!-- Back to Login Button (Full Width, Green) -->
    <div class="text-center">
        <a href="{{ route('login') }}" class="btn btn-green w-full">
            BACK TO LOGIN
        </a>
    </div>
</div>
@endsection
