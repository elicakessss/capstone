@extends('layouts.auth')

@section('title', 'Register - E-Portfolio System')

@section('content')
<div class="mx-auto" style="max-width:600px;">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">REGISTER</h1>
    </div>
    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-row mb-4" style="display: flex; gap: 1rem;">
            <div class="form-col" style="flex: 1;">
                <label for="first_name" class="form-label">First Name</label>
                <input
                    id="first_name"
                    name="first_name"
                    type="text"
                    required
                    class="form-input @error('first_name') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder="Enter first name"
                >
                @error('first_name')
                    <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-col" style="flex: 1;">
                <label for="last_name" class="form-label">Last Name</label>
                <input
                    id="last_name"
                    name="last_name"
                    type="text"
                    required
                    class="form-input @error('last_name') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder="Enter last name"
                >
                @error('last_name')
                    <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-row mb-4" style="display: flex; gap: 1rem;">
            <div class="form-col" style="flex: 1;">
                <label for="id_number" class="form-label">ID Number</label>
                <input
                    id="id_number"
                    name="id_number"
                    type="text"
                    required
                    class="form-input @error('id_number') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder="Enter ID number"
                >
                @error('id_number')
                    <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-col" style="flex: 1;">
                <label for="email" class="form-label">Email Address</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    class="form-input @error('email') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder="Enter email address"
                >
                @error('email')
                    <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="department_id" class="form-label">Department</label>
            <select
                id="department_id"
                name="department_id"
                required
                class="form-select @error('department_id') bg-red-50 focus:bg-red-50 @enderror"
            >
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select @error('role') bg-red-50 focus:bg-red-50 @enderror" required>
                <option value="">Select Role</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="adviser" {{ old('role') == 'adviser' ? 'selected' : '' }}>Adviser</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
            @error('role')
                <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-row mb-4" style="display: flex; gap: 1rem;">
            <div class="form-col" style="flex: 1;">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="form-input @error('password') bg-red-50 focus:bg-red-50 @enderror"
                    placeholder="Enter password"
                >
                @error('password')
                    <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-col" style="flex: 1;">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="form-input"
                    placeholder="Confirm password"
                >
            </div>
        </div>
        <div class="mb-4 flex items-start space-x-3">
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
                <p class="form-error mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <button type="submit" class="btn btn-green w-full">
                SUBMIT REGISTRATION REQUEST
            </button>
        </div>
    </form>
    <!-- Mobile Auth Actions (shown on small screens) -->
    <div class="md:hidden text-center mt-4 pt-4 border-t border-gray-200">
        <span class="text-sm text-gray-600">Already have an account? </span>
        <div class="mt-2">
            <a href="{{ route('login') }}" class="btn btn-green w-full text-sm">Log In</a>
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
