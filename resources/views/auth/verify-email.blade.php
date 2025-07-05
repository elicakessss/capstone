<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - E-Portfolio System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Product+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green': {
                            800: '#00471B',
                            900: '#003d17',
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            600: '#16a34a',
                            'spup': '#00471B',
                        },
                        'red': {
                            600: '#dc2626',
                            700: '#b91c1c',
                        },
                        'yellow': {
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    },
                    fontFamily: {
                        'sans': ['Product Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-sans">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <!-- SPUP Logo -->
                <div class="flex justify-center">
                    <img class="h-20 w-auto" src="/images/spup.png" alt="SPUP Logo">
                </div>

                <div class="text-center">
                    <div class="mx-auto h-16 w-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-envelope-open-text text-yellow-500 text-2xl"></i>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-900">
                        Verify Your Email Address
                    </h2>
                    <p class="mt-4 text-sm text-gray-600">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </p>
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="block sm:inline">A new verification link has been sent to your email address.</span>
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Resend Verification Email Form -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-spup hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-spup transition-all duration-200 ease-in-out transform hover:scale-[1.02]"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-paper-plane text-green-100 group-hover:text-white"></i>
                        </span>
                        Resend Verification Email
                    </button>
                </form>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-spup transition-all duration-200"
                    >
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Log Out
                    </button>
                </form>
            </div>

            <!-- Help Text -->
            <div class="text-center">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-400 mr-2 mt-0.5"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium">Having trouble?</p>
                            <p class="mt-1">
                                Check your spam folder or contact support if you don't receive the verification email within a few minutes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

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

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .8;
            }
        }

        .max-w-md {
            animation: fadeInUp 0.8s ease-out;
        }

        .h-16.w-16 {
            animation: pulse 2s infinite;
        }

        /* Custom focus styles for better accessibility */
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
