<!-- Sidebar -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 border-r border-gray-100">
    <div class="flex flex-col h-full">
        <!-- Logo/Brand -->
        <div class="flex items-center justify-between h-20 px-6 border-b border-gray-100 bg-gradient-to-r from-green-800 to-green-900" style="background: linear-gradient(135deg, #00471B 0%, #005925 100%);">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-white">E-Portfolio</span>
                    <p class="text-xs text-green-100 font-medium">Evaluation System</p>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-800 border-r-3 border-green-800' : 'text-gray-600 hover:bg-gray-50 hover:text-green-800' }}">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('dashboard') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500 group-hover:bg-green-50 group-hover:text-green-600' }} transition-colors">
                    <i class="fas fa-home"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Section -->
                <div class="pt-6">
                    <h3 class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Administration</h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.departments') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.departments*') ? 'bg-green-50 text-green-800 border-r-3 border-green-800' : 'text-gray-600 hover:bg-gray-50 hover:text-green-800' }}">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.departments*') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500 group-hover:bg-green-50 group-hover:text-green-600' }} transition-colors">
                                <i class="fas fa-building"></i>
                            </div>
                            <span class="font-medium">Departments</span>
                        </a>
                        <a href="{{ route('admin.councils') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.councils*') ? 'bg-green-50 text-green-800 border-r-3 border-green-800' : 'text-gray-600 hover:bg-gray-50 hover:text-green-800' }}">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.councils*') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500 group-hover:bg-green-50 group-hover:text-green-600' }} transition-colors">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="font-medium">Organizations</span>
                        </a>
                        <a href="{{ route('admin.users') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-green-50 text-green-800 border-r-3 border-green-800' : 'text-gray-600 hover:bg-gray-50 hover:text-green-800' }}">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.users*') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500 group-hover:bg-green-50 group-hover:text-green-600' }} transition-colors">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <span class="font-medium">User Management</span>
                        </a>
                    </div>
                </div>
            @endif

            @if(auth()->user()->role === 'adviser' || auth()->user()->role === 'admin')
                <!-- Adviser Section -->
                <div class="pt-4">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Advisory</h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('adviser.organizations') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('adviser.organizations*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-sitemap w-5 h-5 mr-3"></i>
                            My Organizations
                        </a>
                        <a href="{{ route('adviser.evaluations') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('adviser.evaluations*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-clipboard-check w-5 h-5 mr-3"></i>
                            Evaluations
                        </a>
                    </div>
                </div>
            @endif

            <!-- Portfolio Section -->
            <div class="pt-4">
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Portfolio</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('portfolio.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portfolio.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-folder-open w-5 h-5 mr-3"></i>
                        My Portfolio
                    </a>
                    <a href="{{ route('portfolio.documents') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('portfolio.documents*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        Documents
                    </a>
                    @if(auth()->user()->role === 'student')
                        <a href="{{ route('student.memberships') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('student.memberships*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-id-badge w-5 h-5 mr-3"></i>
                            My Positions
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings -->
            <div class="pt-4">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profile.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    Settings
                </a>
            </div>
        </nav>

        <!-- User Info (Bottom) -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-gray-600"></i>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate capitalize">
                        {{ auth()->user()->role }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
