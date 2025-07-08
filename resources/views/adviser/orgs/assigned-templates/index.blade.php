@extends('layouts.app')
@section('content')
<h1>Assigned Organization Templates</h1>
<div class="mt-6">
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Organization</th>
                <th class="px-4 py-2 border">Type</th>
                <th class="px-4 py-2 border">Department</th>
                <th class="px-4 py-2 border">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($assignedTemplates as $template)
            <tr>
                <td class="px-4 py-2 border">{{ $template->name }}</td>
                <td class="px-4 py-2 border">{{ $template->type }}</td>
                <td class="px-4 py-2 border">{{ $template->department->name ?? '-' }}</td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('adviser.orgs.instances.create', $template->id) }}" class="btn btn-green">Create Instance</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($assignedTemplates->isEmpty())
        <p class="mt-4 text-gray-500">No assigned organization templates.</p>
    @endif
</div>
@endsection
