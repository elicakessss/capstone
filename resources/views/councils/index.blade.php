@extends('layouts.app')

@section('title', 'Councils')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'participated' }">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Councils</h1>
            <p class="text-gray-600 mt-1">Manage and participate in student councils</p>
        </div>
        @if(auth()->check() && (auth()->user()->role === 'adviser' || auth()->user()->role === 'admin'))
        <button class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            Create Council
        </button>
        @endif
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card
            title="Councils Participated"
            value="3"
            icon="fas fa-users"
            iconColor="blue"
            borderColor="#3B82F6"
        />

        @if(auth()->check() && (auth()->user()->role === 'adviser' || auth()->user()->role === 'admin'))
        <x-stat-card
            title="Councils Created"
            value="8"
            icon="fas fa-crown"
            iconColor="spup-yellow"
            borderColor="#FFCC00"
        />
        @endif

        <x-stat-card
            title="Active Positions"
            value="2"
            icon="fas fa-id-badge"
            iconColor="spup-green"
            borderColor="#00471B"
        />

        <x-stat-card
            title="Completed Terms"
            value="1"
            icon="fas fa-check-circle"
            iconColor="green"
            borderColor="#10B981"
        />
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button @click="activeTab = 'participated'"
                    :class="{ 'border-green-500 text-green-600': activeTab === 'participated', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'participated' }"
                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fas fa-users mr-2"></i>
                Participated
            </button>

            @if(auth()->check() && (auth()->user()->role === 'adviser' || auth()->user()->role === 'admin'))
            <button @click="activeTab = 'created'"
                    :class="{ 'border-green-500 text-green-600': activeTab === 'created', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'created' }"
                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fas fa-crown mr-2"></i>
                Created
            </button>
            @endif

            @if(auth()->check() && auth()->user()->role === 'admin')
            <button @click="activeTab = 'templates'"
                    :class="{ 'border-green-500 text-green-600': activeTab === 'templates', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'templates' }"
                    class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="fas fa-template mr-2"></i>
                Templates
            </button>
            @endif
        </nav>
    </div>

    <!-- Tab Content -->
    <!-- Participated Tab -->
    <div x-show="activeTab === 'participated'" class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #3B82F6;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Councils I Participated In</h2>
            <p class="text-sm text-gray-600 mt-1">Student councils where you held positions as a member</p>
        </div>
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-users text-blue-600 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Council Participation Coming Soon</h3>
            <p class="text-gray-600 mb-4">View councils you've participated in and your positions.</p>
        </div>
    </div>

    @if(auth()->check() && (auth()->user()->role === 'adviser' || auth()->user()->role === 'admin'))
    <!-- Created Tab -->
    <div x-show="activeTab === 'created'" class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #FFCC00;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Councils I Created</h2>
            <p class="text-sm text-gray-600 mt-1">Student councils you have established and manage</p>
        </div>
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-crown text-yellow-600 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Council Management Coming Soon</h3>
            <p class="text-gray-600 mb-4">Create and manage student councils as an adviser.</p>
        </div>
    </div>
    @endif

    @if(auth()->check() && auth()->user()->role === 'admin')
    <!-- Templates Tab -->
    <div x-show="activeTab === 'templates'" class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Council Templates</h2>
            <p class="text-sm text-gray-600 mt-1">Create and manage council templates for advisers to use</p>
        </div>
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-template text-green-800 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Council Templates Coming Soon</h3>
            <p class="text-gray-600 mb-4">Create standardized council templates with positions and roles.</p>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Initialize Alpine.js component for tab switching
</script>
@endpush
@endsection
