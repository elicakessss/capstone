@extends('layouts.app')

@section('title', 'Create Evaluation Form')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Evaluation Form</h1>
    <form action="{{ route('admin.evaluation_forms.store') }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block font-medium">Name</label>
            <input type="text" name="name" class="form-input w-full" required value="{{ old('name') }}">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="form-textarea w-full">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
@endsection
