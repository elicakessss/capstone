<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Portfolio System')</title>

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
                        'yellow': {
                            400: '#FFCC00',
                            500: '#eab308',
                            600: '#ca8a04',
                            50: '#fefce8',
                            100: '#fef3c7',
                            'spup': '#FFCC00',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Product Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
        }

        .auth-container {
            background: white;
            min-height: 100vh;
        }

        .auth-card {
            background: transparent;
        }

        .form-input {
            @apply w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200;
        }

        .auth-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .logo-container {
            transition: transform 0.2s ease-in-out;
        }

        .logo-container:hover {
            transform: scale(1.05);
        }

        /* Floating animation for illustration */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Subtle animations */
        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

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

        /* Social button styles */
        .social-btn {
            @apply w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-all duration-200 transform hover:scale-110;
        }

        h1, .page-header {
            font-size: 20px !important;
        }

        h2, .section-title {
            font-size: 16px !important;
        }
    </style>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-container">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-100 h-20">
        <div class="flex items-center justify-between h-full px-6">
            <!-- Left Side - Logo/Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 flex items-center justify-center">
                    <img src="/images/spup.png" alt="SPUP Logo" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <span class="text-xl font-bold" style="color: #00471B;">St. Paul University Philippines</span>
                    <p class="text-sm" style="color: #00471B;">Paulinian Student Government E-Portfolio and Evaluation System</p>
                </div>
            </div>

            <!-- Center - Empty (no breadcrumb) -->
            <div class="flex-1">
            </div>

            <!-- Right Side - Auth Actions (Hidden on mobile) -->
            <div class="hidden md:flex items-center space-x-4">
                @if(request()->routeIs('login'))
                    <span class="text-sm text-gray-600">Don't have an account?</span>
                    <x-button variant="auth" size="sm" href="{{ route('register') }}">
                        Sign Up
                    </x-button>
                @elseif(request()->routeIs('register'))
                    <span class="text-sm text-gray-600">Already have an account?</span>
                    <x-button variant="auth" size="sm" href="{{ route('login') }}">
                        Log In
                    </x-button>
                @else
                    <x-button variant="secondary" size="sm" href="{{ route('login') }}">
                        Log In
                    </x-button>
                    <x-button variant="auth" size="sm" href="{{ route('register') }}">
                        Sign Up
                    </x-button>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8" style="margin-top: 80px;">
        <div class="w-full max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">
                <!-- Left Side - Form -->
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    @yield('content')
                </div>

                <!-- Right Side - PSG Logo -->
                <div class="hidden lg:flex bg-white items-center justify-center p-12 rounded-r-2xl">
                    <div class="text-center">
                        <!-- Large PSG Logo Circle -->
                        <div class="floating mb-8">
                            <div class="w-80 h-80 mx-auto">
                                <img src="/images/psg.png" alt="PSG Logo" class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html>
