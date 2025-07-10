@extends('layouts.app')

@section('title', 'My Organizations')

@section('content')
<div class="space-y-10">
    <!-- Page Header with Create Org Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Organizations</h1>
            <p class="text-gray-600 mt-1">All organizations you are a member of or manage</p>
        </div>
        @if($isAdviserOrAdmin)
        <button id="createOrgBtn" class="btn btn-green flex items-center gap-2" type="button">
            <i class="fas fa-plus"></i> Create Org
        </button>
        @endif
    </div>

    @if($isAdviserOrAdmin)
    <!-- Organizations Assigned Section (adviser/admin only) -->
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Organizations Assigned</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($assignedOrgs ?? []) as $org)
                <div class="org-card bg-white rounded-lg shadow-sm p-6 flex items-center gap-4 transition-transform duration-200 cursor-pointer min-h-[120px]"
                    style="border-left: 6px solid {{ $org->department && $org->department->color ? $org->department->color : '#00471B' }}; border-top: 1.5px solid #f3f4f6; border-bottom: 1.5px solid #f3f4f6; border-right: 1.5px solid #f3f4f6; border-radius: 0.75rem;"
                    onclick="window.location='{{ route('orgs.show', $org) }}'"
                    onmouseover="this.style.transform='scale(1.025)';" onmouseout="this.style.transform='none';">
                    @if($org->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($org->logo) }}" alt="{{ $org->name }} Logo" class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
                    @else
                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-2xl font-bold border border-gray-200 shadow-sm">
                            <i class="fas fa-users"></i>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h2 class="org-title truncate font-semibold text-lg text-gray-900 mb-1">{{ $org->name }}</h2>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="org-type text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Type: {{ $org->type }}</span>
                            @if($org->department && $org->department->color)
                                <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $org->department->color }};"></span>
                            @endif
                        </div>
                        @if(!empty($org->term))
                            <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-12">No organizations assigned.</div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Organization Terms Section (all users, unique terms) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Organization Terms</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $allOrgTerms = ($createdOrgTerms ?? collect())->concat($participatedOrgTerms ?? collect())->unique('id')->values();
            @endphp
            @forelse($allOrgTerms as $term)
                <div class="org-card bg-white rounded-lg shadow-sm p-6 flex items-center gap-4 transition-transform duration-200 cursor-pointer min-h-[120px]"
                    style="border-left: 6px solid {{ ($term->org && $term->org->department && $term->org->department->color) ? $term->org->department->color : '#00471B' }}; border-top: 1.5px solid #f3f4f6; border-bottom: 1.5px solid #f3f4f6; border-right: 1.5px solid #f3f4f6; border-radius: 0.75rem;"
                    onclick="window.location='{{ route('org_terms.show', $term->id) }}'"
                    onmouseover="this.style.transform='scale(1.025)';" onmouseout="this.style.transform='none';">
                    @if($term->org && $term->org->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($term->org->logo) }}" alt="{{ $term->org->name }} Logo" class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
                    @else
                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-2xl font-bold border border-gray-200 shadow-sm">
                            <i class="fas fa-users"></i>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h2 class="org-title truncate font-semibold text-lg text-gray-900 mb-1">{{ $term->org->name ?? 'Unknown Org' }}</h2>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="org-type text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Type: {{ $term->org->type ?? '' }}</span>
                            @if($term->org && $term->org->department && $term->org->department->color)
                                <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $term->org->department->color }};"></span>
                            @endif
                        </div>
                        <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $term->academic_year ?? '' }}</span>
                        @if(isset($term->pivot) && $term->pivot->role)
                            <span class="ml-2 org-role text-xs text-blue-700 bg-blue-100 px-2 py-0.5 rounded">Role: {{ $term->pivot->role }}</span>
                        @elseif(isset($term->role))
                            <span class="ml-2 org-role text-xs text-blue-700 bg-blue-100 px-2 py-0.5 rounded">Role: {{ $term->role }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-12">No organization terms found.</div>
            @endforelse
        </div>
    </div>
</div>
@if($isAdviserOrAdmin)
<!-- Modal for Creating Org Term (Adviser) - moved outside main container for full overlay coverage -->
<div id="createOrgModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Create Organization Term</h3>
            <button id="closeOrgModalBtn" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
        </div>
        <div class="px-6 pt-6 pb-2">
        @if(isset($assignedOrgs) && count($assignedOrgs) > 0)
        <form id="createOrgForm" method="POST" action="{{ route('orgs.store') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label text-base mb-1">Organization Name</label>
                <select name="org_id" id="orgSelect" class="form-select w-full" required>
                    <option value="">-- Select --</option>
                    @foreach(($assignedOrgs ?? []) as $org)
                        <option value="{{ $org->id }}">{{ $org->name }} ({{ $org->type }})</option>
                    @endforeach
                </select>
            </div>
            <div id="academicYearSection" class="mb-4">
                <label class="form-label text-base mb-1">Academic Year <span class="text-red-500">*</span></label>
                <input type="text" name="academic_year" id="academicYearInput" class="form-input w-full" placeholder="e.g. 2025-2026" required>
                <div id="yearError" class="text-red-500 text-xs mt-1 hidden">This organization already exists for the selected academic year.</div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" id="cancelOrgModalBtn" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green" id="submitCreateOrgBtn" disabled>Create</button>
            </div>
        </form>
        @else
        <div class="text-gray-500 text-center py-8">No organizations available.</div>
        <div class="flex justify-end mt-4">
            <button type="button" id="cancelOrgModalBtn" class="btn btn-gray">Close</button>
        </div>
        @endif
        </div>
    </div>
</div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createOrgBtn = document.getElementById('createOrgBtn');
        const createOrgModal = document.getElementById('createOrgModal');
        const closeOrgModalBtn = document.getElementById('closeOrgModalBtn');
        const cancelOrgModalBtn = document.getElementById('cancelOrgModalBtn');
        const orgSelect = document.getElementById('orgSelect');
        const academicYearInput = document.getElementById('academicYearInput');
        const submitCreateOrgBtn = document.getElementById('submitCreateOrgBtn');
        const yearError = document.getElementById('yearError');

        function openOrgModal() { createOrgModal.classList.remove('hidden'); }
        function closeOrgModal() { createOrgModal.classList.add('hidden'); if(orgSelect){orgSelect.value = '';} if(academicYearInput){academicYearInput.value = '';} if(submitCreateOrgBtn){submitCreateOrgBtn.disabled = true;} if(yearError){yearError.classList.add('hidden');} }
        if (createOrgBtn) createOrgBtn.addEventListener('click', openOrgModal);
        if (closeOrgModalBtn) closeOrgModalBtn.addEventListener('click', closeOrgModal);
        if (cancelOrgModalBtn) cancelOrgModalBtn.addEventListener('click', closeOrgModal);

        if(orgSelect && academicYearInput && submitCreateOrgBtn && yearError) {
            let lastCheck = { org: '', year: '', result: null };
            function checkDuplicate() {
                const orgId = orgSelect.value;
                const year = academicYearInput.value.trim();
                submitCreateOrgBtn.disabled = true;
                yearError.classList.add('hidden');
                if (!orgId || !year) return;
                // Only check if changed
                if (lastCheck.org === orgId && lastCheck.year === year && lastCheck.result !== null) {
                    if (lastCheck.result) {
                        yearError.classList.remove('hidden');
                        submitCreateOrgBtn.disabled = true;
                    } else {
                        yearError.classList.add('hidden');
                        submitCreateOrgBtn.disabled = false;
                    }
                    return;
                }
                fetch(`{{ route('orgs.check-duplicate') }}?org_id=${encodeURIComponent(orgId)}&academic_year=${encodeURIComponent(year)}`)
                    .then(res => res.json())
                    .then(data => {
                        lastCheck = { org: orgId, year: year, result: data.exists };
                        if (data.exists) {
                            yearError.classList.remove('hidden');
                            submitCreateOrgBtn.disabled = true;
                        } else {
                            yearError.classList.add('hidden');
                            submitCreateOrgBtn.disabled = false;
                        }
                    })
                    .catch(() => {
                        submitCreateOrgBtn.disabled = true;
                        yearError.classList.add('hidden');
                    });
            }
            orgSelect.addEventListener('change', checkDuplicate);
            academicYearInput.addEventListener('input', checkDuplicate);
        }
    });
</script>
<style>
.org-card .org-title { font-size: 1.125rem; }
.org-card .org-type, .org-card .org-term { font-size: 0.85rem; }
</style>
@endsection
