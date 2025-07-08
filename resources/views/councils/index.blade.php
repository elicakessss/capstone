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
        <button id="createCouncilBtn" class="btn btn-primary">
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

    <!-- Modal for Creating Council/Org Term -->
    <div id="createCouncilModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button id="closeCouncilModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold mb-4">Create Organization Term</h3>
            @if(isset($assignedOrgs) && count($assignedOrgs) > 0)
            <form id="createCouncilForm" method="POST" action="{{ route('councils.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Select Organization</label>
                    <select name="org_id" id="orgSelect" class="form-select w-full" required>
                        <option value="">-- Select --</option>
                        @foreach($assignedOrgs as $org)
                            <option value="{{ $org->id }}">{{ $org->name }} ({{ $org->type }})</option>
                        @endforeach
                    </select>
                </div>
                <div id="academicYearSection" class="mb-4 hidden">
                    <label class="block text-gray-700 font-medium mb-1">Academic Year <span class="text-red-500">*</span></label>
                    <input type="text" name="academic_year" id="academicYearInput" class="form-input w-full" placeholder="e.g. 2025-2026">
                    <div id="yearError" class="text-red-500 text-xs mt-1 hidden">This organization already exists for the selected academic year.</div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelCouncilModalBtn" class="btn btn-sm btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="submitCreateCouncilBtn" disabled>Create</button>
                </div>
            </form>
            @else
            <div class="text-gray-500 text-center py-8">No organizations available.</div>
            <div class="flex justify-end mt-4">
                <button type="button" id="cancelCouncilModalBtn" class="btn btn-sm btn-secondary">Close</button>
            </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createCouncilBtn = document.getElementById('createCouncilBtn');
            const createCouncilModal = document.getElementById('createCouncilModal');
            const closeCouncilModalBtn = document.getElementById('closeCouncilModalBtn');
            const cancelCouncilModalBtn = document.getElementById('cancelCouncilModalBtn');
            const orgSelect = document.getElementById('orgSelect');
            const academicYearSection = document.getElementById('academicYearSection');
            const academicYearInput = document.getElementById('academicYearInput');
            const submitCreateCouncilBtn = document.getElementById('submitCreateCouncilBtn');
            const yearError = document.getElementById('yearError');

            function openCouncilModal() { createCouncilModal.classList.remove('hidden'); }
            function closeCouncilModal() { createCouncilModal.classList.add('hidden'); if(orgSelect){orgSelect.value = '';} if(academicYearInput){academicYearInput.value = '';} if(submitCreateCouncilBtn){submitCreateCouncilBtn.disabled = true;} if(yearError){yearError.classList.add('hidden');} if(academicYearSection){academicYearSection.classList.add('hidden');} }
            if (createCouncilBtn) createCouncilBtn.addEventListener('click', openCouncilModal);
            if (closeCouncilModalBtn) closeCouncilModalBtn.addEventListener('click', closeCouncilModal);
            if (cancelCouncilModalBtn) cancelCouncilModalBtn.addEventListener('click', closeCouncilModal);

            if(orgSelect && academicYearSection && submitCreateCouncilBtn) {
                orgSelect.addEventListener('change', function() {
                    if (this.value) {
                        academicYearSection.classList.remove('hidden');
                        submitCreateCouncilBtn.disabled = true;
                    } else {
                        academicYearSection.classList.add('hidden');
                        submitCreateCouncilBtn.disabled = true;
                    }
                });
            }
            if(academicYearInput && submitCreateCouncilBtn && yearError && orgSelect) {
                let lastCheck = { org: '', year: '', result: null };
                academicYearInput.addEventListener('input', function() {
                    const orgId = orgSelect.value;
                    const year = this.value.trim();
                    submitCreateCouncilBtn.disabled = true;
                    yearError.classList.add('hidden');
                    if (!orgId || !year) return;
                    // Only check if changed
                    if (lastCheck.org === orgId && lastCheck.year === year && lastCheck.result !== null) {
                        if (lastCheck.result) {
                            yearError.classList.remove('hidden');
                            submitCreateCouncilBtn.disabled = true;
                        } else {
                            yearError.classList.add('hidden');
                            submitCreateCouncilBtn.disabled = false;
                        }
                        return;
                    }
                    fetch(`{{ route('councils.check-duplicate') }}?org_id=${encodeURIComponent(orgId)}&academic_year=${encodeURIComponent(year)}`)
                        .then(res => res.json())
                        .then(data => {
                            lastCheck = { org: orgId, year: year, result: data.exists };
                            if (data.exists) {
                                yearError.classList.remove('hidden');
                                submitCreateCouncilBtn.disabled = true;
                            } else {
                                yearError.classList.add('hidden');
                                submitCreateCouncilBtn.disabled = false;
                            }
                        })
                        .catch(() => {
                            submitCreateCouncilBtn.disabled = true;
                            yearError.classList.add('hidden');
                        });
                });
            }
        });
    </script>
</div>

@push('scripts')
<script>
    // Initialize Alpine.js component for tab switching
</script>
@endpush
@endsection
