@extends('layouts.app')

@section('title', 'Evaluate Student')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Evaluation Form for {{ $student->name }}</h1>
    @if(!$canEvaluate)
        <div class="alert alert-warning mb-4">Evaluation is not currently allowed for this org term.</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('org_terms.submitEvaluation', [$orgTerm, $student]) }}">
        @csrf
        {{-- Render evaluation form fields here --}}
        @foreach($formDomains as $domain)
            <div class="mb-6">
                <div class="flex items-center gap-4 mb-2">
                    <h2 class="text-lg font-semibold text-green-900 mb-0">{{ $domain->name }}</h2>
                    <span class="text-xs text-gray-400">Domain</span>
                </div>
                @foreach($domain->strands as $strand)
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-medium text-gray-800 mb-0">{{ $strand->name }}</h3>
                            <span class="text-xs text-gray-400">Strand</span>
                        </div>
                        @foreach($strand->questions as $question)
                            <div class="mb-2">
                                <label class="block text-gray-700 font-medium">{{ $question->text }}</label>
                                <select name="responses[{{ $question->id }}]" class="form-select mt-1 w-full" required aria-label="Likert scale for {{ $question->text }}">
                                    <option value="">Select rating</option>
                                    @foreach($question->likertScales as $option)
                                        <option value="{{ $option->score }}" @if(isset($existingResponses[$question->id]) && $existingResponses[$question->id] == $option->score) selected @endif>{{ $option->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="mb-6 mt-4">
            <div class="bg-gray-50 border border-gray-200 rounded p-3 text-xs text-gray-600">
                <strong>Likert Scale Legend:</strong>
                <ul class="list-disc ml-6 mt-1">
                    @php
                        $legend = collect($formDomains)->flatMap(fn($d) => $d->strands)->flatMap(fn($s) => $s->questions)->flatMap(fn($q) => $q->likertScales)->unique('score')->sortBy('score');
                    @endphp
                    @foreach($legend as $option)
                        <li><strong>{{ $option->score }}</strong>: {{ $option->label }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('org_terms.show', $orgTerm) }}" class="btn btn-green mt-4"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </form>
</div>
@endsection
