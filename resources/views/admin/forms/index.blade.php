@extends('layouts.app')

@section('title', 'Evaluation Forms')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Evaluation Forms</h1>
            <p class="text-gray-600 mt-1">Manage all evaluation forms for organizations</p>
        </div>
        <button onclick="showAddFormModal()" class="btn btn-green" type="button">
            <i class="fas fa-plus"></i> Add Evaluation Form
        </button>
    </div>
    @if($forms->count())
        <div class="flex flex-col gap-6 w-full">
            @foreach($forms as $form)
                <div class="bg-white rounded-lg shadow-sm p-6 flex items-center justify-between transition-transform duration-200 cursor-pointer min-h-[80px] border border-gray-100 hover:shadow-md hover:bg-gray-50 focus:bg-gray-50 focus:shadow-md w-full transform hover:scale-[1.025] focus:scale-[1.025]"
                    tabindex="0"
                    onclick="if(event.target.tagName !== 'BUTTON' && event.target.tagName !== 'A' && !event.target.closest('form')) { window.location='{{ route('admin.forms.show', $form) }}'; }">
                    <div>
                        <span class="font-semibold text-gray-900">{{ $form->name }}</span>
                        <span class="text-gray-500 text-sm ml-2">{{ $form->description }}</span>
                    </div>
                    <div class="flex gap-2 z-10">
                        <a href="{{ route('admin.forms.show', $form) }}" class="btn btn-sm btn-secondary">View</a>
                        <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" onsubmit="return confirm('Delete this form?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No evaluation forms found.</p>
    @endif
</div>
<!-- Add Form Modal -->
<div id="addFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Add Evaluation Form</h3>
            <button onclick="hideAddFormModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.forms.store') }}" class="px-6 pt-6 pb-2">
            @csrf
            <div class="mb-4">
                <label class="form-label text-base">Form Name</label>
                <input type="text" name="name" class="form-input w-full text-base" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Description</label>
                <textarea name="description" class="form-textarea w-full text-base"></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="hideAddFormModal()" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green"><i class="fas fa-plus"></i> Add Form</button>
            </div>
        </form>
    </div>
</div>
<script>
function showAddFormModal() {
    document.getElementById('addFormModal').classList.remove('hidden');
}
function hideAddFormModal() {
    document.getElementById('addFormModal').classList.add('hidden');
}
</script>
@endsection
