@extends('layouts.app')

@section('title', $department->name . ' Department')

@section('content')
<div class="space-y-6">
    <!-- Page Header (match orgs index spacing) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 px-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $department->name }} Department</h1>
        </div>
        <a href="{{ route('admin.orgs.index') }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <!-- Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 px-6">
        <!-- Department Details Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between" style="border-left: 5px solid {{ $department->color ?? '#e5e7eb' }};">
            <div class="flex items-center gap-4 mb-4">
                <span class="inline-block w-8 h-8 rounded-full border" style="background: {{ $department->color ?? '#e5e7eb' }};"></span>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $department->name }}</h2>
                    <div class="text-gray-500 text-sm">Code: {{ $department->code }}</div>
                </div>
            </div>
            <div class="mb-2">
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <div class="text-gray-800">{{ $department->description ?? '—' }}</div>
            </div>
            <hr class="my-4 border-t border-gray-100">
            <div class="flex gap-2 mt-0">
                <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-blue">Edit</a>
                <form method="POST" action="{{ route('admin.departments.destroy', $department) }}" onsubmit="return confirm('Are you sure you want to delete this department?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-red">Delete</button>
                </form>
            </div>
        </div>
        <!-- Users Count Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-900 mb-1">User Count</h2>
                <div class="text-gray-500 text-sm">Breakdown of users by role in this department</div>
            </div>
            <div class="mb-2">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-700 text-sm font-medium border-b border-gray-100">
                            <th class="py-2 font-medium">Role</th>
                            <th class="py-2 text-right font-medium">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 font-normal text-gray-800">Advisers</td>
                            <td class="py-2 text-right font-normal">{{ $department->users()->where('role', 'adviser')->count() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-normal text-gray-800">Students</td>
                            <td class="py-2 text-right font-normal">{{ $department->users()->where('role', 'student')->count() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-normal text-gray-800">Admins</td>
                            <td class="py-2 text-right font-normal">{{ $department->users()->where('role', 'admin')->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Organizations Under Department Card -->
    <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col mx-6">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900 mb-1">Organizations</h2>
        </div>
        <hr class="mb-6 border-t border-gray-100">
        @php $orgs = $department->orgs ?? []; @endphp
        @if(count($orgs))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($orgs as $org)
                    <div class="org-card" onclick="window.location='{{ route('orgs.show', $org) }}'">
                        <div class="org-title">{{ $org->name }}</div>
                        <div class="org-type">Type: {{ $org->type }}</div>
                        <div class="org-description">{{ $org->description }}</div>
                        <span class="org-term">{{ $org->term }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center py-8">No organizations found for this department.</div>
        @endif
    </div>
</div>
@endsection
