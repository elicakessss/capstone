@extends('layouts.app')

@section('title', 'Edit Org Type')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-0">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Edit Org Type</h3>
            <button onclick="window.location.href='{{ route('admin.org_types.show', $type) }}'" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <form method="POST" action="{{ route('admin.org_types.update', $type) }}" class="px-6 pt-6 pb-2">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="form-label text-base">Type Name</label>
                <input type="text" name="name" class="form-input w-full text-base" value="{{ old('name', $type->name) }}" required>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <a href="{{ route('admin.org_types.show', $type) }}" class="btn btn-gray">Cancel</a>
                <button type="submit" class="btn btn-green">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
