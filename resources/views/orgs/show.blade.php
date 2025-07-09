@extends('layouts.app')

@section('title', $org->name . ' Organization')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $org->name }} Organization</h1>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <!-- Main Grid Layout: 2 cards on top, 1 wide card below -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Org Details Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between" style="border-left: 5px solid {{ $org->department->color ?? '#e5e7eb' }};">
            <div class="flex items-center gap-4 mb-4">
                @if($org->logo)
                    <img src="{{ Storage::url($org->logo) }}" alt="{{ $org->name }} Logo" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                @else
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-xl font-bold border border-gray-200 shadow-sm">
                        <i class="fas fa-users"></i>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $org->name }}</h2>
                    <div class="text-gray-500 text-sm">Type: {{ $org->type }}</div>
                    @if($org->department)
                        <div class="text-gray-500 text-sm mt-1">Department: {{ $org->department->name }}</div>
                    @endif
                </div>
            </div>
            @if($org->term)
                <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
            @endif
        </div>
        <!-- Advisers Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Adviser</h2>
            </div>
            <div class="border-b border-gray-200 mb-2"></div>
            <div class="text-gray-500 text-sm">
                @if(isset($org->advisers) && $org->advisers->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach($org->advisers as $adviser)
                            <li class="py-2 px-1 flex items-center justify-between group">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-800">{{ $adviser->name }}</span>
                                    <span class="text-xs text-gray-500">({{ $adviser->email }})</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-400 py-2 px-1">No advisers assigned yet.</div>
                @endif
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1">
        <!-- Positions Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Positions</h2>
            </div>
            @php
                $sortedPositions = $org->positions ? $org->positions->sortBy('order') : collect();
            @endphp
            @if($sortedPositions->count())
                <ul class="mb-2">
                    @foreach($sortedPositions as $position)
                        <li class="mb-2 p-3 bg-gray-50 rounded border flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <span class="font-semibold">{{ $position->title ?? $position->name }}</span>
                                <span class="text-xs text-gray-500 ml-2">Allowed Departments:
                                    @foreach($position->departments ?? [] as $dept)
                                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded mr-1">{{ $dept->name }}</span>
                                    @endforeach
                                </span>
                                <span class="text-xs text-gray-400 ml-2">(Slots: {{ $position->slots ?? 'N/A' }}, Order: {{ $position->order ?? 'N/A' }})</span>
                            </div>
                            <div class="flex gap-2 mt-2 md:mt-0">
                                @if($position->users && $position->users->count())
                                    <span class="text-green-700">
                                        @foreach($position->users as $user)
                                            {{ $user->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </span>
                                @else
                                    <span class="text-gray-400">Vacant</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 text-sm mb-2">No positions yet.</div>
            @endif
        </div>
    </div>
</div>
@endsection
