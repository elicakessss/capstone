@extends('layouts.app')

@section('title', 'Organization Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Organization Management</h1>
            <p class="text-gray-600 mt-1">Manage councils and organizations</p>
        </div>
        <button onclick="showAddOrgModal()" class="btn btn-green" type="button">
            <i class="fas fa-plus"></i> Add Org
        </button>
    </div>

    <!-- Department List Section Header -->
    @if(isset($departments) && count($departments))
    <div class="px-6 flex items-center justify-between border-b border-gray-200 mb-2 pb-2 mt-8">
        <h3 class="text-sm font-medium text-gray-500">Departments</h3>
    </div>
    <div class="px-6 flex flex-wrap gap-3 mb-8">
        @foreach($departments as $department)
            <a href="{{ route('admin.departments.show', $department) }}"
               class="btn flex items-center gap-2 px-4 py-2 rounded-[6px] border border-gray-200 bg-white shadow-sm text-sm card-hover min-h-[42px]"
               style="border-radius: 6px; min-height: 42px; border: 1.5px solid #e5e7eb; background: #fff; box-shadow: 0 1px 2px 0 rgba(16,24,40,0.05); padding: 0 1.5rem; height: 42px;">
                <span class="inline-block w-4 h-4 rounded-full" style="background: {{ $department->color ?? '#e5e7eb' }};"></span>
                <span class="font-medium">{{ $department->name }}</span>
                <span class="text-xs text-gray-500">({{ $department->code }})</span>
            </a>
        @endforeach
    </div>
    @endif

    <!-- Tabbed Interface -->
    <div x-data="{ tab: 'templates' }" class="mt-6">
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="tab = 'orgs'"
                :class="tab === 'orgs' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-600'"
                class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                Available Organizations
            </button>
            <button @click="tab = 'templates'"
                :class="tab === 'templates' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-600'"
                class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                Org Templates
            </button>
        </div>
        <!-- Available Organizations Tab -->
        <div x-show="tab === 'orgs'">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @forelse($orgs as $org)
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
                            <div class="org-description text-sm text-gray-600 mb-1 line-clamp-2">{{ $org->description }}</div>
                            @if($org->term)
                                <span class="org-term text-xs text-green-700 bg-green-100 px-2 py-0.5 rounded">{{ $org->term }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-12">No organizations found.</div>
                @endforelse
            </div>
        </div>
        <!-- Org Templates Tab -->
        <div x-show="tab === 'templates'">
            <div class="text-gray-500 text-center py-8">Org Templates management coming soon.</div>
        </div>
    </div>
</div> <!-- End of main content space-y-6 -->

<!-- Add Org Modal -->
<div id="addOrgModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="modal-content p-0" style="border-radius:18px;">
        <!-- Modal Header -->
        <div class="modal-header" style="border-radius:18px 18px 0 0; padding:1.5rem; background:#00471B; color:white;">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Add Organization</h3>
                <button onclick="hideAddOrgModal()" class="text-white hover:text-gray-200"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="modal-body p-0">
            <form method="POST" action="{{ route('admin.orgs.store') }}" style="padding:1.5rem;">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Organization Name</label>
                    <input type="text" name="name" class="form-input w-full" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-input w-full" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Department</label>
                    <select id="orgDepartmentSelect" name="department_id" class="form-select w-full" required>
                        <option value="">Select Department</option>
                        @foreach($departments ?? [] as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                        <option value="add_new">+ Add new department…</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input w-full" rows="3"></textarea>
                </div>
                <div class="modal-footer" style="border-radius:0 0 18px 18px; background:#f9fafb; padding:1rem 1.5rem; border-top:1px solid #e5e7eb;">
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideAddOrgModal()" class="btn btn-gray">Cancel</button>
                        <button type="submit" class="btn btn-green"><i class="fas fa-plus"></i> Add Organization</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div id="addDepartmentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h2 class="text-lg font-bold text-white m-0">Add Department</h2>
            <button onclick="hideAddDepartmentModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="addDepartmentForm" method="POST" action="{{ route('admin.departments.store') }}" class="px-6 pt-6 pb-2">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Department Name</label>
                <input type="text" name="name" class="form-input w-full" required>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-700 mb-1">Code</label>
                    <input type="text" name="code" class="form-input w-full" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 mb-1">Color</label>
                    <input type="color" name="color" class="form-input w-16 h-10 p-0 border-0 align-middle" value="#00471B">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Description</label>
                <textarea name="description" class="form-input w-full" rows="2"></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-gray-50 rounded-b-lg">
                <button type="button" onclick="hideAddDepartmentModal()" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green">Add</button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddOrgModal() {
    document.getElementById('addOrgModal').classList.remove('hidden');
}
function hideAddOrgModal() {
    document.getElementById('addOrgModal').classList.add('hidden');
}
function showAddDepartmentModal() {
    document.getElementById('addDepartmentModal').classList.remove('hidden');
}
function hideAddDepartmentModal() {
    document.getElementById('addDepartmentModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    var deptSelect = document.getElementById('orgDepartmentSelect');
    if (deptSelect) {
        deptSelect.addEventListener('change', function() {
            if (this.value === 'add_new') {
                this.value = '';
                showAddDepartmentModal();
            }
        });
    }

    // AJAX submit for Add Department
    var addDeptForm = document.getElementById('addDepartmentForm');
    if (addDeptForm) {
        addDeptForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(addDeptForm);
            fetch(addDeptForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.department) {
                    // Add new department to dropdown
                    var option = document.createElement('option');
                    option.value = data.department.id;
                    option.textContent = data.department.name;
                    deptSelect.insertBefore(option, deptSelect.querySelector('option[value="add_new"]'));
                    deptSelect.value = data.department.id;
                    hideAddDepartmentModal();
                    addDeptForm.reset();
                } else {
                    alert('Failed to add department.');
                }
            })
            .catch(() => alert('Failed to add department.'));
        });
    }
});
</script>
@endsection
