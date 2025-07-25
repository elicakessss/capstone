@extends('layouts.app')

@section('title', 'Organization Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Organization Management</h1>
            <p class="text-gray-600 mt-1">Manage organization terms and organizations</p>
        </div>
    </div>

    <!-- Departments and Org Types Section as Toggleable Tabs -->
    <div x-data="{ sectionTab: 'departments' }" class="flex flex-col gap-6 mb-8">
        <div class="flex items-center border-b border-gray-200 mb-2">
            <button @click="sectionTab = 'departments'"
                :class="sectionTab === 'departments' ? 'border-[#00471B] text-[#00471B]' : 'border-transparent text-gray-500 hover:text-[#00471B] hover:border-[#00471B]'"
                class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                Departments
            </button>
            <button @click="sectionTab = 'orgTypes'"
                :class="sectionTab === 'orgTypes' ? 'border-[#00471B] text-[#00471B]' : 'border-transparent text-gray-500 hover:text-[#00471B] hover:border-[#00471B]'"
                class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                Organization Types
            </button>
            <div class="flex-1"></div>
            <template x-if="sectionTab === 'departments'">
                <button onclick="showAddDepartmentModal()" class="btn btn-green ml-4" type="button">
                    <i class="fas fa-plus"></i> Add Department
                </button>
            </template>
            <template x-if="sectionTab === 'orgTypes'">
                <button onclick="showAddTypeModal()" class="btn btn-green ml-4" type="button">
                    <i class="fas fa-plus"></i> Add Type
                </button>
            </template>
        </div>
        <!-- Departments Pills -->
        <div x-show="sectionTab === 'departments'" class="flex flex-wrap gap-3 min-h-[42px]">
            @forelse($departments ?? [] as $department)
                <a href="{{ route('admin.departments.show', $department) }}" class="focus:outline-none group">
                    <span class="btn flex items-center gap-2 px-4 py-2 rounded-[6px] border bg-white shadow-sm text-sm card-hover min-h-[42px] transition-transform duration-200 cursor-pointer group-hover:scale-105"
                        style="border-color: {{ $department->color ?? '#e5e7eb' }}; background: {{ $department->color ? $department->color.'20' : '#fff' }}; color: {{ $department->color ?? '#111827' }};">
                        @if($department->color)
                            <span class="inline-block w-3 h-3 rounded-full mr-2" style="background: {{ $department->color }};"></span>
                        @endif
                        <span class="font-medium">{{ $department->name }}</span>
                    </span>
                </a>
            @empty
                <span class="text-gray-400 italic">No Departments found.</span>
            @endforelse
        </div>
        <!-- Org Types Pills -->
        <div x-show="sectionTab === 'orgTypes'" class="flex flex-wrap gap-3 min-h-[42px]">
            @forelse($orgTypes ?? [] as $type)
                <a href="{{ route('admin.org_types.show', $type) }}" class="focus:outline-none">
                    <span class="btn flex items-center gap-2 px-4 py-2 rounded-[6px] border border-gray-200 bg-white shadow-sm text-sm card-hover min-h-[42px] transition-transform duration-200 cursor-pointer"
                        style="border-color: #e5e7eb;">
                        <span class="font-medium">{{ $type->name }}</span>
                    </span>
                </a>
            @empty
                <span class="text-gray-400 italic">No Org Types found.</span>
            @endforelse
        </div>
    </div>

    <!-- Tabbed Interface with Add Organization button beside tabs -->
    <div x-data="{ tab: 'orgs' }" class="mt-6">
        <div class="flex border-b border-gray-200 mb-6 items-center justify-between">
            <div class="flex">
                <button @click="tab = 'orgs'"
                    :class="tab === 'orgs' ? 'border-[#00471B] text-[#00471B]' : 'border-transparent text-gray-500 hover:text-[#00471B] hover:border-[#00471B]'"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                    Available Organizations
                </button>
                <button @click="tab = 'templates'"
                    :class="tab === 'templates' ? 'border-[#00471B] text-[#00471B]' : 'border-transparent text-gray-500 hover:text-[#00471B] hover:border-[#00471B]'"
                    class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                    Organization Terms
                </button>
            </div>
            <button onclick="showAddOrgModal()" class="btn btn-green ml-4" type="button">
                <i class="fas fa-plus"></i> Add Organization
            </button>
        </div>
        <!-- Available Organizations Tab -->
        <div x-show="tab === 'orgs'">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @forelse($orgs as $org)
                    <div class="org-card bg-white rounded-lg shadow-sm p-6 flex items-center gap-4 transition-transform duration-200 cursor-pointer min-h-[120px]"
                        style="border-left: 6px solid {{ $org->department && $org->department->color ? $org->department->color : '#00471B' }}; border-top: 1.5px solid #f3f4f6; border-bottom: 1.5px solid #f3f4f6; border-right: 1.5px solid #f3f4f6; border-radius: 0.75rem;"
                        onclick="window.location='{{ route('admin.orgs.show', $org) }}'"
                        onmouseover="this.style.transform='scale(1.025)';" onmouseout="this.style.transform='none';">
                        @if($org->logo && file_exists(public_path('storage/' . $org->logo)))
                            <img src="{{ asset('storage/' . $org->logo) }}" alt="{{ $org->name }} Logo" class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
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
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Add Organization</h3>
            <button onclick="hideAddOrgModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.orgs.store') }}" class="px-6 pt-6 pb-2" enctype="multipart/form-data">
            @csrf
            <div class="mb-4 flex flex-col items-center">
                <label class="form-label text-base mb-1">Organization Logo</label>
                <div id="addOrgLogoPreviewWrapper" class="mb-2" style="display:none;">
                    <img id="addOrgLogoPreview" src="#" alt="Logo Preview" class="w-20 h-20 rounded-full object-cover border border-gray-200 shadow-sm mx-auto" style="max-width:80px; max-height:80px;" />
                </div>
                <button type="button" onclick="document.getElementById('addOrgLogoInput').click();" class="btn btn-green flex items-center gap-2 mb-2">
                    <i class="fas fa-upload"></i> <span>Choose Logo</span>
                </button>
                <input id="addOrgLogoInput" type="file" name="logo" accept="image/*" class="hidden" onchange="previewAddOrgLogo(event)">
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Organization Name</label>
                <input type="text" name="name" class="form-input w-full text-base" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Type</label>
                <select name="type" class="form-select w-full text-base" required>
                    <option value="">Select Type</option>
                    @foreach($orgTypes ?? [] as $orgType)
                        <option value="{{ $orgType->name }}">{{ $orgType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label text-base">Department</label>
                <select id="orgDepartmentSelect" name="department_id" class="form-select w-full text-base">
                    <option value="">No Department</option>
                    @foreach($departments ?? [] as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="hideAddOrgModal()" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green"><i class="fas fa-plus"></i> Add Organization</button>
            </div>
        </form>
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
                <label class="form-label text-base">Department Name</label>
                <input type="text" name="name" class="form-input w-full text-base" required>
            </div>
            <div class="mb-4 flex gap-4">
                <div class="w-1/2">
                    <label class="form-label text-base">Code</label>
                    <input type="text" name="code" class="form-input w-full text-base" required>
                </div>
                <div class="w-1/2">
                    <label class="form-label text-base">Color</label>
                    <input type="color" name="color" class="form-input w-16 h-10 p-0 border-0 align-middle" value="#00471B">
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="hideAddDepartmentModal()" class="btn btn-gray">Cancel</button>
                <button type="submit" class="btn btn-green">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Type Modal (to be implemented) -->
<div id="addTypeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h2 class="text-lg font-bold text-white m-0">Add Organization Type</h2>
            <button onclick="hideAddTypeModal()" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="addTypeForm" method="POST" action="{{ route('admin.org_types.store') }}" class="px-6 pt-6 pb-2">
            @csrf
            <div class="mb-4">
                <label class="form-label text-base">Type Name</label>
                <input type="text" name="name" class="form-input w-full text-base" required>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="hideAddTypeModal()" class="btn btn-gray">Cancel</button>
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
function showAddTypeModal() {
    document.getElementById('addTypeModal').classList.remove('hidden');
}
function hideAddTypeModal() {
    document.getElementById('addTypeModal').classList.add('hidden');
}

function previewAddOrgLogo(event) {
    const input = event.target;
    const previewWrapper = document.getElementById('addOrgLogoPreviewWrapper');
    const preview = document.getElementById('addOrgLogoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewWrapper.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        previewWrapper.style.display = 'none';
    }
}
function resetAddOrgLogoPreview() {
    const previewWrapper = document.getElementById('addOrgLogoPreviewWrapper');
    const preview = document.getElementById('addOrgLogoPreview');
    preview.src = '#';
    previewWrapper.style.display = 'none';
    const fileInput = document.querySelector('#addOrgModal input[name="logo"]');
    if (fileInput) fileInput.value = '';
}
// Extend hideAddOrgModal to reset logo preview
const originalHideAddOrgModal = hideAddOrgModal;
hideAddOrgModal = function() {
    originalHideAddOrgModal();
    resetAddOrgLogoPreview();
}

document.addEventListener('DOMContentLoaded', function() {
    var deptSelect = document.getElementById('orgDepartmentSelect');

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
            .then(async response => {
                if (!response.ok) {
                    // Try to parse validation errors
                    let errorMsg = 'Failed to add department.';
                    try {
                        const data = await response.json();
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).flat().join('\n');
                        }
                    } catch {}
                    alert(errorMsg);
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success && data.department) {
                    // Add new department to dropdown
                    var option = document.createElement('option');
                    option.value = data.department.id;
                    option.textContent = data.department.name;
                    deptSelect.appendChild(option);
                    deptSelect.value = data.department.id;
                    hideAddDepartmentModal();
                    addDeptForm.reset();
                } else if (data && data.errors) {
                    alert(Object.values(data.errors).flat().join('\n'));
                } else if (data) {
                    alert('Failed to add department.');
                }
            })
            .catch(() => alert('Failed to add department.'));
        });
    }
});
</script>

<style>
#addOrgModal .form-input,
#addOrgModal .form-select,
#addOrgModal .form-label,
#addDepartmentModal .form-input,
#addDepartmentModal .form-select,
#addDepartmentModal .form-label,
#addTypeModal .form-input,
#addTypeModal .form-select,
#addTypeModal .form-label {
    font-size: 14px !important;
    height: auto;
}
#addOrgLogoPreviewWrapper img {
    box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04);
}
</style>
@endsection
