@extends('layouts.app')

@section('title', 'System Logs')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">System Logs</h1>
            <p class="text-gray-600 mt-1">Monitor system activities, errors, and user actions</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn btn-secondary">
                <i class="fas fa-download mr-2"></i>
                Export Logs
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-sync mr-2"></i>
                Refresh Logs
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card
            title="Total Activities"
            value="12,450"
            icon="fas fa-chart-line"
            iconColor="spup-green"
            borderColor="#00471B"
            trend="up"
            trendValue="234"
        />
        <x-stat-card
            title="Errors Today"
            value="5"
            icon="fas fa-exclamation-triangle"
            iconColor="red"
            borderColor="#EF4444"
        />
        <x-stat-card
            title="User Logins"
            value="189"
            icon="fas fa-sign-in-alt"
            iconColor="blue"
            borderColor="#3B82F6"
        />
        <x-stat-card
            title="System Uptime"
            value="99.8%"
            icon="fas fa-server"
            iconColor="green"
            borderColor="#10B981"
        />
    </div>

    <!-- Log Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">User Activities</h3>
                    <p class="text-sm text-gray-600">Login, logout, registration</p>
                    <p class="text-xl font-bold text-blue-600 mt-2">1,234</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Evaluations</h3>
                    <p class="text-sm text-gray-600">Form submissions, reviews</p>
                    <p class="text-xl font-bold text-green-600 mt-2">567</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">System Changes</h3>
                    <p class="text-sm text-gray-600">Configuration updates</p>
                    <p class="text-xl font-bold text-yellow-600 mt-2">89</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Errors & Warnings</h3>
                    <p class="text-sm text-gray-600">System errors, warnings</p>
                    <p class="text-xl font-bold text-red-600 mt-2">12</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Viewer Interface -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Activity Monitor</h2>
                    <p class="text-sm text-gray-600 mt-1">Real-time system activity and error tracking</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search logs..."
                               class="form-input pl-10 pr-4 py-2 w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <select class="form-select">
                        <option>All Activities</option>
                        <option>User Activities</option>
                        <option>Evaluations</option>
                        <option>System Changes</option>
                        <option>Errors Only</option>
                    </select>
                    <select class="form-select">
                        <option>Last 24 Hours</option>
                        <option>Last Week</option>
                        <option>Last Month</option>
                        <option>Custom Range</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Placeholder Content -->
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-list-alt text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">System Activity Monitor</h3>
            <p class="text-gray-600 mb-6">Comprehensive logging and monitoring system coming soon.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-500 max-w-4xl mx-auto">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-clock text-blue-500 mb-2"></i>
                    <p class="font-medium">Real-time Monitoring</p>
                    <p>Live activity tracking and alerts</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-filter text-green-500 mb-2"></i>
                    <p class="font-medium">Advanced Filtering</p>
                    <p>Filter by user, action, date range</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-bug text-yellow-500 mb-2"></i>
                    <p class="font-medium">Error Tracking</p>
                    <p>Detailed error logs and stack traces</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-chart-bar text-purple-500 mb-2"></i>
                    <p class="font-medium">Usage Analytics</p>
                    <p>System usage patterns and trends</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-shield-alt text-red-500 mb-2"></i>
                    <p class="font-medium">Security Monitoring</p>
                    <p>Track security events and attempts</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-download text-indigo-500 mb-2"></i>
                    <p class="font-medium">Export & Reporting</p>
                    <p>Generate detailed activity reports</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Sample -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #3B82F6;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Activities (Sample)</h2>
            <p class="text-sm text-gray-600 mt-1">Latest system activities and user actions</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">User login: john.doe@student.spup.edu.ph</p>
                        <p class="text-xs text-gray-500">2 minutes ago • IP: 192.168.1.100</p>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Success</span>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Evaluation submitted for Student Council</p>
                        <p class="text-xs text-gray-500">15 minutes ago • User: mary.advisor@spup.edu.ph</p>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Evaluation</span>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-cog text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">System configuration updated</p>
                        <p class="text-xs text-gray-500">1 hour ago • Admin: admin@spup.edu.ph</p>
                    </div>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">System</span>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Failed login attempt detected</p>
                        <p class="text-xs text-gray-500">2 hours ago • IP: 203.177.124.45</p>
                    </div>
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Error</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
