@extends('layouts.auth')

@section('title', 'Register - E-Portfolio System')

@section('page-title', 'Join SPUP Community!')

@section('page-description', 'Create your account to start building your academic portfolio and participate in student government activities.')

@section('content')
<div class="fade-in">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
        <p class="text-gray-600">Fill in your information to get started</p>
    </div>

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Personal Information -->
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                <i class="fas fa-user mr-2 text-green-600"></i>
                Personal Information
            </h3>

            <!-- First Name & Last Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        First Name *
                    </label>
                    <input
                        id="first_name"
                        name="first_name"
                        type="text"
                        required
                        class="form-input @error('first_name') border-red-500 @enderror"
                        placeholder="Enter first name"
                        value="{{ old('first_name') }}"
                    >
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name *
                    </label>
                    <input
                        id="last_name"
                        name="last_name"
                        type="text"
                        required
                        class="form-input @error('last_name') border-red-500 @enderror"
                        placeholder="Enter last name"
                        value="{{ old('last_name') }}"
                    >
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address *
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
                        class="form-input pl-10 @error('email') border-red-500 @enderror"
                        placeholder="your.email@spup.edu.ph"
                        value="{{ old('email') }}"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Use your SPUP email address</p>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- ID Number -->
            <div>
                <label for="id_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Student/Employee ID *
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input
                        id="id_number"
                        name="id_number"
                        type="text"
                        required
                        class="form-input pl-10 @error('id_number') border-red-500 @enderror"
                        placeholder="Enter your ID number"
                        value="{{ old('id_number') }}"
                    >
                </div>
                @error('id_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Department -->
            <div>
                <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Department *
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <select
                        id="department_id"
                        name="department_id"
                        required
                        class="form-input pl-10 @error('department_id') border-red-500 @enderror"
                    >
                        <option value="">Select your department</option>
                        <option value="1" {{ old('department_id') == '1' ? 'selected' : '' }}>College of Computer Studies</option>
                        <option value="2" {{ old('department_id') == '2' ? 'selected' : '' }}>College of Business Administration</option>
                        <option value="3" {{ old('department_id') == '3' ? 'selected' : '' }}>College of Liberal Arts</option>
                        <option value="4" {{ old('department_id') == '4' ? 'selected' : '' }}>College of Education</option>
                    </select>
                </div>
                @error('department_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Security Information -->
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                <i class="fas fa-shield-alt mr-2 text-green-600"></i>
                Security Information
            </h3>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password *
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="form-input pl-10 pr-10 @error('password') border-red-500 @enderror"
                        placeholder="Create a strong password"
                    >
                    <button
                        type="button"
                        onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    >
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password-toggle"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password *
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="form-input pl-10 pr-10"
                        placeholder="Confirm your password"
                    >
                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    >
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_confirmation-toggle"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <input
                id="terms"
                name="terms"
                type="checkbox"
                required
                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mt-1"
            >
            <label for="terms" class="ml-2 block text-sm text-gray-700">
                I agree to the
                <a href="#" class="text-green-600 hover:text-green-500 font-medium">Terms of Service</a>
                and
                <a href="#" class="text-green-600 hover:text-green-500 font-medium">Privacy Policy</a>
            </label>
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                Create Account
            </button>
        </div>
    </form>
</div>

<script>
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(inputId + '-toggle');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
