@extends('layouts.app')

@section('title', 'Evaluations')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Evaluations</h1>
            <p class="text-gray-600 mt-1">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    Manage evaluation forms and review system evaluations
                @elseif(auth()->check() && auth()->user()->role === 'adviser')
                    Review and evaluate your students' performance
                @else
                    View your evaluation status and feedback
                @endif
            </p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
        <button class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            Create Evaluation Form
        </button>
        @endif
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if(auth()->check() && auth()->user()->role === 'admin')
            <x-stat-card
                title="Total Forms"
                value="12"
                icon="fas fa-clipboard-list"
                iconColor="spup-green"
                borderColor="#00471B"
            />
            <x-stat-card
                title="Active Evaluations"
                value="45"
                icon="fas fa-clipboard-check"
                iconColor="blue"
                borderColor="#3B82F6"
            />
            <x-stat-card
                title="Completed This Month"
                value="128"
                icon="fas fa-check-circle"
                iconColor="green"
                borderColor="#10B981"
            />
            <x-stat-card
                title="Pending Reviews"
                value="23"
                icon="fas fa-clock"
                iconColor="red"
                borderColor="#EF4444"
            />
        @elseif(auth()->check() && auth()->user()->role === 'adviser')
            <x-stat-card
                title="Pending Evaluations"
                value="8"
                icon="fas fa-clipboard-check"
                iconColor="red"
                borderColor="#EF4444"
            />
            <x-stat-card
                title="Completed This Month"
                value="15"
                icon="fas fa-check-circle"
                iconColor="green"
                borderColor="#10B981"
            />
            <x-stat-card
                title="My Students"
                value="45"
                icon="fas fa-user-graduate"
                iconColor="spup-green"
                borderColor="#00471B"
            />
            <x-stat-card
                title="Average Score"
                value="8.5"
                icon="fas fa-star"
                iconColor="spup-yellow"
                borderColor="#FFCC00"
            />
        @else
            <x-stat-card
                title="Pending Evaluations"
                value="2"
                icon="fas fa-clipboard-check"
                iconColor="red"
                borderColor="#EF4444"
            />
            <x-stat-card
                title="Completed Evaluations"
                value="12"
                icon="fas fa-check-circle"
                iconColor="green"
                borderColor="#10B981"
            />
            <x-stat-card
                title="Current Average"
                value="8.7"
                icon="fas fa-star"
                iconColor="spup-yellow"
                borderColor="#FFCC00"
            />
            <x-stat-card
                title="Council Positions"
                value="3"
                icon="fas fa-id-badge"
                iconColor="blue"
                borderColor="#3B82F6"
            />
        @endif
    </div>

    <!-- Placeholder Content -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    Evaluation Management
                @elseif(auth()->check() && auth()->user()->role === 'adviser')
                    Student Evaluations
                @else
                    My Evaluations
                @endif
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    Create evaluation forms and monitor system-wide evaluation progress
                @elseif(auth()->check() && auth()->user()->role === 'adviser')
                    Review and evaluate your students' council performance
                @else
                    View your evaluation status and feedback from advisers
                @endif
            </p>
        </div>
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-clipboard-check text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Evaluation System Coming Soon</h3>
            <p class="text-gray-600 mb-6">This section will handle all evaluation-related features.</p>
            <div class="space-y-2 text-sm text-gray-500">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <p>• Create and manage evaluation forms</p>
                    <p>• Monitor evaluation progress</p>
                    <p>• Generate system reports</p>
                    <p>• Review evaluation analytics</p>
                @elseif(auth()->check() && auth()->user()->role === 'adviser')
                    <p>• Evaluate student performance</p>
                    <p>• Provide detailed feedback</p>
                    <p>• Track evaluation history</p>
                    <p>• Generate progress reports</p>
                @else
                    <p>• View pending evaluations</p>
                    <p>• Check evaluation status</p>
                    <p>• Read adviser feedback</p>
                    <p>• Track performance progress</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
