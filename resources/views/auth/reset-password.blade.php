@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="flex flex-col justify-center h-full px-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h2>
            <p class="text-gray-600">Please enter your new password</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email', $request->email) }}"
                       required
                       readonly
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50 cursor-not-allowed"
                       placeholder="your@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input id="password"
                       name="password"
                       type="password"
                       required
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Enter your new password">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       required
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="Confirm your new password">
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 font-medium transition-colors">
                Reset Password
            </button>
        </form>
    </div>
                    <img class="h-20 w-auto" src="/images/spup.png" alt="SPUP Logo">
                </div>

                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">
                    Reset Password
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter your new password below
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-4">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                value="{{ old('email', request()->email) }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-spup focus:border-green-spup focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                                placeholder="Enter your email address"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            New Password
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-spup focus:border-green-spup focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                                placeholder="Enter new password"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button
                                    type="button"
                                    onclick="togglePassword('password')"
                                    class="text-gray-400 hover:text-gray-600 focus:outline-none"
                                >
                                    <i class="fas fa-eye" id="password-toggle"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm New Password
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-spup focus:border-green-spup focus:z-10 sm:text-sm"
                                placeholder="Confirm new password"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button
                                    type="button"
                                    onclick="togglePassword('password_confirmation')"
                                    class="text-gray-400 hover:text-gray-600 focus:outline-none"
                                >
                                    <i class="fas fa-eye" id="password_confirmation-toggle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-spup hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-spup transition-all duration-200 ease-in-out transform hover:scale-[1.02]"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-key text-green-100 group-hover:text-white"></i>
                        </span>
                        Reset Password
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-green-spup hover:text-green-900 font-medium text-sm transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Login
                    </a>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                    <img src="/images/osa.png" alt="OSA Logo" class="h-8 w-auto">
                    <span>Office of Student Affairs</span>
                </div>
                <p class="mt-2 text-xs text-gray-400">
                    St. Paul University Philippines - E-Portfolio System
                </p>
            </div>
        </div>
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

    <!-- Add subtle animations -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .max-w-md {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Custom focus styles for better accessibility */
        input:focus {
            box-shadow: 0 0 0 3px rgba(0, 71, 27, 0.1);
        }

        button:focus {
            box-shadow: 0 0 0 3px rgba(0, 71, 27, 0.3);
        }

        /* Hover effects */
        .group:hover i {
            transform: translateX(2px);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</body>
</html>
