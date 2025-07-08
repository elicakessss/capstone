@extends('layouts.app')
@section('content')
<h1>Create Organization Instance</h1>
<form method="POST" action="{{ route('adviser.orgs.instances.store', $template->id) }}" class="max-w-lg mt-6 bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block font-semibold mb-2">Organization</label>
        <input type="text" value="{{ $template->name }}" class="form-input w-full" disabled>
    </div>
    <div class="mb-4">
        <label class="block font-semibold mb-2">Academic Year <span class="text-red-500">*</span></label>
        <input type="text" name="academic_year" class="form-input w-full" placeholder="e.g. 2025-2026" required>
    </div>
    <div class="mb-4">
        <label class="block font-semibold mb-2">Positions (predefined by admin)</label>
        <ul class="list-disc ml-6">
            @foreach($template->positions as $position)
                <li>{{ $position->name }}</li>
            @endforeach
        </ul>
    </div>
    <button type="submit" class="btn btn-green">Create Organization Instance</button>
</form>
@endsection
