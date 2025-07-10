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
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col" style="border-left: 5px solid #00471B;">
            <div class="flex flex-col items-center mb-4">
                @if($orgTerm->org->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($orgTerm->org->logo) }}" alt="{{ $orgTerm->org->name }} Logo" class="w-28 h-28 rounded-full object-cover shadow mb-3">
                @else
                    <div class="w-28 h-28 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-4xl font-bold shadow mb-3">
                        <i class="fas fa-users"></i>
                    </div>
                @endif
                <h2 class="text-2xl font-bold text-gray-900 text-center mb-1">{{ $orgTerm->org->name }}</h2>
                <div class="w-full border-b border-gray-200 my-3"></div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="text-gray-500 text-sm">Academic Year: <span class="font-semibold text-green-700">{{ $orgTerm->academic_year ?? 'N/A' }}</span></div>
                <div class="text-gray-500 text-sm">Type: {{ $orgTerm->org->type }}</div>
                @if($orgTerm->org->department)
                    <div class="text-gray-500 text-sm">Department: {{ $orgTerm->org->department->name }}</div>
                @endif
                <div class="mt-2">
                    <span class="font-semibold text-gray-900">Advisers:</span>
                    <span class="text-gray-500 text-sm">
                    @if(isset($advisers) && $advisers->count())
                        @foreach($advisers as $adviser)
                            <span class="flex items-center gap-2 mb-1">
                                @if($adviser->profile_picture)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($adviser->profile_picture) }}" alt="{{ $adviser->name }} Profile" class="w-7 h-7 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-xs font-bold border border-gray-200">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <span>{{ $adviser->name }} ({{ $adviser->email }})</span>
                            </span>
                        @endforeach
                    @else
                        <span>No advisers assigned yet.</span>
                    @endif
                    </span>
                </div>
            </div>
        </div>
        <!-- Evaluation Feature Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
            <div class="flex flex-col gap-2 mb-2">
                <h2 class="text-xl font-bold text-gray-900">Evaluation</h2>
                <div class="text-gray-600 text-sm">Monitor evaluation progress and assign peer evaluators before starting the evaluation for this term.</div>
            </div>
            @if($isAdviserOrAdmin)
                @if(empty($orgTerm->evaluation_state) || $orgTerm->evaluation_state === 'cancelled' || $orgTerm->evaluation_state === 'not_started')
                    <form method="POST" action="{{ route('org_terms.startEvaluation', $orgTerm) }}">
                        @csrf
                        <div class="flex flex-col gap-3 mb-2">
                            <select name="peer_1" class="form-select w-full" required>
                                <option value="">Peer Evaluator</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ (isset($peerEvaluators[1]) && $peerEvaluators[1]->peer_id == $student->id) ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                            <select name="peer_2" class="form-select w-full" required>
                                <option value="">Peer Evaluator</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ (isset($peerEvaluators[2]) && $peerEvaluators[2]->peer_id == $student->id) ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end mb-2">
                            <button type="submit" class="btn btn-green btn-sm"><i class="fas fa-play"></i> Start Evaluation</button>
                        </div>
                    </form>
                @elseif($orgTerm->evaluation_state === 'in_progress')
                    @if(isset($allEvaluationsComplete) && $allEvaluationsComplete)
                        <form method="POST" action="{{ route('org_terms.closeEvaluation', $orgTerm) }}">
                            @csrf
                            <div class="flex justify-end mb-2">
                                <button type="submit" class="btn btn-green btn-sm"><i class="fas fa-check"></i> Submit Evaluation</button>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route('org_terms.cancelEvaluation', $orgTerm) }}">
                            @csrf
                            <div class="flex justify-end mb-2">
                                <button type="submit" class="btn btn-red btn-sm"><i class="fas fa-times"></i> Cancel Evaluation</button>
                            </div>
                        </form>
                    @endif
                @elseif($orgTerm->evaluation_state === 'closed')
                    <div class="flex justify-end mb-2">
                        <button class="btn btn-gray btn-sm cursor-default opacity-70" disabled><i class="fas fa-flag-checkered"></i> Evaluation Ended</button>
                    </div>
                @endif
            @endif
            @if($orgTerm->evaluation_state === 'in_progress' || $orgTerm->evaluation_state === 'closed')
            <div class="w-full border-b border-gray-200 my-3"></div>
            <div class="space-y-4 mt-2">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-purple-900">Adviser Evaluation</span>
                        <span class="text-xs font-semibold text-purple-700">{{ $adviserProgress ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-purple-500 h-3 rounded-full transition-all duration-300" style="width: {{ $adviserProgress ?? 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-blue-900">Peer Evaluation</span>
                        <span class="text-xs font-semibold text-blue-700">{{ $peerProgress ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full transition-all duration-300" style="width: {{ $peerProgress ?? 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-green-900">Self Evaluation</span>
                        <span class="text-xs font-semibold text-green-700">{{ $selfProgress ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full transition-all duration-300" style="width: {{ $selfProgress ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1">
        <!-- Positions Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between" style="border-left: 5px solid #00471B;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Positions</h2>
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
                                @if($isAdviserOrAdmin && (empty($orgTerm->evaluation_state) || $orgTerm->evaluation_state === 'cancelled' || $orgTerm->evaluation_state === 'not_started'))
                                    <button class="btn btn-blue btn-sm" type="button" onclick="showAssignStudentModal({{ $position->id }})">Assign</button>
                                @endif
                            </div>
                            @if($position->users->count())
                                <ul class="space-y-2">
                                    @foreach($position->users as $user)
                                        @php
                                            $deptColor = $user->department && $user->department->color ? $user->department->color : '#00471B';
                                            $hasEvaluation = isset($studentEvalStatus[$user->id]) && (
                                                $studentEvalStatus[$user->id]['self'] || $studentEvalStatus[$user->id]['peer'] || $studentEvalStatus[$user->id]['adviser']
                                            );
                                        @endphp
                                        <li class="bg-white border border-gray-200 rounded px-3 py-3 flex items-center gap-4" style="border-left: 6px solid {{ $deptColor }};">
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
                                            @if(($isAdviserOrAdmin || (auth()->user() && in_array('student', auth()->user()->roles ?? []))) && ($orgTerm->evaluation_state === 'in_progress' || $orgTerm->evaluation_state === 'closed'))
                                            <div class="flex flex-col items-end gap-1">
                                                {{-- Evaluation status indicators --}}
                                                <div class="flex gap-1">
                                                    <span title="Self Evaluation" class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ isset($studentEvalStatus[$user->id]['self']) && $studentEvalStatus[$user->id]['self'] ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-500' }}">
                                                        <i class="fas fa-user"></i> S
                                                    </span>
                                                    <span title="Peer Evaluation" class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ isset($studentEvalStatus[$user->id]['peer']) && $studentEvalStatus[$user->id]['peer'] ? 'bg-blue-200 text-blue-800' : 'bg-gray-200 text-gray-500' }}">
                                                        <i class="fas fa-users"></i> P
                                                    </span>
                                                    <span title="Adviser Evaluation" class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ isset($studentEvalStatus[$user->id]['adviser']) && $studentEvalStatus[$user->id]['adviser'] ? 'bg-purple-200 text-purple-800' : 'bg-gray-200 text-gray-500' }}">
                                                        <i class="fas fa-chalkboard-teacher"></i> A
                                                    </span>
                                                </div>
                                                {{-- Self Evaluation Button (Green) --}}
                                                @if($user->id === auth()->id() && $orgTerm->evaluation_state === 'in_progress')
                                                    @if(isset($studentEvalStatus[$user->id]['self']) && $studentEvalStatus[$user->id]['self'])
                                                        <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="View/Edit Self Evaluation">
                                                            <i class="fas fa-eye" style="color: #00471B; font-size: 1.25rem;"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="Self Evaluate">
                                                            <i class="fas fa-clipboard-list" style="color: #00471B; font-size: 1.25rem;"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                {{-- Peer Evaluation Button (Green, uniform) --}}
                                                @php
                                                    $isPeerEvaluator = false;
                                                    if(isset($peerEvaluators)) {
                                                        foreach($peerEvaluators as $peerEval) {
                                                            if($peerEval->peer_id == auth()->id()) {
                                                                $isPeerEvaluator = true;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @if($isPeerEvaluator && $user->id !== auth()->id() && $orgTerm->evaluation_state === 'in_progress')
                                                    @if(isset($studentEvalStatus[$user->id]['peer']) && $studentEvalStatus[$user->id]['peer'])
                                                        <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="View/Edit Peer Evaluation">
                                                            <i class="fas fa-eye" style="color: #00471B; font-size: 1.25rem;"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="Peer Evaluate">
                                                            <i class="fas fa-clipboard-list" style="color: #00471B; font-size: 1.25rem;"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                {{-- Adviser/Admin View/Edit Buttons (unchanged) --}}
                                                @if($isAdviserOrAdmin && $orgTerm->evaluation_state === 'in_progress')
                                                    @if($hasEvaluation)
                                                        <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="View/Edit Evaluation">
                                                            <i class="fas fa-eye" style="color: #00471B; font-size: 1.25rem;"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="Evaluate">
                                                            <i class="fas fa-clipboard-list" style="color: #00471B; font-size: 1.25rem;"></i>
                                                        </a>
                                                    @endif
                                                @elseif($isAdviserOrAdmin && $orgTerm->evaluation_state === 'closed' && $hasEvaluation)
                                                    <a href="{{ route('org_terms.evaluate', [$orgTerm, $user]) }}" class="ml-2" title="View Evaluation">
                                                        <i class="fas fa-eye" style="color: #00471B; font-size: 1.25rem;"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            @endif
                                            @if($isAdviserOrAdmin && ($orgTerm->evaluation_state === null || $orgTerm->evaluation_state === 'cancelled'))
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
