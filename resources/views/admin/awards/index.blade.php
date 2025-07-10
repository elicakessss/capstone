@extends('layouts.app')

@section('title', 'Manage Award Types & Requests')

@section('content')
<div class="space-y-8">
    <!-- Award Ranks Management -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Award Ranks</h2>
            <button class="btn btn-green" onclick="showAwardRankModal()"><i class="fas fa-plus mr-1"></i> Add Award Rank</button>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Min Score</th>
                    <th class="px-4 py-2 text-left">Max Score</th>
                    <th class="px-4 py-2 text-left">Color</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($awardRanks as $rank)
                <tr>
                    <td class="px-4 py-2">{{ $rank->name }}</td>
                    <td class="px-4 py-2">{{ $rank->min_score }}</td>
                    <td class="px-4 py-2">{{ $rank->max_score }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block w-4 h-4 rounded-full mr-2 align-middle" style="background: {{ $rank->color ?? '#FFD600' }};"></span>
                        <span>{{ $rank->color }}</span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button class="btn btn-xs btn-gray" onclick="editAwardRank({{ $rank->id }}, '{{ addslashes($rank->name) }}', {{ $rank->min_score }}, {{ $rank->max_score }}, '{{ addslashes($rank->color) }}')"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('admin.award-ranks.destroy', $rank->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-red" onclick="return confirm('Delete this award rank?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400">No award ranks defined.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Award Types Management -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Award Types</h2>
            <button class="btn btn-green" onclick="showAwardTypeModal()"><i class="fas fa-plus mr-1"></i> Add Award Type</button>
        </div>
        <table class="table-auto w-full mb-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($awardTypes as $type)
                <tr>
                    <td class="px-4 py-2">{{ $type->name }}</td>
                    <td class="px-4 py-2">{{ $type->description }}</td>
                    <td class="px-4 py-2 text-center">
                        <button class="btn btn-xs btn-gray" onclick="editAwardType({{ $type->id }}, '{{ addslashes($type->name) }}', '{{ addslashes($type->description) }}')"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('admin.award-types.destroy', $type->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-red" onclick="return confirm('Delete this award type?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-gray-400">No award types defined.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Award Requests Management -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Award Requests</h2>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Student</th>
                    <th class="px-4 py-2 text-left">Organization</th>
                    <th class="px-4 py-2 text-left">Award Type</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($awardRequests as $request)
                <tr>
                    <td class="px-4 py-2">{{ $request->user->name }}</td>
                    <td class="px-4 py-2">{{ $request->org->name }}</td>
                    <td class="px-4 py-2">{{ $request->awardType->name }}</td>
                    <td class="px-4 py-2">{{ ucfirst($request->status) }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('admin.award-requests.show', $request->id) }}" class="btn btn-xs btn-green"><i class="fas fa-eye"></i> View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400">No award requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Award Rank Modal -->
    <div id="awardRankModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                <h3 class="text-lg font-semibold text-white" id="awardRankModalTitle">Add Award Rank</h3>
                <button onclick="hideAwardRankModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="awardRankForm" method="POST" action="{{ route('admin.award-ranks.store') }}" class="px-6 pt-6 pb-2">
                @csrf
                <input type="hidden" name="id" id="awardRankId">
                <div class="mb-4">
                    <label class="form-label text-base mb-1">Name</label>
                    <input type="text" name="name" id="awardRankName" class="form-input w-full text-base" maxlength="255" required />
                </div>
                <div class="mb-4 flex gap-2">
                    <div class="w-1/2">
                        <label class="form-label text-base mb-1">Min Score</label>
                        <input type="number" name="min_score" id="awardRankMinScore" class="form-input w-full text-base" required />
                    </div>
                    <div class="w-1/2">
                        <label class="form-label text-base mb-1">Max Score</label>
                        <input type="number" name="max_score" id="awardRankMaxScore" class="form-input w-full text-base" required />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-base mb-1">Color (hex or name)</label>
                    <input type="text" name="color" id="awardRankColor" class="form-input w-full text-base" maxlength="32" placeholder="#FFD600" />
                </div>
                <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                    <button type="button" onclick="hideAwardRankModal()" class="btn btn-gray">Cancel</button>
                    <button type="submit" class="btn btn-green">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add/Edit Award Type Modal -->
    <div id="awardTypeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
            <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                <h3 class="text-lg font-semibold text-white" id="awardTypeModalTitle">Add Award Type</h3>
                <button onclick="hideAwardTypeModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="awardTypeForm" method="POST" action="{{ route('admin.award-types.store') }}" class="px-6 pt-6 pb-2">
                @csrf
                <input type="hidden" name="id" id="awardTypeId">
                <div class="mb-4">
                    <label class="form-label text-base mb-1">Name</label>
                    <input type="text" name="name" id="awardTypeName" class="form-input w-full text-base" maxlength="255" required />
                </div>
                <div class="mb-4">
                    <label class="form-label text-base mb-1">Description</label>
                    <textarea name="description" id="awardTypeDescription" class="form-input w-full text-base" rows="2" maxlength="255"></textarea>
                </div>
                <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                    <button type="button" onclick="hideAwardTypeModal()" class="btn btn-gray">Cancel</button>
                    <button type="submit" class="btn btn-green">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    // $awardTypes and $awardRequests are both passed, but only one is filled depending on controller
    $awardTypes = $awardTypes ?? \App\Models\AwardType::orderBy('name')->get();
    $awardRequests = $awardRequests ?? \App\Models\AwardRequest::with(['user','org','awardType'])->latest()->get();
@endphp

<script>
function showAwardTypeModal() {
    document.getElementById('awardTypeModal').classList.remove('hidden');
    document.getElementById('awardTypeModalTitle').innerText = 'Add Award Type';
    document.getElementById('awardTypeForm').action = "{{ route('admin.award-types.store') }}";
    document.getElementById('awardTypeId').value = '';
    document.getElementById('awardTypeName').value = '';
    document.getElementById('awardTypeDescription').value = '';
}
function editAwardType(id, name, description) {
    showAwardTypeModal();
    document.getElementById('awardTypeModalTitle').innerText = 'Edit Award Type';
    document.getElementById('awardTypeForm').action = `/admin/award-types/${id}`;
    document.getElementById('awardTypeId').value = id;
    document.getElementById('awardTypeName').value = name;
    document.getElementById('awardTypeDescription').value = description;
}
function hideAwardTypeModal() {
    document.getElementById('awardTypeModal').classList.add('hidden');
}

function showAwardRankModal() {
    document.getElementById('awardRankModal').classList.remove('hidden');
    document.getElementById('awardRankModalTitle').innerText = 'Add Award Rank';
    document.getElementById('awardRankForm').action = "{{ route('admin.award-ranks.store') }}";
    document.getElementById('awardRankId').value = '';
    document.getElementById('awardRankName').value = '';
    document.getElementById('awardRankMinScore').value = '';
    document.getElementById('awardRankMaxScore').value = '';
    document.getElementById('awardRankColor').value = '';
}
function editAwardRank(id, name, min, max, color) {
    showAwardRankModal();
    document.getElementById('awardRankModalTitle').innerText = 'Edit Award Rank';
    document.getElementById('awardRankForm').action = `/admin/award-ranks/${id}`;
    document.getElementById('awardRankId').value = id;
    document.getElementById('awardRankName').value = name;
    document.getElementById('awardRankMinScore').value = min;
    document.getElementById('awardRankMaxScore').value = max;
    document.getElementById('awardRankColor').value = color;
}
function hideAwardRankModal() {
    document.getElementById('awardRankModal').classList.add('hidden');
}
</script>
@endsection
