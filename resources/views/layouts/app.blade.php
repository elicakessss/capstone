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
    
    <!-- Tailwind CSS CDN for testing -->
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
    
    <!-- Custom Styles for Enhanced Interactions -->
    <style>
        /* Custom hover animations */
        .sidebar-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-item:hover {
            transform: scale(1.02) translateX(2px);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 25px -5px rgba(0, 71, 27, 0.1), 0 10px 10px -5px rgba(0, 71, 27, 0.04);
        }
        
        /* Pulse animation for notifications */
        .pulse-yellow {
            animation: pulse-yellow 2s infinite;
        }
        
        @keyframes pulse-yellow {
            0%, 100% {
                opacity: 1;
                background-color: #FFCC00;
            }
            50% {
                opacity: 0.7;
                background-color: #e6b800;
            }
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(0, 71, 27, 0.1);
            border-radius: 2px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 71, 27, 0.3);
            border-radius: 2px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 71, 27, 0.5);
        }
        
        /* Ripple effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Stats Card Pattern - Reusable Class */
        .stats-card {
            @apply bg-white rounded-lg shadow-sm p-6 border-l-4 hover:shadow-lg transition-all duration-200 transform hover:scale-105 cursor-pointer;
        }
        
        .stats-card-green {
            border-color: #00471B;
        }
        
        .stats-card-yellow {
            border-color: #FFCC00;
        }

        /* Stats Card Content Utilities */
        .stat-icon {
            @apply w-12 h-12 rounded-lg flex items-center justify-center;
        }
        
        .stat-icon-blue { @apply bg-blue-100 text-blue-600; }
        .stat-icon-green { @apply bg-green-100 text-green-600; }
        .stat-icon-yellow { @apply bg-yellow-100 text-yellow-600; }
        .stat-icon-purple { @apply bg-purple-100 text-purple-600; }
        .stat-icon-red { @apply bg-red-100 text-red-600; }
        .stat-icon-gray { @apply bg-gray-100 text-gray-600; }
        
        .stat-content { @apply ml-4; }
        .stat-label { @apply text-sm text-gray-600; }
        .stat-value { @apply text-2xl font-bold text-gray-900; }

        /* Form Design Utilities */
        .form-card {
            @apply bg-white rounded-lg shadow-sm border-l-4 border-green-800;
        }
        
        .form-card-header {
            @apply p-6 border-b border-gray-200;
        }
        
        .form-card-title {
            @apply text-lg font-semibold text-gray-900;
        }
        
        .form-card-subtitle {
            @apply text-sm text-gray-600 mt-1;
        }
        
        .form-card-body {
            @apply p-6;
        }
        
        .form-input {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent;
        }
        
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }
        
        .form-label-required::after {
            content: ' *';
            @apply text-red-500;
        }
        
        .form-select {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent;
        }
        
        .form-textarea {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none;
        }
        
        .form-file-area {
            @apply border-2 border-dashed border-gray-300 rounded-md p-6 text-center hover:border-green-400 transition-colors cursor-pointer;
        }
        
        .form-file-icon {
            @apply text-3xl text-gray-400 mb-2;
        }
        
        .form-file-text {
            @apply text-sm text-gray-600 mb-2;
        }
        
        .form-file-button {
            @apply text-sm font-medium transition-colors;
            color: #00471B;
        }
        
        .form-file-button:hover {
            color: #003d17;
        }
        
        .btn {
            @apply inline-flex items-center justify-center font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2;
        }
        
        .btn-primary {
            @apply bg-green-800 text-white hover:bg-green-900 focus:ring-green-500 px-4 py-2 text-sm;
        }
        
        .btn-secondary {
            @apply bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-500 px-4 py-2 text-sm;
        }
        
        .btn-warning {
            @apply text-gray-900 hover:bg-yellow-500 focus:ring-yellow-500 px-4 py-2 text-sm;
            background-color: #FFCC00;
        }
        
        .btn-lg {
            @apply px-6 py-3 text-base;
        }
        
        .btn-sm {
            @apply px-3 py-1.5 text-xs;
        }
    </style>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" style="font-family: 'Product Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div class="flex h-screen overflow-hidden bg-white">
        <!-- Header (Full Width) -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-100 h-20">
            <div class="flex items-center justify-between h-full px-6">
                <!-- Left Side - Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <img src="/images/osa.png" alt="OSA Logo" class="w-10 h-10 object-contain">
                    </div>
                    <div>
                        <span class="text-xl font-bold" style="color: #00471B;">OFFICE OF STUDENT AFFAIRS</span>
                        <p class="text-xs" style="color: #00471B;">Paulinian Student Government E-Portfolio and Evaluation System</p>
                    </div>
                </div>

                <!-- Center - Empty (no breadcrumb) -->
                <div class="flex-1">
                </div>

                <!-- Right Side - User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="p-2 text-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 hover:shadow-lg" style="color: #00471B;">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 h-2 w-2 rounded-full pulse-yellow" style="background-color: #FFCC00;"></span>
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 p-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 hover:shadow-lg" style="color: #00471B;">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="font-medium text-gray-800">{{ Auth::user()->name ?? 'John Doe' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transform translate-x-0 transition-transform duration-300 ease-in-out border-r border-gray-100" style="top: 80px;">
            <div class="flex flex-col h-full">
                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                    <!-- Dashboard (Common to all roles) -->
                    <a href="{{ route('dashboard') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 {{ request()->routeIs('dashboard') ? 'bg-white shadow-md' : 'hover:bg-white hover:shadow-lg' }}" style="color: #00471B;">
                        <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                            <i class="fas fa-home text-lg"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <!-- Admin Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Administration</h3>
                            <div class="space-y-1">
                                <a href="{{ route('admin.departments') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.departments') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-building text-lg"></i>
                                    </div>
                                    <span>Departments</span>
                                </a>
                                <a href="{{ route('admin.councils') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.councils') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <span>Organizations</span>
                                </a>
                                <a href="{{ route('admin.users') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.users') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-user-shield text-lg"></i>
                                    </div>
                                    <span>Users</span>
                                </a>
                            </div>
                        </div>

                        <!-- System Management -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">System Management</h3>
                            <div class="space-y-1">
                                <a href="#" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-chart-bar text-lg"></i>
                                    </div>
                                    <span>Analytics</span>
                                </a>
                                <a href="#" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-cog text-lg"></i>
                                    </div>
                                    <span>System Settings</span>
                                </a>
                            </div>
                        </div>
                    @elseif(auth()->check() && auth()->user()->role === 'adviser')
                        <!-- Adviser Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Management</h3>
                            <div class="space-y-1">
                                <a href="{{ route('adviser.organizations') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('adviser.organizations') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <span>My Organizations</span>
                                </a>
                                <a href="#" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-user-graduate text-lg"></i>
                                    </div>
                                    <span>My Students</span>
                                </a>
                            </div>
                        </div>

                        <!-- Evaluation Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Evaluation</h3>
                            <div class="space-y-1">
                                <a href="{{ route('adviser.evaluations') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('adviser.evaluations') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-clipboard-check text-lg"></i>
                                    </div>
                                    <span>Pending Evaluations</span>
                                </a>
                                <a href="#" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-chart-line text-lg"></i>
                                    </div>
                                    <span>Evaluation Reports</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Student Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Portfolio</h3>
                            <div class="space-y-1">
                                <a href="{{ route('portfolio.index') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('portfolio.*') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-folder-open text-lg"></i>
                                    </div>
                                    <span>My Portfolio</span>
                                </a>
                                <a href="{{ route('portfolio.documents') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('portfolio.documents') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-upload text-lg"></i>
                                    </div>
                                    <span>Upload Documents</span>
                                </a>
                            </div>
                        </div>

                        <!-- Organization Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Organizations</h3>
                            <div class="space-y-1">
                                <a href="{{ route('student.memberships') ?? '#' }}" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('student.memberships') ? 'bg-white shadow-md' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <span>My Memberships</span>
                                </a>
                                <a href="#" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-search text-lg"></i>
                                    </div>
                                    <span>Browse Organizations</span>
                                </a>
                            </div>
                        </div>

                        <!-- Evaluation Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Evaluation</h3>
                            <div class="space-y-1">
                                <a href="#" class="group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-star text-lg"></i>
                                    </div>
                                    <span>My Scores</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </nav>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden ml-64" style="margin-top: 80px;">
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
