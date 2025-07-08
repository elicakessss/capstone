@extends('layouts.app')

@section('title', 'Edit Evaluation Form')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Evaluation Form</h1>
    <form action="{{ route('admin.evaluation_forms.update', $evaluation_form) }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-medium">Name</label>
            <input type="text" name="name" class="form-input w-full" required value="{{ old('name', $evaluation_form->name) }}">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="form-textarea w-full">{{ old('description', $evaluation_form->description) }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2">Form Structure</h2>
        <p class="text-gray-500">(Domains, strands, questions, Likert scales, and evaluator types management UI will go here.)</p>
    </div>
</div>
@endsection
