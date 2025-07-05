@extends('layouts.app')

@section('title', 'Form Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Evaluation Forms</h1>
            <p class="text-gray-600 mt-1">Create and manage evaluation forms for council assessments</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn btn-secondary">
                <i class="fas fa-copy mr-2"></i>
                Duplicate Form
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Create New Form
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-stat-card
            title="Total Forms"
            value="15"
            icon="fas fa-clipboard-list"
            iconColor="spup-green"
            borderColor="#00471B"
        />
        <x-stat-card
            title="Active Forms"
            value="8"
            icon="fas fa-play-circle"
            iconColor="green"
            borderColor="#10B981"
        />
        <x-stat-card
            title="Draft Forms"
            value="4"
            icon="fas fa-edit"
            iconColor="spup-yellow"
            borderColor="#FFCC00"
        />
        <x-stat-card
            title="Archived Forms"
            value="3"
            icon="fas fa-archive"
            iconColor="gray"
            borderColor="#6B7280"
        />
    </div>

    <!-- Form Categories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Officer Evaluation</h3>
                        <p class="text-sm text-gray-600">Forms for evaluating council officers</p>
                    </div>
                </div>
            </div>
            <div class="space-y-2 text-sm text-gray-500">
                <div class="flex justify-between">
                    <span>Active Forms:</span>
                    <span class="font-medium text-green-600">3</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Evaluations:</span>
                    <span class="font-medium">145</span>
                </div>
            </div>
            <button class="btn btn-primary w-full mt-4">
                <i class="fas fa-cog mr-2"></i>
                Manage Forms
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Member Evaluation</h3>
                        <p class="text-sm text-gray-600">Forms for evaluating council members</p>
                    </div>
                </div>
            </div>
            <div class="space-y-2 text-sm text-gray-500">
                <div class="flex justify-between">
                    <span>Active Forms:</span>
                    <span class="font-medium text-green-600">2</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Evaluations:</span>
                    <span class="font-medium">89</span>
                </div>
            </div>
            <button class="btn btn-warning w-full mt-4">
                <i class="fas fa-cog mr-2"></i>
                Manage Forms
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Project Evaluation</h3>
                        <p class="text-sm text-gray-600">Forms for evaluating council projects</p>
                    </div>
                </div>
            </div>
            <div class="space-y-2 text-sm text-gray-500">
                <div class="flex justify-between">
                    <span>Active Forms:</span>
                    <span class="font-medium text-green-600">3</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Evaluations:</span>
                    <span class="font-medium">67</span>
                </div>
            </div>
            <button class="btn btn-secondary w-full mt-4">
                <i class="fas fa-cog mr-2"></i>
                Manage Forms
            </button>
        </div>
    </div>

    <!-- Form Management Interface -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #00471B;">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Form Builder & Management</h2>
                    <p class="text-sm text-gray-600 mt-1">Create, edit, and manage evaluation forms</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search forms..."
                               class="form-input pl-10 pr-4 py-2 w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <select class="form-select">
                        <option>All Forms</option>
                        <option>Active</option>
                        <option>Draft</option>
                        <option>Archived</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Placeholder Content -->
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Form Builder & Management System</h3>
            <p class="text-gray-600 mb-6">Advanced form creation and management tools coming soon.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-500 max-w-4xl mx-auto">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-plus-circle text-blue-500 mb-2"></i>
                    <p class="font-medium">Form Builder</p>
                    <p>Drag-and-drop form creation</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-cogs text-green-500 mb-2"></i>
                    <p class="font-medium">Field Types</p>
                    <p>Multiple question types available</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-eye text-yellow-500 mb-2"></i>
                    <p class="font-medium">Form Preview</p>
                    <p>Preview forms before publishing</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-copy text-purple-500 mb-2"></i>
                    <p class="font-medium">Form Templates</p>
                    <p>Reusable form templates</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-chart-bar text-red-500 mb-2"></i>
                    <p class="font-medium">Analytics</p>
                    <p>Form response analytics</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <i class="fas fa-download text-indigo-500 mb-2"></i>
                    <p class="font-medium">Export Data</p>
                    <p>Export evaluation results</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Templates -->
    <div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: #FFCC00;">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Quick Form Templates</h2>
            <p class="text-sm text-gray-600 mt-1">Start with pre-built templates for common evaluation types</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <button class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors text-left">
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="font-medium text-gray-900">Leadership Evaluation</h4>
                    <p class="text-sm text-gray-600 mt-1">Evaluate leadership skills and performance</p>
                </button>
                <button class="p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors text-left">
                    <div class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="font-medium text-gray-900">Teamwork Assessment</h4>
                    <p class="text-sm text-gray-600 mt-1">Assess collaboration and teamwork skills</p>
                </button>
                <button class="p-4 border border-gray-200 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors text-left">
                    <div class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h4 class="font-medium text-gray-900">Project Evaluation</h4>
                    <p class="text-sm text-gray-600 mt-1">Evaluate project execution and outcomes</p>
                </button>
                <button class="p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors text-left">
                    <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <h4 class="font-medium text-gray-900">Attendance & Participation</h4>
                    <p class="text-sm text-gray-600 mt-1">Track attendance and participation levels</p>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
