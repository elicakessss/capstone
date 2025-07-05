@extends('layouts.auth')

@section('title', 'Register - E-Portfolio System')

@section('content')
<div class="max-w-md">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">REGISTER</h1>
    </div>

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- First Name & Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    First Name
                </label>
                <input
                    id="first_name"
                    name="first_name"
                    type="text"
                    required
                    class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('first_name') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder=""
                >
                @error('first_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Last Name
                </label>
                <input
                    id="last_name"
                    name="last_name"
                    type="text"
                    required
                    class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('last_name') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder=""
                >
                @error('last_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                Email Address
            </label>
            <input
                id="email"
                name="email"
                type="email"
                autocomplete="email"
                required
                class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('email') bg-red-50 focus:bg-red-50 @enderror"
                placeholder=""
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- ID Number -->
        <div>
            <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1.5">
                Student/Employee ID
            </label>
            <input
                id="id_number"
                name="id_number"
                type="text"
                required
                class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('id_number') bg-red-50 focus:bg-red-50 @enderror"
                placeholder=""
            >
            @error('id_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Department -->
        <div>
            <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                Department
            </label>
            <select
                id="department_id"
                name="department_id"
                required
                class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('department_id') bg-red-50 focus:bg-red-50 @enderror"
            >
                <option value="">Select your department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password & Confirm Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all @error('password') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder=""
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Confirm Password
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-3 py-2.5 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-500 transition-all"
                    placeholder=""
                >
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start space-x-3">
            <input
                id="terms"
                name="terms"
                type="checkbox"
                required
                class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 @error('terms') border-red-300 @enderror"
            >
            <label for="terms" class="text-sm text-gray-700">
                I agree to the
                <a href="#" class="text-green-600 hover:text-green-800 underline">Terms and Conditions</a>
                and
                <a href="#" class="text-green-600 hover:text-green-800 underline">Privacy Policy</a>
            </label>
            @error('terms')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <x-button type="submit" variant="auth" size="lg" full-width="true">
            SUBMIT REGISTRATION REQUEST
        </x-button>
    </form>

    <!-- Mobile Auth Actions (shown on small screens) -->
    <div class="md:hidden text-center mt-4 pt-4 border-t border-gray-200">
        <span class="text-sm text-gray-600">Already have an account? </span>
        <div class="mt-2">
            <x-button variant="auth" size="sm" href="{{ route('login') }}">
                Log In
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
</div>
@endsection
