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
            <!-- Edit/Delete buttons -->
            <div class="mt-4 flex gap-2">
                <a href="{{ route('admin.orgs.edit', $org) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.orgs.destroy', $org) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
        <!-- Advisers Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Advisers who can use this</h2>
                <button id="assignAdviserBtn" class="btn btn-sm btn-primary" type="button">Assign Adviser</button>
            </div>
            <div class="text-gray-500 text-sm mb-2">@if(isset($advisers) && $advisers->count())
                <ul>
                    @foreach($advisers as $adviser)
                        <li class="mb-1">{{ $adviser->name }} ({{ $adviser->email }})</li>
                    @endforeach
                </ul>
            @else
                No advisers assigned yet.
            @endif</div>
        </div>
    </div>
    <div class="grid grid-cols-1">
        <!-- Positions Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Positions</h2>
                <button id="addPositionBtn" class="btn btn-sm btn-primary" type="button">Add Branch Position</button>
            </div>
            @if($positions->count())
                <ul class="mb-2">
                    @foreach($positions as $position)
                        <li class="mb-2 p-3 bg-gray-50 rounded border flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <span class="font-semibold">{{ $position->title }}</span>
                                <span class="text-xs text-gray-500 ml-2">Allowed Departments:
                                    @foreach($position->departments as $dept)
                                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded mr-1">{{ $dept->name }}</span>
                                    @endforeach
                                </span>
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
    <!-- Modal for Adding Position -->
    <div id="addPositionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold mb-4">Add Branch Position</h3>
            <form method="POST" action="{{ route('admin.orgs.positions.store', $org) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Position Title</label>
                    <input type="text" name="title" class="form-input w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Allowed Departments</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        @foreach($departments as $department)
                            <div class="flex items-center">
                                <input type="checkbox" name="departments[]" value="{{ $department->id }}" id="dept-{{ $department->id }}" class="mr-2">
                                <label for="dept-{{ $department->id }}" class="text-gray-800">{{ $department->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelModalBtn" class="btn btn-sm btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal for Assigning Adviser -->
    <div id="assignAdviserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button id="closeAdviserModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold mb-4">Assign Adviser</h3>
            <form method="POST" action="{{ route('admin.orgs.assignAdviser', $org) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Search Adviser</label>
                    <input type="text" id="adviserSearchInput" class="form-input w-full" placeholder="Type name or email...">
                </div>
                <div id="adviserSearchResults" class="mb-4 max-h-40 overflow-y-auto border rounded p-2 bg-gray-50"></div>
                <input type="hidden" name="adviser_id" id="selectedAdviserId">
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelAdviserModalBtn" class="btn btn-sm btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="assignAdviserSubmitBtn" disabled>Assign</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addPositionModal');
            const openBtn = document.getElementById('addPositionBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            function openModal() { modal.classList.remove('hidden'); }
            function closeModal() { modal.classList.add('hidden'); }
            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Adviser modal functionality
            const adviserModal = document.getElementById('assignAdviserModal');
            const openAdviserBtn = document.getElementById('assignAdviserBtn');
            const closeAdviserBtn = document.getElementById('closeAdviserModalBtn');
            const cancelAdviserBtn = document.getElementById('cancelAdviserModalBtn');
            const adviserSearchInput = document.getElementById('adviserSearchInput');
            const adviserSearchResults = document.getElementById('adviserSearchResults');
            const selectedAdviserId = document.getElementById('selectedAdviserId');
            const assignAdviserSubmitBtn = document.getElementById('assignAdviserSubmitBtn');

            function openAdviserModal() { adviserModal.classList.remove('hidden'); }
            function closeAdviserModal() { adviserModal.classList.add('hidden'); adviserSearchResults.innerHTML = ''; adviserSearchInput.value = ''; assignAdviserSubmitBtn.disabled = true; }
            openAdviserBtn.addEventListener('click', openAdviserModal);
            closeAdviserBtn.addEventListener('click', closeAdviserModal);
            cancelAdviserBtn.addEventListener('click', closeAdviserModal);

            adviserSearchInput.addEventListener('input', function() {
                const query = adviserSearchInput.value.trim();
                adviserSearchResults.innerHTML = '';
                assignAdviserSubmitBtn.disabled = true;
                selectedAdviserId.value = '';
                if (query.length < 2) return;
                fetch(`{{ route('admin.orgs.searchAdvisers', $org) }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            adviserSearchResults.innerHTML = '<div class="text-gray-500 text-sm">No advisers found.</div>';
                        } else {
                            adviserSearchResults.innerHTML = data.map(adviser =>
                                `<div class='p-2 hover:bg-green-100 rounded cursor-pointer adviser-result' data-id='${adviser.id}' data-name='${adviser.name}'>${adviser.name} <span class='text-xs text-gray-500'>(${adviser.email})</span></div>`
                            ).join('');
                            document.querySelectorAll('.adviser-result').forEach(el => {
                                el.addEventListener('click', function() {
                                    selectedAdviserId.value = this.dataset.id;
                                    adviserSearchInput.value = this.dataset.name;
                                    assignAdviserSubmitBtn.disabled = false;
                                    adviserSearchResults.innerHTML = '';
                                });
                            });
                        }
                    });
            });
        });
    </script>
</div>
@endsection
