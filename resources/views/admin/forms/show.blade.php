@extends('layouts.app')

@section('title', $form->name . ' Evaluation Form')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $form->name }} Evaluation Form</h1>
            <p class="text-gray-600 mt-1">{{ $form->description }}</p>
        </div>
        <a href="{{ route('admin.forms.index') }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Left Column: Form Info & Assign Orgs -->
        <div class="flex flex-col gap-6 w-full md:w-1/3">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-green-900 mb-2">Form Info</h2>
                <div class="mb-2">
                    <span class="font-semibold">Name:</span> {{ $form->name }}
                </div>
                <div class="mb-2">
                    <span class="font-semibold">Criteria Weight:</span>
                    <div class="flex flex-col gap-1 mt-2 ml-2">
                        @php
                            $criteriaWeights = $form->criteriaWeights->keyBy('evaluator_type');
                        @endphp
                        <div class="flex items-center justify-between text-sm">
                            <span>Adviser</span>
                            <span>{{ $criteriaWeights['Adviser']->weight ?? 0 }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span>Peer</span>
                            <span>{{ $criteriaWeights['Peer']->weight ?? 0 }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span>Self</span>
                            <span>{{ $criteriaWeights['Self']->weight ?? 0 }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span>Length of Service</span>
                            <span>{{ $criteriaWeights['LengthOfService']->weight ?? 0 }}%</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-blue mt-2" onclick="document.getElementById('editCriteriaWeightModal').classList.remove('hidden')">
                        <i class="fas fa-pen"></i> Edit
                    </button>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-green-900 mb-2">Assign Organizations</h2>
                <form method="POST" action="{{ route('admin.forms.assign-orgs', $form) }}" class="flex flex-col items-start">
                    @csrf
                    <span class="text-gray-500 text-sm mb-4 block ml-1">Assigning organizations that can use this evaluation form</span>
                    <div class="flex flex-col w-full ml-1 max-h-48 overflow-y-auto mb-6">
                        @foreach($organizations as $org)
                            <label class="flex items-center gap-3 mb-3 text-sm" style="overflow:visible;">
                                <input type="checkbox" name="organization_ids[]" value="{{ $org->id }}" class="form-checkbox text-green-600 align-middle" style="font-size:14px;">
                                @if($org->logo && file_exists(public_path('storage/' . $org->logo)))
                                    <img src="{{ asset('storage/' . $org->logo) }}" alt="{{ $org->name }} Logo" class="h-7 w-7 object-contain rounded-full border border-gray-200 bg-white" style="min-width:1.75rem;">
                                @elseif($org->logo && file_exists(public_path('images/' . $org->logo)))
                                    <img src="{{ asset('images/' . $org->logo) }}" alt="{{ $org->name }} Logo" class="h-7 w-7 object-contain rounded-full border border-gray-200 bg-white" style="min-width:1.75rem;">
                                @else
                                    <img src="{{ asset('images/org-default.png') }}" alt="No Logo" class="h-7 w-7 object-contain rounded-full border border-gray-200 bg-gray-100" style="min-width:1.75rem;">
                                @endif
                                <span class="align-middle">{{ $org->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-green self-end mt-2"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
        </div>
        <!-- Right Column: Domains, Strands, Questions, Options -->
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-4xl font-bold text-green-900">{{ $form->name }} Evaluation Form</h2>
                    <button type="button" onclick="document.getElementById('addDomainModal').classList.remove('hidden')" class="btn btn-green">
                        <i class="fas fa-plus"></i> Add Domain
                    </button>
                </div>
                @if($form->domains && $form->domains->count())
                    @foreach($form->domains as $domain)
                        <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-green-900 mb-0 flex items-center">
                                        {{ $domain->name }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button type="button" onclick="document.getElementById('addStrandModal-{{ $domain->id }}').classList.remove('hidden')" class="icon-btn text-primary-green" title="Add Strand">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" title="Edit Domain" class="icon-btn text-primary-green small-icon ml-2" onclick="showEditDomainModal({{ $domain->id }})"><i class="fas fa-pen"></i></button>
                                    <button type="button" title="Delete Domain" class="icon-btn text-primary-green small-icon"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <p class="text-gray-500 text-base mb-4">{{ $domain->description }}</p>
                            @if($domain->strands && $domain->strands->count())
                                <div class="space-y-6">
                                @foreach($domain->strands as $strand)
                                    <div class="bg-gray-50 rounded shadow-sm p-4 mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-base font-semibold text-green-800 mb-0 flex items-center">
                                                    {{ $strand->name }}
                                                </h4>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <button type="button" onclick="document.getElementById('addQuestionModal-{{ $strand->id }}').classList.remove('hidden')" class="icon-btn text-primary-green" title="Add Question">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" title="Edit Strand" class="icon-btn text-primary-green small-icon ml-2" onclick="showEditStrandModal({{ $strand->id }})"><i class="fas fa-pen"></i></button>
                                                <button type="button" title="Delete Strand" class="icon-btn text-primary-green small-icon"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                        @if($strand->questions && $strand->questions->count())
                                            <div class="space-y-6">
                                            @foreach($strand->questions as $question)
                                                <div class="mb-6 border-b pb-4">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <input type="text" class="form-input w-full bg-gray-100 text-base font-medium text-gray-900" value="{{ $question->text }}" disabled style="font-size:14px;">
                                                        <button type="button" title="Edit Question" class="icon-btn text-primary-green small-icon" onclick="showEditQuestionModal({{ $question->id }})"><i class="fas fa-pen"></i></button>
                                                        <button type="button" title="Delete Question" class="icon-btn text-primary-green small-icon"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                    <div class="flex gap-4 mb-2 text-sm">
                                                        <label class="form-label" style="font-size:14px;"><input type="checkbox" disabled {{ $question->evaluatorTypes->contains('evaluator_type', 'Adviser') ? 'checked' : '' }}> Adviser</label>
                                                        <label class="form-label" style="font-size:14px;"><input type="checkbox" disabled {{ $question->evaluatorTypes->contains('evaluator_type', 'Peer') ? 'checked' : '' }}> Peer</label>
                                                        <label class="form-label" style="font-size:14px;"><input type="checkbox" disabled {{ $question->evaluatorTypes->contains('evaluator_type', 'Self') ? 'checked' : '' }}> Self</label>
                                                    </div>
                                                    @foreach($question->likertScales->sortBy('order') as $option)
                                                        <div class="flex gap-2 mb-1 items-center text-base">
                                                            <input type="radio" disabled class="form-radio text-green-600" style="font-size:14px;">
                                                            <input type="text" class="form-input bg-gray-100 flex-1 text-base" value="{{ $option->label }}" disabled style="font-size:14px;">
                                                            <input type="number" class="form-input w-20 bg-gray-100 text-base" value="{{ $option->score }}" disabled style="font-size:14px;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-400 text-xs">No questions yet.</p>
                                        @endif
                                        <!-- Add Question Modal for this strand -->
                                        <div id="addQuestionModal-{{ $strand->id }}" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
                                                <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                                                    <h3 class="text-lg font-semibold text-white">Add Question</h3>
                                                    <button type="button" onclick="document.getElementById('addQuestionModal-{{ $strand->id }}').classList.add('hidden')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
                                                </div>
                                                <form method="POST" action="{{ route('admin.forms.domains.strands.questions.store', [$form, $domain, $strand]) }}" class="px-6 pt-6 pb-2" id="addQuestionForm-{{ $strand->id }}">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label class="form-label" style="font-size:14px;">Question Text</label>
                                                        <input type="text" name="text" class="form-input w-full" style="font-size:14px;" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" style="font-size:14px;">Evaluator Types</label>
                                                        <div class="flex gap-4">
                                                            <label class="form-label" style="font-size:14px;"><input type="checkbox" name="evaluator_types[]" value="Adviser"> Adviser</label>
                                                            <label class="form-label" style="font-size:14px;"><input type="checkbox" name="evaluator_types[]" value="Peer"> Peer</label>
                                                            <label class="form-label" style="font-size:14px;"><input type="checkbox" name="evaluator_types[]" value="Self"> Self</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" style="font-size:14px;">Likert Scale Options</label>
                                                        <div id="likertOptions-{{ $strand->id }}">
                                                            @for($i = 0; $i < 4; $i++)
                                                                <div class="flex gap-2 mb-1">
                                                                    <input type="text" name="likert_labels[]" class="form-input" placeholder="Label (e.g. Excellent)" style="font-size:14px;" required>
                                                                    <input type="number" name="likert_scores[]" class="form-input w-20" placeholder="Score" style="font-size:14px;" required>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-blue mt-2" onclick="addLikertOption('{{ $strand->id }}')"><i class="fas fa-plus"></i> Add Option</button>
                                                    </div>
                                                    <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                                                        <button type="submit" class="btn btn-green"><i class="fas fa-plus"></i> Add Question</button>
                                                    </div>
                                                </form>
                                                <script>
                                                function addLikertOption(strandId) {
                                                    var container = document.getElementById('likertOptions-' + strandId);
                                                    var div = document.createElement('div');
                                                    div.className = 'flex gap-2 mb-1';
                                                    div.innerHTML = `<input type=\"text\" name=\"likert_labels[]\" class=\"form-input\" placeholder=\"Label (e.g. Option)\" style=\"font-size:14px;\" required> <input type=\"number\" name=\"likert_scores[]\" class=\"form-input w-20\" placeholder=\"Score\" style=\"font-size:14px;\" required>`;
                                                    container.appendChild(div);
                                                }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @else
                                <p class="text-gray-400 text-xs ml-4">No strands yet.</p>
                            @endif
                            <!-- Add Strand Modal -->
                            <div id="addStrandModal-{{ $domain->id }}" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
                                    <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                                        <h3 class="text-lg font-semibold text-white">Add Strand</h3>
                                        <button type="button" onclick="document.getElementById('addStrandModal-{{ $domain->id }}').classList.add('hidden')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.forms.domains.strands.store', [$form, $domain]) }}" class="px-6 pt-6 pb-2">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label" style="font-size:14px;">Strand Name</label>
                                            <input type="text" name="name" class="form-input w-full" style="font-size:14px;" required>
                                        </div>
                                        <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                                            <button type="submit" class="btn btn-green"><i class="fas fa-plus"></i> Add Strand</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Edit Domain Modal -->
                            <div id="editDomainModal-{{ $domain->id }}" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
                                    <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                                        <h3 class="text-lg font-semibold text-white">Edit Domain</h3>
                                        <button type="button" onclick="closeModal('editDomainModal-{{ $domain->id }}')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.forms.domains.update', [$form, $domain]) }}" class="px-6 pt-6 pb-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label class="form-label" style="font-size:14px;">Domain Name</label>
                                            <input type="text" name="name" class="form-input w-full" style="font-size:14px;" value="{{ $domain->name }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" style="font-size:14px;">Description</label>
                                            <input type="text" name="description" class="form-input w-full" style="font-size:14px;" value="{{ $domain->description }}">
                                        </div>
                                        <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                                            <button type="submit" class="btn btn-green"><i class="fas fa-save"></i> Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">No domains added yet.</p>
                @endif
            </div>
            <!-- Add Domain Modal -->
            <div id="addDomainModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
                    <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
                        <h3 class="text-lg font-semibold text-white">Add Domain</h3>
                        <button type="button" onclick="document.getElementById('addDomainModal').classList.add('hidden')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
                    </div>
                    <form method="POST" action="{{ route('admin.forms.domains.store', $form) }}" class="px-6 pt-6 pb-2">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label" style="font-size:14px;">Domain Name</label>
                            <input type="text" name="name" class="form-input w-full" style="font-size:14px;" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" style="font-size:14px;">Description</label>
                            <input type="text" name="description" class="form-input w-full" style="font-size:14px;">
                        </div>
                        <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                            <button type="submit" class="btn btn-green"><i class="fas fa-plus"></i> Add Domain</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Criteria Weight Modal -->
<div id="editCriteriaWeightModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Edit Criteria Weights</h3>
            <button type="button" onclick="document.getElementById('editCriteriaWeightModal').classList.add('hidden')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.forms.criteria-weights.update', $form) }}" class="px-6 pt-6 pb-2">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="form-label" style="font-size:14px;">Adviser (%)</label>
                <input type="number" name="weights[Adviser]" class="form-input w-full" style="font-size:14px;" min="0" max="100" value="{{ $criteriaWeights['Adviser']->weight ?? 0 }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label" style="font-size:14px;">Peer (%)</label>
                <input type="number" name="weights[Peer]" class="form-input w-full" style="font-size:14px;" min="0" max="100" value="{{ $criteriaWeights['Peer']->weight ?? 0 }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label" style="font-size:14px;">Self (%)</label>
                <input type="number" name="weights[Self]" class="form-input w-full" style="font-size:14px;" min="0" max="100" value="{{ $criteriaWeights['Self']->weight ?? 0 }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label" style="font-size:14px;">Length of Service (%)</label>
                <input type="number" name="weights[LengthOfService]" class="form-input w-full" style="font-size:14px;" min="0" max="100" value="{{ $criteriaWeights['LengthOfService']->weight ?? 0 }}" required>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="submit" class="btn btn-green"><i class="fas fa-save"></i> Save</button>
            </div>
            <div class="text-xs text-gray-500 mt-2">Total must be 100%.</div>
        </form>
    </div>
</div>
<!-- Font size/style consistency for all modal and inline form fields -->
<style>
    .form-input,
    .form-label,
    .form-select,
    .form-textarea {
        font-size: 14px !important;
    }
    /* Subtle, modern icon button styles */
    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: none;
        border: none;
        color: #00471B;
        transition: background 0.15s, color 0.15s;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0;
    }
    .icon-btn.small-icon {
        width: 24px;
        height: 24px;
        font-size: 0.95rem;
    }
    .icon-btn:hover, .icon-btn:focus {
        background: #f3f4f6;
        color: #00471B;
    }
    .icon-btn:active {
        background: #e5e7eb;
    }
    .text-primary-green { color: #00471B !important; }
    .icon-btn[title]::after {
        content: attr(title);
        position: absolute;
        left: 100%;
        margin-left: 8px;
        background: #222;
        color: #fff;
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 4px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        white-space: nowrap;
        z-index: 100;
    }
    .icon-btn:focus[title]::after,
    .icon-btn:hover[title]::after {
        opacity: 1;
    }
    /* Modal content flush, like user modals */
    .modal-content { padding: 0 !important; }
    .modal-body { padding: 0 !important; }
    form { padding: 1.5rem !important; }
</style>
<script>
// Use openModal helper if available, else fallback
function showEditDomainModal(domainId) {
    if (typeof openModal === 'function') {
        openModal('editDomainModal-' + domainId);
    } else {
        document.getElementById('editDomainModal-' + domainId).classList.remove('hidden');
    }
}
function showEditStrandModal(strandId) {
    if (typeof openModal === 'function') {
        openModal('editStrandModal-' + strandId);
    } else {
        document.getElementById('editStrandModal-' + strandId).classList.remove('hidden');
    }
}
function showEditQuestionModal(questionId) {
    if (typeof openModal === 'function') {
        openModal('editQuestionModal-' + questionId);
    } else {
        document.getElementById('editQuestionModal-' + questionId).classList.remove('hidden');
    }
}
</script>
@endsection
