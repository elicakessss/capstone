@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Portfolio</h1>
            <p class="text-gray-600 mt-1">Manage your documents and achievements</p>
        </div>
        <button class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            Add Document
        </button>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card
            title="Total Documents"
            value="18"
            icon="fas fa-file-alt"
            iconColor="spup-green"
            borderColor="#00471B"
        />
        <x-stat-card
            title="Pending Review"
            value="3"
            icon="fas fa-clock"
            iconColor="spup-yellow"
            borderColor="#FFCC00"
        />
        <x-stat-card
            title="Approved"
            value="14"
            icon="fas fa-check-circle"
            iconColor="green"
            borderColor="#10B981"
        />
        <x-stat-card
            title="Storage Used"
            value="2.3 GB"
            icon="fas fa-hdd"
            iconColor="blue"
            borderColor="#3B82F6"
        />
    </div>

    <!-- Placeholder Content -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Portfolio Documents</h2>
            <p class="text-sm text-gray-600 mt-1">Your uploaded documents and achievements</p>
        </div>
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Portfolio Coming Soon</h3>
            <p class="text-gray-600 mb-6">This section will display your portfolio documents, achievements, and evaluations.</p>
            <div class="space-y-2 text-sm text-gray-500">
                <p>• Upload and organize your documents</p>
                <p>• Track evaluation status</p>
                <p>• View adviser feedback</p>
                <p>• Generate portfolio reports</p>
            </div>
        </div>
    </div>
</div>
@endsection
