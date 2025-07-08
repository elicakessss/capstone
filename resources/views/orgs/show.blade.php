@extends('layouts.app')

@section('title', $org->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="flex items-center gap-4 mb-6">
        @if($org->logo)
            <img src="{{ asset($org->logo) }}" alt="{{ $org->name }} Logo" class="w-20 h-20 rounded-full object-cover border border-gray-200 shadow-sm">
        @else
            <div class="w-20 h-20 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-3xl font-bold border border-gray-200 shadow-sm">
                <i class="fas fa-users"></i>
            </div>
        @endif
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $org->name }}</h1>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Type: {{ $org->type }}</span>
                @if($org->department && $org->department->color)
                    <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $org->department->color }};"></span>
                @endif
            </div>
            @if($org->term)
                <span class="text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
            @endif
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-wrap gap-4 mb-4">
            <div>
                <span class="font-medium text-gray-600">Department:</span>
                {{ $org->department->name ?? 'N/A' }}
            </div>
            <div>
                <span class="font-medium text-gray-600">Academic Year:</span>
                {{ $org->term ?? ($org->academic_year ?? 'N/A') }}
            </div>
        </div>
        <div class="mb-4">
            <span class="font-medium text-gray-600">Advisers:</span>
            @if($org->advisers && $org->advisers->count())
                <ul class="list-disc ml-6">
                    @foreach($org->advisers as $adviser)
                        <li>{{ $adviser->name }} ({{ $adviser->email }})</li>
                    @endforeach
                </ul>
            @else
                <span class="text-gray-500">None assigned</span>
            @endif
        </div>
        <div>
            <span class="font-medium text-gray-600">Created By:</span>
            {{ $org->creator->name ?? 'N/A' }}
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold mb-2">Members & Positions</h2>
        @if($org->positions && $org->positions->count())
            <ul class="divide-y divide-gray-200">
                @foreach($org->positions as $position)
                    <li class="py-2 flex justify-between items-center">
                        <span>{{ $position->name }}</span>
                        @if($position->users && $position->users->count())
                            <span class="text-green-700">
                                @foreach($position->users as $user)
                                    {{ $user->name }}@if(!$loop->last), @endif
                                @endforeach
                            </span>
                        @else
                            <span class="text-gray-400">Vacant</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No positions defined for this organization.</p>
        @endif
    </div>
</div>
@endsection
