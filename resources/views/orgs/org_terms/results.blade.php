@extends('layouts.app')

@section('title', 'Evaluation Results')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Evaluation Results for {{ $orgTerm->org->name }}</h1>
    <table class="table-auto w-full mb-6">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">Domain</th>
                <th class="px-4 py-2 text-left">Strand</th>
                <th class="px-4 py-2 text-left">Question</th>
                <th class="px-4 py-2 text-center">Average Score</th>
            </tr>
        </thead>
        <tbody>
        @foreach($formDomains as $domain)
            @foreach($domain->strands as $strand)
                @foreach($strand->questions as $question)
                    <tr>
                        <td class="px-4 py-2">{{ $domain->name }}</td>
                        <td class="px-4 py-2">{{ $strand->name }}</td>
                        <td class="px-4 py-2">{{ $question->text }}</td>
                        <td class="px-4 py-2 text-center font-semibold">
                            {{ isset($questionAverages[$question->id]) ? number_format($questionAverages[$question->id], 2) : 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('org_terms.show', $orgTerm->id) }}" class="btn btn-green">Back to Org Term</a>
</div>
@endsection
