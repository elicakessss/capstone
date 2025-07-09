@extends('layouts.app')

@section('title', $orgTerm->org->name . ' - ' . $orgTerm->term . ' Term')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $orgTerm->org->name }}
                @if(!empty($orgTerm->academic_year))
                    <span class="text-lg text-gray-500 font-normal ml-2">({{ $orgTerm->academic_year }})</span>
                @endif
            </h1>
        </div>
        <a href="{{ route('orgs.index') }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <!-- Main Grid Layout: 2 cards on top, 1 wide card below -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Org Term Details Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between" style="border-left: 5px solid {{ $orgTerm->org->department->color ?? '#00471B' }};">
            <div class="flex items-center gap-4 mb-4">
                @if($orgTerm->org->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($orgTerm->org->logo) }}" alt="{{ $orgTerm->org->name }} Logo" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                @else
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-xl font-bold border border-gray-200 shadow-sm">
                        <i class="fas fa-users"></i>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $orgTerm->org->name }}</h2>
                    <div class="text-gray-500 text-sm">Type: {{ $orgTerm->org->type }}</div>
                    @if($orgTerm->org->department)
                        <div class="text-gray-500 text-sm mt-1">Department: {{ $orgTerm->org->department->name }}</div>
                    @endif
                    <div class="text-gray-500 text-sm mt-1">Academic Year: <span class="font-semibold text-green-700">{{ $orgTerm->academic_year ?? 'N/A' }}</span></div>
                </div>
            </div>
        </div>
        <!-- Advisers Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Advisers</h2>
                {{-- Future: Evaluation status or actions can go here --}}
            </div>
            <div class="text-gray-500 text-sm mb-2">
                @if(isset($advisers) && $advisers->count())
                    <ul>
                        @foreach($advisers as $adviser)
                            <li class="mb-1">{{ $adviser->name }} ({{ $adviser->email }})</li>
                        @endforeach
                    </ul>
                @else
                    No advisers assigned yet.
                @endif
            </div>
            <div class="mt-4 p-3 bg-gray-100 rounded text-center text-gray-500 text-sm border border-dashed border-gray-300">
                <i class="fas fa-clipboard-check mr-1"></i> Evaluation status and actions will appear here in the future.
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1">
        <!-- Positions Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Positions</h2>
                {{-- Assign Student button removed as requested --}}
            </div>
            @php
                $sortedPositions = $positions->sortBy('order');
            @endphp
            @if($positions->count())
                <ul class="mb-2">
                    @foreach($sortedPositions as $position)
                        <li class="mb-2 p-3 bg-gray-50 rounded border">
                            <div class="mb-2 flex items-center justify-between">
                                <div>
                                    <span class="font-semibold">{{ $position->title }}</span>
                                    <span class="text-xs text-gray-400 ml-2">(Slots: {{ $position->slots }}, Order: {{ $position->order }})</span>
                                </div>
                                @if($isAdviserOrAdmin)
                                    <button class="btn btn-blue btn-sm" type="button" onclick="showAssignStudentModal({{ $position->id }})">Assign</button>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mb-1">Assigned:</div>
                            @if($position->users->count())
                                <ul class="space-y-2">
                                    @foreach($position->users as $user)
                                        <li class="bg-white border border-gray-200 rounded px-3 py-3 flex items-center gap-4" style="border-left: 6px solid {{ $user->department->color ?? '#e5e7eb' }};">
                                            @if($user->profile_picture)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_picture) }}" alt="{{ $user->name }} Profile" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                            @else
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-lg font-bold border border-gray-200">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-gray-900 truncate">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500 truncate">ID: {{ $user->id }}</div>
                                            </div>
                                            @if($isAdviserOrAdmin)
                                                <form method="POST" action="{{ route('org_terms.removeStudent', [$orgTerm, $position, $user]) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ml-1 text-red-600 hover:text-red-800" title="Remove Student" style="background: none; border: none; padding: 0; cursor: pointer;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-gray-400">No students assigned</div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 text-sm mb-2">No positions yet.</div>
            @endif
        </div>
    </div>
</div>
<!-- Modal for Assigning Student to Position -->
<div id="assignStudentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Assign Student to Position</h3>
            <button id="closeStudentModalBtn" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
        </div>
        <form method="POST" action="{{ route('org_terms.assignStudent', $orgTerm) }}" class="px-6 pt-6 pb-2">
            @csrf
            <input type="hidden" name="position_id" id="assignPositionId">
            <div class="mb-4">
                <label class="form-label text-base">Search Student</label>
                <input type="text" id="studentSearchInput" class="form-input w-full text-base" placeholder="Type name or email...">
            </div>
            <div id="studentSearchResults" class="mb-4 max-h-40 overflow-y-auto border rounded p-2 bg-gray-50"></div>
            <input type="hidden" name="student_id" id="selectedStudentId">
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" id="cancelStudentModalBtn" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green" id="assignStudentSubmitBtn" disabled>Assign</button>
            </div>
        </form>
    </div>
</div>
<script>
@if($isAdviserOrAdmin)
// Student assignment modal logic
function showAssignStudentModal(positionId) {
    document.getElementById('assignPositionId').value = positionId;
    document.getElementById('assignStudentModal').classList.remove('hidden');
    document.getElementById('studentSearchInput').value = '';
    document.getElementById('studentSearchResults').innerHTML = '';
    document.getElementById('selectedStudentId').value = '';
    document.getElementById('assignStudentSubmitBtn').disabled = true;
}
// Only add event listeners if the elements exist
if (document.getElementById('closeStudentModalBtn')) {
    document.getElementById('closeStudentModalBtn').addEventListener('click', function() {
        document.getElementById('assignStudentModal').classList.add('hidden');
    });
}
if (document.getElementById('cancelStudentModalBtn')) {
    document.getElementById('cancelStudentModalBtn').addEventListener('click', function() {
        document.getElementById('assignStudentModal').classList.add('hidden');
    });
}
if (document.getElementById('studentSearchInput')) {
    document.getElementById('studentSearchInput').addEventListener('input', function() {
        var query = this.value;
        if (query.length >= 2) {
            fetch(`/org_terms/{{ $orgTerm->id }}/search-students?q=` + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    var resultsDiv = document.getElementById('studentSearchResults');
                    resultsDiv.innerHTML = '';
                    data.forEach(student => {
                        var div = document.createElement('div');
                        div.className = 'py-2 px-3 rounded cursor-pointer hover:bg-gray-100';
                        div.innerHTML = `${student.name} (${student.email})`;
                        div.addEventListener('click', function() {
                            document.getElementById('selectedStudentId').value = student.id;
                            document.getElementById('assignStudentSubmitBtn').disabled = false;
                            resultsDiv.innerHTML = '';
                        });
                        resultsDiv.appendChild(div);
                    });
                });
        } else {
            document.getElementById('studentSearchResults').innerHTML = '';
        }
    });
}
@endif
</script>
@endsection
