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
    <div class="space-y-8">
        @if($form->domains && $form->domains->count())
            @foreach($form->domains as $domain)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-1">{{ $domain->name }}</h3>
                    <p class="text-gray-500 mb-4">{{ $domain->description }}</p>
                    @if($domain->strands && $domain->strands->count())
                        <div class="space-y-6">
                        @foreach($domain->strands as $strand)
                            <div class="bg-gray-50 rounded shadow-sm p-4">
                                <h4 class="text-base font-semibold text-green-800 mb-2">{{ $strand->name }}</h4>
                                @if($strand->questions && $strand->questions->count())
                                    <div class="space-y-6">
                                    @foreach($strand->questions as $question)
                                        <div class="mb-6">
                                            <div class="font-medium text-gray-900 mb-1">{{ $question->text }}</div>
                                            <div class="flex flex-wrap gap-2 text-xs mb-2">
                                                @foreach($question->evaluatorTypes as $type)
                                                    <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-800 font-semibold">{{ $type->evaluator_type }}</span>
                                                @endforeach
                                            </div>
                                            <ul class="space-y-3 mt-2">
                                                @foreach($question->likertScales->sortBy('order') as $option)
                                                    <li class="flex items-center gap-3">
                                                        <input type="radio" disabled class="form-radio text-green-600" />
                                                        <span class="font-medium">{{ $option->label }}</span>
                                                        <span class="text-xs text-gray-500">({{ $option->score }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-400 text-xs">No questions yet.</p>
                                @endif
                            </div>
                        @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-xs ml-4">No strands yet.</p>
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No domains added yet.</p>
        @endif
    </div>
</div>
@endsection
