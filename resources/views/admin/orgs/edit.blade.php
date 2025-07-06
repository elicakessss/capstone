@extends('layouts.app')

@section('title', 'Edit Organization')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-0">
    <div class="modal-content p-0" style="border-radius:18px;">
        <!-- Modal Header -->
        <div class="modal-header" style="border-radius:18px 18px 0 0; padding:1.5rem; background:#00471B; color:white;">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Edit Organization</h3>
                <button onclick="window.location.href='{{ route('admin.orgs.show', $org) }}'" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="modal-body p-0">
            <form method="POST" action="{{ route('admin.orgs.update', $org) }}" style="padding:1.5rem;">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label">Organization Name</label>
                    <input type="text" name="name" class="form-input w-full" value="{{ old('name', $org->name) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-input w-full" value="{{ old('type', $org->type) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select w-full" required>
                        <option value="">Select Department</option>
                        @foreach($departments ?? [] as $department)
                            <option value="{{ $department->id }}" {{ (old('department_id', $org->department_id) == $department->id) ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input w-full" rows="3">{{ old('description', $org->description) }}</textarea>
                </div>
                <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-gray-50 rounded-b-lg">
                    <a href="{{ route('admin.orgs.show', $org) }}" class="btn btn-gray">Cancel</a>
                    <button type="submit" class="btn btn-green">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
