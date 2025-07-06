@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-0">
    <div class="modal-content p-0" style="border-radius:18px;">
        <!-- Modal Header -->
        <div class="modal-header" style="border-radius:18px 18px 0 0; padding:1.5rem; background:#00471B; color:white;">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Edit Department</h3>
                <button onclick="window.location.href='{{ route('admin.departments.show', $department) }}'" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="modal-body p-0">
            <form method="POST" action="{{ route('admin.departments.update', $department) }}" style="padding:1.5rem;">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label">Department Name</label>
                    <input type="text" name="name" class="form-input w-full" value="{{ old('name', $department->name) }}" required>
                </div>
                <div class="mb-4 flex gap-4">
                    <div class="w-1/2">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-input w-full" value="{{ old('code', $department->code) }}" required>
                    </div>
                    <div class="w-1/2">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-input w-16 h-10 p-0 border-0 align-middle" value="{{ old('color', $department->color ?? '#e5e7eb') }}">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input w-full" rows="3">{{ old('description', $department->description) }}</textarea>
                </div>
                <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-gray-50 rounded-b-lg">
                    <a href="{{ route('admin.departments.show', $department) }}" class="btn btn-gray">Cancel</a>
                    <button type="submit" class="btn btn-green">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
