@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-0">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Edit Department</h3>
            <button onclick="window.location.href='{{ route('admin.departments.show', $department) }}'" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form method="POST" action="{{ route('admin.departments.update', $department) }}" class="px-6 pt-6 pb-2">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="form-label text-base">Department Name</label>
                <input type="text" name="name" class="form-input w-full text-base" value="{{ old('name', $department->name) }}" required>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="w-1/2">
                    <label class="form-label text-base">Code</label>
                    <input type="text" name="code" class="form-input w-full text-base" value="{{ old('code', $department->code) }}" required>
                </div>
                <div class="w-1/2">
                    <label class="form-label text-base">Color</label>
                    <input type="color" name="color" class="form-input w-16 h-10 p-0 border-0 align-middle" value="{{ old('color', $department->color ?? '#e5e7eb') }}">
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <a href="{{ route('admin.departments.show', $department) }}" class="btn btn-gray">Cancel</a>
                <button type="submit" class="btn btn-green">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
