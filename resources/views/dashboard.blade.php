@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back, {{ auth()->check() ? auth()->user()->first_name : 'Guest' }}!
                </h1>
                <p class="text-gray-600 mt-1">
                    Here's what's happening with your portfolio today.
                </p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if(auth()->check() && isset(auth()->user()->role) && auth()->user()->role === 'admin')
            <!-- Admin Stats -->
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Departments</p>
                        <p class="stat-value">5</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Active Organizations</p>
                        <p class="stat-value">12</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Users</p>
                        <p class="stat-value">245</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card stats-card-yellow">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-yellow">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Pending Evaluations</p>
                        <p class="stat-value">8</p>
                    </div>
                </div>
            </div>
        @elseif(auth()->check() && isset(auth()->user()->role) && auth()->user()->role === 'adviser')
            <!-- Adviser Stats -->
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">My Organizations</p>
                        <p class="stat-value">3</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Students Under Me</p>
                        <p class="stat-value">28</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-yellow">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Pending Evaluations</p>
                        <p class="stat-value">5</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Portfolios Reviewed</p>
                        <p class="stat-value">15</p>
                    </div>
                </div>
            </div>
        @else
            <!-- Student Stats -->
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Portfolio Items</p>
                        <p class="stat-value">24</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Documents</p>
                        <p class="stat-value">12</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Organization Positions</p>
                        <p class="stat-value">2</p>
                    </div>
                </div>
            </div>
            
            <div class="stats-card stats-card-green">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-yellow">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Portfolio Score</p>
                        <p class="stat-value">95%</p>
                    </div>
                </div>
            </div>
        @else
            <!-- Default/Guest Stats -->
            <div class="stats-card">
                <div class="flex items-center">
                    <div class="stat-icon stat-icon-gray">
                        <i class="fas fa-info"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Welcome</p>
                        <p class="stat-value">Please login to view stats</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-upload text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Document uploaded</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Profile updated</p>
                            <p class="text-xs text-gray-500">1 day ago</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Joined organization</p>
                            <p class="text-xs text-gray-500">3 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @if(auth()->check() && isset(auth()->user()->role) && auth()->user()->role === 'admin')
                        <a href="#" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                            <span class="text-sm font-medium text-blue-900">Create New Organization</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-building text-green-600 mr-3"></i>
                            <span class="text-sm font-medium text-green-900">Manage Departments</span>
                        </a>
                    @elseif(auth()->check() && isset(auth()->user()->role) && auth()->user()->role === 'adviser')
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
    </div>
</div>
@endsection
