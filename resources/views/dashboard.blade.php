@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4" style="border-left-color: #00471B;">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name ?? 'User' }}!</h1>
                <p class="text-gray-600 mt-1">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        You're logged in as an Administrator. Manage users, councils, and system settings.
                    @elseif(auth()->check() && auth()->user()->role === 'adviser')
                        You're logged in as an Adviser. Manage your organizations and evaluate students.
                    @else
                        You're logged in as a Student. Manage your portfolio and participate in councils.
                    @endif
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ date('l, F j, Y') }}</p>
                <p class="text-xs text-gray-400">Academic Year 2024-2025</p>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- Admin Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900">150</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active Councils</p>
                        <p class="text-2xl font-semibold text-gray-900">25</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-clipboard-check text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Evaluations</p>
                        <p class="text-2xl font-semibold text-gray-900">42</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-chart-line text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">System Activities</p>
                        <p class="text-2xl font-semibold text-gray-900">1,234</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Common administrative tasks</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.users.index', ['tab' => 'requests']) }}" class="flex items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-200">
                        <i class="fas fa-user-plus text-blue-600 mr-2"></i>
                        <span class="font-medium text-blue-900">Review User Requests</span>
                    </a>
                    <a href="#" class="flex items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors border border-yellow-200">
                        <i class="fas fa-users text-yellow-600 mr-2"></i>
                        <span class="font-medium text-yellow-900">Create Council Template</span>
                    </a>
                    <a href="#" class="flex items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors border border-gray-200">
                        <i class="fas fa-clipboard-list text-gray-600 mr-2"></i>
                        <span class="font-medium text-gray-900">Create Evaluation Form</span>
                    </a>
                </div>
            </div>
        </div>

    @elseif(auth()->check() && auth()->user()->role === 'adviser')
        <!-- Adviser Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-crown text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">My Organizations</p>
                        <p class="text-2xl font-semibold text-gray-900">8</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-user-graduate text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">My Students</p>
                        <p class="text-2xl font-semibold text-gray-900">45</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-clipboard-check text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Evaluations</p>
                        <p class="text-2xl font-semibold text-gray-900">12</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Councils Participated</p>
                        <p class="text-2xl font-semibold text-gray-900">3</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adviser Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #FFCC00;">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your organizations and students</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#" class="flex items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors border border-yellow-200">
                        <i class="fas fa-plus text-yellow-600 mr-2"></i>
                        <span class="font-medium text-yellow-900">Create New Council</span>
                    </a>
                    <a href="#" class="flex items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-200">
                        <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>
                        <span class="font-medium text-blue-900">Review Evaluations</span>
                    </a>
                </div>
            </div>
        </div>

    @else
        <!-- Student Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-folder-open text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Portfolio Items</p>
                        <p class="text-2xl font-semibold text-gray-900">18</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Council Memberships</p>
                        <p class="text-2xl font-semibold text-gray-900">2</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-clipboard-check text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Evaluations</p>
                        <p class="text-2xl font-semibold text-gray-900">1</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Completed Evaluations</p>
                        <p class="text-2xl font-semibold text-gray-900">5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your portfolio and activities</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="#" class="flex items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-200">
                        <i class="fas fa-upload text-blue-600 mr-2"></i>
                        <span class="font-medium text-blue-900">Upload Documents</span>
                    </a>
                    <a href="#" class="flex items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors border border-yellow-200">
                        <i class="fas fa-eye text-yellow-600 mr-2"></i>
                        <span class="font-medium text-yellow-900">View Portfolio</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
            <p class="text-sm text-gray-600 mt-1">Your latest actions and updates</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Portfolio updated successfully</p>
                        <p class="text-xs text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-bell text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">New evaluation assigned</p>
                        <p class="text-xs text-gray-500">1 day ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Joined Student Council</p>
                        <p class="text-xs text-gray-500">3 days ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #3B82F6;">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Common tasks and shortcuts</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="#" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                            <span class="text-sm font-medium text-blue-900">Create New Organization</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-building text-green-600 mr-3"></i>
                            <span class="text-sm font-medium text-green-900">Manage Departments</span>
                        </a>
                    @elseif(auth()->check() && auth()->user()->role === 'adviser')
                        <a href="#" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-clipboard-check text-blue-600 mr-3"></i>
                            <span class="text-sm font-medium text-blue-900">Review Evaluations</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-users text-green-600 mr-3"></i>
                            <span class="text-sm font-medium text-green-900">View My Organizations</span>
                        </a>
                    @else
                        <a href="#" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-upload text-blue-600 mr-3"></i>
                            <span class="text-sm font-medium text-blue-900">Upload Document</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-folder-open text-green-600 mr-3"></i>
                            <span class="text-sm font-medium text-green-900">View Portfolio</span>
                        </a>
                    @endif
                    <a href="#" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-user-edit text-purple-600 mr-3"></i>
                        <span class="text-sm font-medium text-purple-900">Update Profile</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #10B981;">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">System Information</h2>
                <p class="text-sm text-gray-600 mt-1">Current system status and information</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-server text-green-600 mr-3"></i>
                            <span class="text-sm font-medium text-green-900">System Status</span>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded">Online</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-blue-600 mr-3"></i>
                            <span class="text-sm font-medium text-blue-900">Academic Year</span>
                        </div>
                        <span class="text-xs font-semibold text-blue-600">2024-2025</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-yellow-600 mr-3"></i>
                            <span class="text-sm font-medium text-yellow-900">Last Login</span>
                        </div>
                        <span class="text-xs font-semibold text-yellow-600">{{ now()->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
