@extends('layouts.app')

@section('title', $department->name . ' Department')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $department->name }} Department</h1>
        </div>
        <a href="{{ route('admin.orgs.index') }}" class="btn btn-green" type="button">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <!-- Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Department Details Card -->
        <div class="bg-white rounded-lg shadow p-6 min-h-[180px] flex flex-col justify-between" style="border-left: 5px solid {{ $department->color ?? '#e5e7eb' }};">
            <div class="flex items-center gap-4 mb-4">
                <span class="inline-block w-8 h-8 rounded-full border" style="background: {{ $department->color ?? '#e5e7eb' }};"></span>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $department->name }}</h2>
                    <div class="text-gray-500 text-sm">Code: {{ $department->code }}</div>
                </div>
            </div>
            <hr class="my-4 border-t border-gray-100">
            <div class="flex gap-2 mt-0">
                <button onclick="showEditDepartmentModal()" class="btn btn-blue">Edit</button>
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
                            <td class="py-2 text-right font-normal">{{ $department->users->filter(fn($u) => in_array('adviser', $u->roles ?? []))->count() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-normal text-gray-800">Students</td>
                            <td class="py-2 text-right font-normal">{{ $department->users->filter(fn($u) => in_array('student', $u->roles ?? []))->count() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-normal text-gray-800">Admins</td>
                            <td class="py-2 text-right font-normal">{{ $department->users->filter(fn($u) => in_array('admin', $u->roles ?? []))->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Organizations Under Department Card -->
    <div class="bg-white rounded-lg shadow p-6 min-h-[220px] flex flex-col">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900 mb-1">Organizations</h2>
        </div>
        <hr class="mb-6 border-t border-gray-100">
        @php $orgs = \App\Models\Org::where('department_id', $department->id)->get(); @endphp
        @if(count($orgs))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach($orgs as $org)
                    <div class="org-card bg-white rounded-lg shadow-sm p-6 flex items-center gap-4 transition-transform duration-200 cursor-pointer min-h-[120px]"
                        style="border-left: 6px solid {{ $org->department && $org->department->color ? $org->department->color : '#e5e7eb' }}; border-top: 1.5px solid #f3f4f6; border-bottom: 1.5px solid #f3f4f6; border-right: 1.5px solid #f3f4f6; border-radius: 0.75rem;"
                        onclick="window.location='{{ route('admin.orgs.show', $org) }}'"
                        onmouseover="this.style.transform='scale(1.025)';" onmouseout="this.style.transform='none';">
                        @if($org->logo)
                            <img src="{{ asset($org->logo) }}" alt="{{ $org->name }} Logo" class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-green-100 text-green-800 text-2xl font-bold border border-gray-200 shadow-sm">
                                <i class="fas fa-users"></i>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h2 class="org-title truncate font-semibold text-lg text-gray-900 mb-1">{{ $org->name }}</h2>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="org-type text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Type: {{ $org->type }}</span>
                                @if($org->department && $org->department->color)
                                    <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $org->department->color }};"></span>
                                @endif
                            </div>
                            @if($org->term)
                                <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 text-center py-8">No organizations found for this department.</div>
        @endif
    </div>
</div> <!-- End of main content space-y-6 -->

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Edit Department</h3>
            <button onclick="hideEditDepartmentModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.departments.update', $department) }}" class="px-6 pt-6 pb-2">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="form-label text-base">Department Name</label>
                <input type="text" name="name" class="form-input w-full text-base" value="{{ old('name', $department->name) }}" required>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="w-1/2">
                    <label class="form-label text-base">Code</label>
                    <input type="text" name="code" class="form-input w-full text-base" value="{{ old('code', $department->code) }}" required>
                </div>
                <div class="w-1/2">
                    <label class="form-label text-base">Color</label>
                    <input type="color" name="color" class="form-input w-16 h-10 p-0 border-0 align-middle" value="{{ old('color', $department->color ?? '#e5e7eb') }}">
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="hideEditDepartmentModal()" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<style>
#editDepartmentModal .form-input,
#editDepartmentModal .form-select,
#editDepartmentModal .form-label {
    font-size: 14px !important;
}
</style>
<script>
function showEditDepartmentModal() {
    document.getElementById('editDepartmentModal').classList.remove('hidden');
}
function hideEditDepartmentModal() {
    document.getElementById('editDepartmentModal').classList.add('hidden');
}
</script>
@endsection
