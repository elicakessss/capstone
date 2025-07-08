@extends('layouts.app')

@section('title', $org->name . ' Organization')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $org->name }} Organization</h1>
        </div>
        <a href="{{ route('admin.orgs.index') }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <!-- Main Grid Layout: 2 cards on top, 1 wide card below -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Org Details Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between" style="border-left: 5px solid {{ $org->department->color ?? '#e5e7eb' }};">
            <div class="flex items-center gap-4 mb-4">
                @if($org->logo && file_exists(public_path('storage/' . $org->logo)))
                    <img src="{{ asset('storage/' . $org->logo) }}" alt="{{ $org->name }} Logo" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
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
            @if($org->term)
                <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
            @endif
            <!-- Edit/Delete buttons -->
            <div class="mt-4 flex gap-2">
                <button onclick="showEditOrgModal()" class="btn btn-blue" type="button">Edit</button>
                <form action="{{ route('admin.orgs.destroy', $org) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-red">Delete</button>
                </form>
            </div>
        </div>
        <!-- Advisers Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Adviser</h2>
                <button id="assignAdviserBtn" class="btn btn-green" type="button"><i class="fas fa-plus"></i> Assign Adviser</button>
            </div>
            <div class="border-b border-gray-200 mb-2"></div>
            <div class="text-gray-500 text-sm">
                @if(isset($advisers) && $advisers->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach($advisers as $adviser)
                            <li class="py-2 px-1 flex items-center justify-between group">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-800">{{ $adviser->name }}</span>
                                    <span class="text-xs text-gray-500">({{ $adviser->email }})</span>
                                </div>
                                <form method="POST" action="{{ route('admin.orgs.removeAdviser', $org) }}" onsubmit="return confirm('Remove this adviser?');">
                                    @csrf
                                    <input type="hidden" name="adviser_id" value="{{ $adviser->id }}">
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1" title="Remove Adviser">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-400 py-2 px-1">No advisers assigned yet.</div>
                @endif
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1">
        <!-- Positions Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Positions</h2>
                <button id="addPositionBtn" class="btn btn-green" type="button"><i class="fas fa-plus"></i> Position</button>
            </div>
            @php
                // Sort positions by 'order' ascending (1 is highest)
                $sortedPositions = $positions->sortBy('order');
            @endphp
            @if($positions->count())
                <ul class="mb-2">
                    @foreach($sortedPositions as $position)
                        <li class="mb-2 p-3 bg-gray-50 rounded border flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <span class="font-semibold">{{ $position->title }}</span>
                                <span class="text-xs text-gray-500 ml-2">Allowed Departments:
                                    @foreach($position->departments as $dept)
                                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded mr-1">{{ $dept->name }}</span>
                                    @endforeach
                                </span>
                                <span class="text-xs text-gray-400 ml-2">(Slots: {{ $position->slots }}, Order: {{ $position->order }})</span>
                            </div>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                <button class="btn btn-blue" type="button" onclick="showEditPositionModal({{ $position->id }}, '{{ addslashes($position->title) }}', '{{ addslashes($position->description) }}', @json($position->departments->pluck('id')), {{ $position->slots }}, {{ $position->order }})" >Edit</button>
                                <form action="{{ route('admin.positions.destroy', ['position' => $position->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this position?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 text-sm mb-2">No positions yet. Add branch and position.</div>
            @endif
            <!-- Position management UI goes here -->
        </div>
    </div>
</div>
<!-- Modal for Adding Position -->
<div id="addPositionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Add Position</h3>
            <button id="closeModalBtn" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.orgs.positions.store', $org) }}" class="px-6 pt-6 pb-2">
            @csrf
            <div class="mb-4">
                <label class="form-label text-base">Position Title</label>
                <input type="text" name="title" class="form-input w-full text-base" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Allowed Departments</label>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @if($org->department_id)
                        @foreach($departments as $department)
                            <div class="flex items-center">
                                <input type="checkbox" name="departments[]" value="{{ $department->id }}" id="dept-{{ $department->id }}" class="mr-2" {{ $department->id == $org->department_id ? 'checked disabled' : 'disabled' }}>
                                <label for="dept-{{ $department->id }}" class="text-gray-800 {{ $department->id == $org->department_id ? '' : 'text-gray-400' }}">{{ $department->name }}</label>
                            </div>
                        @endforeach
                        <input type="hidden" name="departments[]" value="{{ $org->department_id }}">
                    @else
                        @foreach($departments as $department)
                            <div class="flex items-center">
                                <input type="checkbox" name="departments[]" value="{{ $department->id }}" id="dept-{{ $department->id }}" class="mr-2">
                                <label for="dept-{{ $department->id }}" class="text-gray-800">{{ $department->name }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="w-1/2">
                    <label class="form-label text-base">Slots</label>
                    <input type="number" name="slots" id="addPositionSlots" class="form-input w-full text-base" min="1" required>
                </div>
                <div class="w-1/2">
                    <label class="form-label text-base">Order</label>
                    <input type="number" name="order" id="addPositionOrder" class="form-input w-full text-base" min="0">
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" id="cancelModalBtn" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green">Save</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal for Assigning Adviser -->
<div id="assignAdviserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Assign Adviser</h3>
            <button id="closeAdviserModalBtn" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.orgs.assignAdviser', $org) }}" class="px-6 pt-6 pb-2">
            @csrf
            <div class="mb-4">
                <label class="form-label text-base">Search Adviser</label>
                <div class="relative">
                    <input type="text" id="adviserSearchInput" class="form-input w-full text-base pr-10" placeholder="Type name or email...">
                    <span id="adviserSelectedIcon" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hidden"><i class="fas fa-check-circle"></i></span>
                </div>
            </div>
            <div id="adviserSearchResults" class="mb-4 max-h-40 overflow-y-auto border rounded p-2 bg-gray-50"></div>
            <input type="hidden" name="adviser_id" id="selectedAdviserId">
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" id="cancelAdviserModalBtn" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green" id="assignAdviserSubmitBtn" disabled>Assign</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Organization Modal -->
<div id="editOrgModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Edit Organization</h3>
            <button onclick="hideEditOrgModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.orgs.update', $org) }}" class="px-6 pt-6 pb-2" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4 flex flex-col items-center">
                <div id="editOrgLogoPreviewWrapper" class="mb-2" style="display:{{ ($org->logo && file_exists(public_path('storage/' . $org->logo))) ? 'block' : 'none' }};">
                    <img id="editOrgLogoPreview" src="{{ ($org->logo && file_exists(public_path('storage/' . $org->logo))) ? asset('storage/' . $org->logo) : '#' }}" alt="Logo Preview" class="w-20 h-20 rounded-full object-cover border border-gray-200 shadow mb-2 mx-auto" style="max-width:80px; max-height:80px;" />
                </div>
                <label class="form-label text-base mb-1">Organization Logo</label>
                <button type="button" onclick="document.getElementById('editOrgLogoInput').click();" class="btn btn-green flex items-center gap-2 mb-2">
                    <i class="fas fa-upload"></i> <span>Choose Logo</span>
                </button>
                <input id="editOrgLogoInput" type="file" name="logo" accept="image/*" class="hidden" onchange="previewEditOrgLogo(event)">
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Organization Name</label>
                <input type="text" name="name" class="form-input w-full text-base" value="{{ old('name', $org->name) }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Type</label>
                <select name="type" class="form-select w-full text-base" required>
                    <option value="">Select Type</option>
                    @foreach($orgTypes ?? [] as $orgType)
                        <option value="{{ $orgType->name }}" {{ (old('type', $org->type) == $orgType->name) ? 'selected' : '' }}>{{ $orgType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Department</label>
                <select name="department_id" class="form-select w-full text-base" required>
                    <option value="">Select Department</option>
                    @foreach($departments ?? [] as $department)
                        <option value="{{ $department->id }}" {{ (old('department_id', $org->department_id) == $department->id) ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                    <option value="" {{ is_null(old('department_id', $org->department_id)) ? 'selected' : '' }}>No Department</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="hideEditOrgModal()" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Position Modal -->
<div id="editPositionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Edit Position</h3>
            <button id="closeEditPositionModalBtn" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
        </div>
        <form id="editPositionForm" method="POST">
            @csrf
            @method('PUT')
            <div class="px-6 pt-6 pb-2">
                <div class="mb-4">
                    <label class="form-label text-base">Position Title</label>
                    <input type="text" name="title" id="editPositionTitle" class="form-input w-full text-base" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-base">Description</label>
                    <textarea name="description" id="editPositionDescription" class="form-input w-full text-base" rows="2"></textarea>
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label class="form-label text-base">Slots</label>
                        <input type="number" name="slots" id="editPositionSlots" class="form-input w-full text-base" min="1" required>
                    </div>
                    <div class="w-1/2">
                        <label class="form-label text-base">Order (optional)</label>
                        <input type="number" name="order" id="editPositionOrder" class="form-input w-full text-base" min="0">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-base">Allowed Departments</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto" id="editPositionDepartments">
                        @foreach($departments as $department)
                            <div class="flex items-center">
                                <input type="checkbox" name="departments[]" value="{{ $department->id }}" id="edit-dept-{{ $department->id }}" class="mr-2 edit-dept-checkbox">
                                <label for="edit-dept-{{ $department->id }}" class="text-gray-800">{{ $department->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                    <button type="button" id="cancelEditPositionModalBtn" class="btn btn-gray">Cancel</button>
                    <button type="submit" class="btn btn-green">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
#editOrgModal .form-input,
#editOrgModal .form-select,
#editOrgModal .form-label,
#addPositionModal .form-input,
#addPositionModal .form-select,
#addPositionModal .form-label,
#assignAdviserModal .form-input,
#assignAdviserModal .form-select,
#assignAdviserModal .form-label,
#editPositionModal .form-input,
#editPositionModal .form-select,
#editPositionModal .form-label {
    font-size: 14px !important;
}
</style>
<script>
function showEditOrgModal() {
    document.getElementById('editOrgModal').classList.remove('hidden');
}
function hideEditOrgModal() {
    document.getElementById('editOrgModal').classList.add('hidden');
}
document.getElementById('assignAdviserBtn').addEventListener('click', function() {
    document.getElementById('assignAdviserModal').classList.remove('hidden');
});
document.getElementById('closeAdviserModalBtn').addEventListener('click', function() {
    document.getElementById('assignAdviserModal').classList.add('hidden');
});
document.getElementById('cancelAdviserModalBtn').addEventListener('click', function() {
    document.getElementById('assignAdviserModal').classList.add('hidden');
});
document.getElementById('addPositionBtn').addEventListener('click', function() {
    document.getElementById('addPositionModal').classList.remove('hidden');
});
document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('addPositionModal').classList.add('hidden');
});
document.getElementById('cancelModalBtn').addEventListener('click', function() {
    document.getElementById('addPositionModal').classList.add('hidden');
});
const adviserInput = document.getElementById('adviserSearchInput');
const selectedIcon = document.getElementById('adviserSelectedIcon');
adviserInput.addEventListener('input', function() {
    var query = this.value;
    document.getElementById('selectedAdviserId').value = '';
    document.getElementById('assignAdviserSubmitBtn').disabled = true;
    selectedIcon.classList.add('hidden');
    if (query.length >= 2) {
        fetch(`/admin/orgs/${@json($org->id)}/search-advisers?q=` + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                var resultsDiv = document.getElementById('adviserSearchResults');
                resultsDiv.innerHTML = '';
                if (data.length === 0) {
                    resultsDiv.innerHTML = '<div class="text-gray-400 text-sm">No advisers found.</div>';
                }
                data.forEach(adviser => {
                    var div = document.createElement('div');
                    div.className = 'py-2 px-3 rounded cursor-pointer hover:bg-green-100 flex items-center gap-2';
                    div.innerHTML = `<span class='font-medium text-gray-800'>${adviser.name}</span> <span class='text-xs text-gray-500'>(${adviser.email})</span>`;
                    div.addEventListener('click', function() {
                        document.getElementById('selectedAdviserId').value = adviser.id;
                        adviserInput.value = adviser.name + ' (' + adviser.email + ')';
                        document.getElementById('assignAdviserSubmitBtn').disabled = false;
                        selectedIcon.classList.remove('hidden');
                        resultsDiv.innerHTML = '';
                    });
                    resultsDiv.appendChild(div);
                });
            });
    } else {
        document.getElementById('adviserSearchResults').innerHTML = '';
    }
});
function showEditPositionModal(id, title, description, departments, slots, order) {
    const modal = document.getElementById('editPositionModal');
    document.getElementById('editPositionTitle').value = title;
    document.getElementById('editPositionDescription').value = description || '';
    document.getElementById('editPositionSlots').value = slots;
    document.getElementById('editPositionOrder').value = order;
    // Uncheck all department checkboxes first
    document.querySelectorAll('.edit-dept-checkbox').forEach(cb => cb.checked = false);
    // Check the departments for this position
    if (departments && Array.isArray(departments)) {
        departments.forEach(function(deptId) {
            const cb = document.getElementById('edit-dept-' + deptId);
            if (cb) cb.checked = true;
        });
    }
    // Set the form action
    document.getElementById('editPositionForm').action = '/admin/positions/' + id;
    modal.classList.remove('hidden');
}
document.getElementById('closeEditPositionModalBtn').addEventListener('click', function() {
    document.getElementById('editPositionModal').classList.add('hidden');
});
document.getElementById('cancelEditPositionModalBtn').addEventListener('click', function() {
    document.getElementById('editPositionModal').classList.add('hidden');
});
function previewEditOrgLogo(event) {
    const input = event.target;
    const previewWrapper = document.getElementById('editOrgLogoPreviewWrapper');
    const preview = document.getElementById('editOrgLogoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewWrapper.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        previewWrapper.style.display = 'none';
    }
}
</script>
@endsection
