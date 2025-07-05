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

    <!-- Information Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800 mb-1">What happens next?</h3>
                <p class="text-sm text-blue-700">
                    Your registration request is currently under review by the system administrator.
                    You will receive an email notification once your account has been approved.
                </p>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registration Process</h3>
        <div class="space-y-4">
            <!-- Step 1 - Completed -->
            <div class="flex items-center">
                <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Application Submitted</p>
                    <p class="text-xs text-gray-500">Your registration details have been received</p>
                </div>
            </div>

            <!-- Step 2 - In Progress -->
            <div class="flex items-center">
                <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Admin Review</p>
                    <p class="text-xs text-gray-500">Your application is being reviewed</p>
                </div>
            </div>

            <!-- Step 3 - Pending -->
            <div class="flex items-center">
                <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Account Activation</p>
                    <p class="text-xs text-gray-400">You'll receive login credentials via email</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <h4 class="text-sm font-medium text-gray-900 mb-2">Need Help?</h4>
        <p class="text-xs text-gray-600 mb-2">
            If you have any questions about your registration, please contact:
        </p>
        <div class="text-xs text-gray-700">
            <p>Office of Student Affairs</p>
            <p>Email: osa@spup.edu.ph</p>
        </div>
    </div>

    <!-- Back to Login -->
    <div class="text-center">
        <x-button variant="auth" href="{{ route('login') }}">
            Back to Login
        </x-button>
    </div>
</div>
@endsection
