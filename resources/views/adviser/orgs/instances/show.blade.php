@extends('layouts.app')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $org->name }} Organization</h1>
            <div class="text-gray-500 text-sm">Academic Year: {{ $org->term }}</div>
        </div>
        <a href="{{ route('adviser.orgs.instances.index') }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="grid grid-cols-1">
        <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Positions & Members</h2>
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
                            <div class="flex items-center gap-2 mt-2 md:mt-0">
                                @if($position->users->count())
                                    @foreach($position->users as $user)
                                        <span class="text-green-700 font-semibold">{{ $user->name }}</span>
                                    @endforeach
                                @else
                                    <button class="btn btn-sm btn-primary" onclick="openAssignStudentModal({{ $position->id }})">Assign Student</button>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 text-sm mb-2">No positions yet.</div>
            @endif
        </div>
    </div>
    <!-- Modal for Assigning Student -->
    <div id="assignStudentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button id="closeAssignStudentModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">&times;</button>
            <h3 class="text-lg font-bold mb-4">Assign Student to Position</h3>
            <form id="assignStudentForm" method="POST" action="">
                @csrf
                <input type="hidden" name="position_id" id="assignPositionId">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Search Student</label>
                    <input type="text" id="studentSearchInput" class="form-input w-full" placeholder="Type name or email...">
                </div>
                <div id="studentSearchResults" class="mb-4 max-h-40 overflow-y-auto border rounded p-2 bg-gray-50"></div>
                <input type="hidden" name="student_id" id="selectedStudentId">
                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelAssignStudentBtn" class="btn btn-sm btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="assignStudentSubmitBtn" disabled>Assign</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openAssignStudentModal(positionId) {
            document.getElementById('assignStudentModal').classList.remove('hidden');
            document.getElementById('assignPositionId').value = positionId;
            document.getElementById('studentSearchInput').value = '';
            document.getElementById('studentSearchResults').innerHTML = '';
            document.getElementById('selectedStudentId').value = '';
            document.getElementById('assignStudentSubmitBtn').disabled = true;
        }
        document.getElementById('closeAssignStudentModalBtn').onclick = function() {
            document.getElementById('assignStudentModal').classList.add('hidden');
        };
        document.getElementById('cancelAssignStudentBtn').onclick = function() {
            document.getElementById('assignStudentModal').classList.add('hidden');
        };
        document.getElementById('studentSearchInput').addEventListener('input', function() {
            const query = this.value.trim();
            const positionId = document.getElementById('assignPositionId').value;
            const orgId = {{ $org->id }};
            if (query.length < 2) return;
            fetch(`/adviser/orgs/${orgId}/positions/${positionId}/search-students?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    const results = document.getElementById('studentSearchResults');
                    if (data.length === 0) {
                        results.innerHTML = '<div class="text-gray-500 text-sm">No students found or already assigned to a position.</div>';
                    } else {
                        results.innerHTML = data.map(student =>
                            `<div class='p-2 hover:bg-green-100 rounded cursor-pointer student-result' data-id='${student.id}' data-name='${student.name}'>${student.name} <span class='text-xs text-gray-500'>(${student.email})</span></div>`
                        ).join('');
                        document.querySelectorAll('.student-result').forEach(el => {
                            el.addEventListener('click', function() {
                                document.getElementById('selectedStudentId').value = this.dataset.id;
                                document.getElementById('studentSearchInput').value = this.dataset.name;
                                document.getElementById('assignStudentSubmitBtn').disabled = false;
                                results.innerHTML = '';
                            });
                        });
                    }
                });
        });
    </script>
</div>
@endsection
