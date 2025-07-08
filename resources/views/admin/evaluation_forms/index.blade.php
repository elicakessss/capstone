@extends('layouts.app')

@section('title', 'Evaluation Forms')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Evaluation Forms</h1>
        <a href="{{ route('admin.evaluation_forms.create') }}" class="btn btn-primary">Create New Form</a>
    </div>
    <div class="bg-white rounded shadow p-4">
        @if($forms->count())
            <ul class="divide-y divide-gray-200">
                @foreach($forms as $form)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <span class="font-semibold">{{ $form->name }}</span>
                            <span class="text-gray-500 text-sm ml-2">{{ $form->description }}</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.evaluation_forms.edit', $form) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.evaluation_forms.destroy', $form) }}" method="POST" onsubmit="return confirm('Delete this form?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No evaluation forms found.</p>
        @endif
    </div>
</div>
@endsection
