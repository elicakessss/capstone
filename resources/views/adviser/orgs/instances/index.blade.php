@extends('layouts.app')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">My Organizations</h1>
    <button id="createOrgBtn" class="btn btn-green">Create Organization</button>
</div>
<!-- Organization Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($orgInstances as $org)
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between cursor-pointer hover:shadow-lg border-l-4" style="border-color: {{ $org->department->color ?? '#e5e7eb' }};" onclick="window.location='{{ route('adviser.orgs.instances.show', $org->id) }}'">
            <div class="flex items-center gap-4 mb-4">
                @if($org->logo)
                    <img src="{{ asset($org->logo) }}" alt="{{ $org->name }} Logo" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                @else
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-xl font-bold border border-gray-200 shadow-sm">
                        <i class="fas fa-users"></i>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $org->name }}</h2>
                    <div class="text-gray-500 text-sm">Type: {{ $org->type }}</div>
                    @if($org->department)
                        <div class="text-gray-500 text-sm mt-1">Department: {{ $org->department->name }}</div>
                    @endif
                </div>
            </div>
            <div class="mb-2">
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <div class="text-gray-800">{{ $org->description ?? '—' }}</div>
            </div>
            @if($org->term)
                <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
            @endif
        </div>
    @endforeach
    @if($orgInstances->isEmpty())
        <p class="text-gray-500">No organizations created yet.</p>
    @endif
</div>
<!-- Create Org Modal -->
<div id="createOrgModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button id="closeCreateOrgModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
        <h3 class="text-lg font-bold mb-4">Create Organization</h3>
        <form id="createOrgForm" method="POST" action="{{ route('adviser.orgs.instances.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Select Organization Template</label>
                <select name="template_id" id="templateSelect" class="form-select w-full" required>
                    <option value="">-- Select --</option>
                    @foreach($availableTemplates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }} ({{ $template->type }})</option>
                    @endforeach
                </select>
            </div>
            <div id="academicYearSection" class="mb-4 hidden">
                <label class="block text-gray-700 font-medium mb-1">Academic Year <span class="text-red-500">*</span></label>
                <input type="text" name="academic_year" id="academicYearInput" class="form-input w-full" placeholder="e.g. 2025-2026">
                <div id="yearError" class="text-red-500 text-xs mt-1 hidden">This organization already exists for the selected academic year.</div>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelCreateOrgBtn" class="btn btn-sm btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary" id="submitCreateOrgBtn" disabled>Create</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createOrgBtn = document.getElementById('createOrgBtn');
        const createOrgModal = document.getElementById('createOrgModal');
        const closeCreateOrgModalBtn = document.getElementById('closeCreateOrgModalBtn');
        const cancelCreateOrgBtn = document.getElementById('cancelCreateOrgBtn');
        const templateSelect = document.getElementById('templateSelect');
        const academicYearSection = document.getElementById('academicYearSection');
        const academicYearInput = document.getElementById('academicYearInput');
        const submitCreateOrgBtn = document.getElementById('submitCreateOrgBtn');
        const yearError = document.getElementById('yearError');

        function openModal() { createOrgModal.classList.remove('hidden'); }
        function closeModal() { createOrgModal.classList.add('hidden'); academicYearSection.classList.add('hidden'); templateSelect.value = ''; academicYearInput.value = ''; submitCreateOrgBtn.disabled = true; yearError.classList.add('hidden'); }
        createOrgBtn.addEventListener('click', openModal);
        closeCreateOrgModalBtn.addEventListener('click', closeModal);
        cancelCreateOrgBtn.addEventListener('click', closeModal);

        templateSelect.addEventListener('change', function() {
            if (this.value) {
                academicYearSection.classList.remove('hidden');
                submitCreateOrgBtn.disabled = true;
            } else {
                academicYearSection.classList.add('hidden');
                submitCreateOrgBtn.disabled = true;
            }
        });
        academicYearInput.addEventListener('input', function() {
            // TODO: AJAX check for duplicate org for this template and year
            submitCreateOrgBtn.disabled = !this.value;
            yearError.classList.add('hidden');
        });
        // Optionally, add AJAX validation for duplicate org-year
    });
</script>
@endsection
