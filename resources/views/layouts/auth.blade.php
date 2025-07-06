<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'E-Portfolio System')</title>

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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif !important;
            font-size: 14px;
        }

        .auth-container {
            background: white;
            min-height: 100vh;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            border-radius: 6px;
            font-size: 14px;
            height: 42px;
            min-height: 42px;
            padding: 0 1.5rem;
            gap: 0.5rem;
            transition: transform 0.15s cubic-bezier(0.4,0,0.2,1), background 0.15s, color 0.15s;
            outline: none;
            box-shadow: none;
            border: none;
            cursor: pointer;
            background: #fff;
        }
        .btn:active {
            transform: scale(0.98);
        }
        .btn:focus, .btn:hover {
            transform: scale(1.06);
            z-index: 1;
        }
        .btn-green {
            background: #00471B;
            color: #fff;
        }
        .btn-green i, .btn-green svg {
            color: #fff;
            transition: color 0.15s;
        }
        .btn-green:hover, .btn-green:focus {
            background: #00471B;
            color: #FFD600;
        }
        .btn-green:hover i, .btn-green:focus i,
        .btn-green:hover svg, .btn-green:focus svg {
            color: #FFD600;
        }
        .btn-white {
            background: #fff;
            color: #222;
            border: 1.5px solid #e5e7eb;
        }
        .btn-white i, .btn-white svg {
            color: #222;
        }
        .btn-white:hover, .btn-white:focus {
            background: #f5faff;
            color: #222;
        }
        .btn-white:hover i, .btn-white:focus i,
        .btn-white:hover svg, .btn-white:focus svg {
            color: #222;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 1rem 1.25rem;
            border-radius: 6px !important;
            border: 1.5px solid #e5e7eb !important;
            background: #fff !important;
            font-size: 14px !important;
            line-height: 1.2 !important;
            color: #222;
            margin-bottom: 0.5rem;
            box-shadow: none !important;
            height: 42px !important;
            min-height: 42px !important;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-select {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }
        .form-input:focus, .form-select:focus {
            outline: 2px solid #0a3d1a;
            border-color: #0a3d1a !important;
            background: #f5faff !important;
        }
        .search-input,
        .filter-select {
            font-size: 14px !important;
        }

        .auth-header-link:hover, .auth-header-link:focus {
            text-decoration: none;
        }
    </style>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-container">
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-100 h-20">
        <div class="flex items-center justify-between h-full px-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 flex items-center justify-center">
                    <img src="/images/spup.png" alt="SPUP Logo" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <span class="text-xl font-bold" style="color: #00471B;">St. Paul University Philippines</span>
                    <p class="text-sm" style="color: #00471B;">Paulinian Student Government E-Portfolio and Evaluation System</p>
                </div>
            </div>
            <div class="flex-1"></div>
            <div class="hidden md:flex items-center space-x-4">
                @if(request()->routeIs('login'))
                    <span class="text-sm text-gray-600">Don't have an account?
                        <a href="{{ route('register') }}" class="auth-header-link text-green-#00471B hover:text-yellow-400 font-semibold underline transition-colors duration-150">Register now!</a>
                    </span>
                @elseif(request()->routeIs('register'))
                    <span class="text-sm text-gray-600">Already have an account?
                        <a href="{{ route('login') }}" class="auth-header-link text-green-#00471B hover:text-yellow-400 font-semibold underline transition-colors duration-150">Log in!</a>
                    </span>
                @else
                    <a href="{{ route('login') }}" class="auth-header-link text-green-700 hover:text-yellow-400 font-semibold underline transition-colors duration-150">Log In</a>
                    <a href="{{ route('register') }}" class="auth-header-link text-green-700 hover:text-yellow-400 font-semibold underline transition-colors duration-150">Sign Up</a>
                @endif
            </div>
        </div>
    </header>
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8" style="margin-top: 80px;">
        <div class="w-full max-w-6xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    @yield('content')
                </div>
                <div class="hidden lg:flex bg-white items-center justify-center p-12 rounded-r-2xl">
                    <div class="text-center">
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
