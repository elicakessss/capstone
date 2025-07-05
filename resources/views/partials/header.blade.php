<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-100">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Left Side - Mobile Menu Button & Breadcrumbs -->
        <div class="flex items-center space-x-4">
            <!-- Mobile menu button -->
            <button id="sidebar-toggle" onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-gray-600 hover:text-green-800 hover:bg-green-50 transition-colors">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <!-- Breadcrumbs -->
            <nav class="hidden md:flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    @if(isset($breadcrumbs))
                        @foreach($breadcrumbs as $index => $breadcrumb)
                            <li class="flex items-center">
                                @if($index > 0)
                                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                                @endif
                                @if($loop->last)
                                    <span class="text-sm font-medium text-green-800">{{ $breadcrumb['title'] }}</span>
                                @else
                                    <a href="{{ $breadcrumb['url'] }}" class="text-sm font-medium text-gray-500 hover:text-green-800 transition-colors">
                                        {{ $breadcrumb['title'] }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @else
                        <li>
                            <span class="text-sm font-medium text-green-800">@yield('page-title', 'Dashboard')</span>
                        </li>
                    @endif
                </ol>
            </nav>
        </div>

        <!-- Center - Search Bar (Optional) -->
        <div class="hidden lg:flex flex-1 max-w-md mx-8">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                       placeholder="Search portfolios, documents, users...">
            </div>
        </div>

        <!-- Right Side - Notifications & User Menu -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative">
                <button class="p-2 text-gray-600 hover:text-green-800 hover:bg-green-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-bell text-lg"></i>
                    <!-- Notification badge -->
                    <span class="absolute top-1 right-1 h-2 w-2 bg-yellow-500 rounded-full animate-pulse"></span>
                </button>
            </div>

            <!-- User Menu Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center space-x-3 p-2 text-sm rounded-lg hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-gray-600"></i>
                        @endif
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="font-medium text-gray-800">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle w-4 h-4 mr-3"></i>
                            My Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog w-4 h-4 mr-3"></i>
                            Settings
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
