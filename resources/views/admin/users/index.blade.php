@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
            <p class="text-gray-600 mt-1">Manage system users, roles, and permissions</p>
        </div>
        <!-- Search and Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <!-- Search Bar and Filter -->
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.users.index') }}" class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="search-input pl-10 pr-4 py-2 w-full sm:w-64 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent h-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                </form>

                <!-- Role Filter -->
                <select onchange="location.href=this.value" class="filter-select">
                    <option value="{{ route('admin.users.index') }}">All Roles</option>
                    <option value="{{ route('admin.users.index', ['role' => 'student']) }}" {{ request('role') === 'student' ? 'selected' : '' }}>Students</option>
                    <option value="{{ route('admin.users.index', ['role' => 'adviser']) }}" {{ request('role') === 'adviser' ? 'selected' : '' }}>Advisers</option>
                    <option value="{{ route('admin.users.index', ['role' => 'admin']) }}" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrators</option>
                </select>
            </div>
            <button onclick="showAddUserModal()" class="btn btn-green" type="button">
                <i class="fas fa-user-plus"></i> Add New User
            </button>
        </div>
    </div>

    <!-- Tabbed Interface -->
    <div x-data="{ tab: '{{ request('tab', 'accounts') }}' }" class="mt-6">
        <div class="flex border-b border-gray-200 mb-6">
            <button @click="tab = 'accounts'" :class="tab === 'accounts' ? 'border-[#00471B] text-[#00471B]' : 'border-transparent text-gray-500 hover:text-[#00471B] hover:border-[#00471B]'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                Accounts
            </button>
            <button @click="tab = 'requests'" :class="tab === 'requests' ? 'border-[#00471B] text-[#00471B]' : 'border-transparent text-gray-500 hover:text-[#00471B] hover:border-[#00471B]'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                Requests
            </button>
        </div>

        <!-- Accounts Tab -->
        <div x-show="tab === 'accounts'">
            <div class="bg-white rounded-lg shadow overflow-hidden data-table">
                <!-- Section header: white background -->
                <div class="px-6 py-4 border-b border-gray-200 bg-white">
                    <h3 class="text-lg font-medium text-gray-900">User Accounts</h3>
                </div>
                <!-- Table header: dark white background -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 data-table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Joined at</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="cursor-pointer hover:bg-gray-100 transition @if($user->id === auth()->id()) user-row @endif" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                    <!-- Name + ID Number -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">
                                                    {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1) . substr($user->last_name ?? $user->name, 1, 1)) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->id_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Role(s) -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-red-100 text-red-800',
                                                'adviser' => 'bg-blue-100 text-blue-800',
                                                'student' => 'bg-green-100 text-green-800'
                                            ];
                                            $roles = $user->roles ?? [];
                                            if (empty($roles) && $user->role) {
                                                $roles = [$user->role];
                                            }
                                        @endphp
                                        @foreach($roles as $role)
                                            @php
                                                $colorClass = $roleColors[$role] ?? 'bg-gray-100 text-gray-800';
                                                $roleDisplay = $role === 'admin' ? 'Administrator' : ucfirst($role);
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }} mr-1">
                                                {{ $roleDisplay }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <!-- Department -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->department->name ?? 'N/A' }}
                                    </td>
                                    <!-- Email -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->email }}
                                    </td>
                                    <!-- Joined at -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('M j, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                            <p class="text-sm text-gray-600">There are no users in the system yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                    <div class="px-6 py-4 bg-white border-t border-gray-200">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Requests Tab -->
        <div x-show="tab === 'requests'">
            <div class="bg-white rounded-lg shadow overflow-hidden data-table">
                <div class="px-6 py-4 border-b border-gray-200 bg-white">
                    <h3 class="text-lg font-medium text-gray-900">Registration Requests</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 data-table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($requests as $request)
                                <tr class="cursor-pointer hover:bg-gray-100 transition">
                                    <!-- Name -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">
                                                    {{ strtoupper(substr($request->first_name, 0, 1) . substr($request->last_name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $request->full_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Role -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-red-100 text-red-800',
                                                'adviser' => 'bg-blue-100 text-blue-800',
                                                'student' => 'bg-green-100 text-green-800'
                                            ];
                                            $colorClass = $roleColors[$request->role] ?? 'bg-gray-100 text-gray-800';
                                            $roleDisplay = $request->role === 'admin' ? 'Administrator' : ucfirst($request->role);
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                            {{ $roleDisplay }}
                                        </span>
                                    </td>
                                    <!-- Department -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->department->name ?? 'N/A' }}</td>
                                    <!-- Email -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $request->email }}</td>
                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @php
                                            $actions = [
                                                [
                                                    'type' => 'form',
                                                    'form_url' => route('admin.user-requests.approve', $request),
                                                    'method' => 'POST',
                                                    'icon' => 'fas fa-check',
                                                    'variant' => 'approve',
                                                    'tooltip' => 'Approve Request',
                                                ],
                                                [
                                                    'type' => 'form',
                                                    'form_url' => route('admin.user-requests.reject', $request),
                                                    'method' => 'POST',
                                                    'icon' => 'fas fa-times',
                                                    'variant' => 'reject',
                                                    'tooltip' => 'Reject Request',
                                                ],
                                            ];
                                        @endphp
                                        <x-table-actions :actions="$actions" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No registration requests</h3>
                                            <p class="text-sm text-gray-600">There are no registration requests to review at this time.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Add User</h3>
            <button onclick="closeModal('addUserModal')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none"><i class="fas fa-times"></i></button>
        </div>
        <!-- Modal Body -->
        <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" class="px-6 pt-6 pb-2">
            @csrf
            <div class="form-row flex gap-4 mb-4">
                <div class="form-col flex-1">
                    <label for="first_name" class="form-label">First Name</label>
                    <input id="first_name" type="text" name="first_name" class="form-input" placeholder="Enter first name" required>
                    <p class="form-error hidden" id="first_name_error"></p>
                </div>
                <div class="form-col flex-1">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input id="last_name" type="text" name="last_name" class="form-input" placeholder="Enter last name" required>
                    <p class="form-error hidden" id="last_name_error"></p>
                </div>
            </div>
            <div class="form-row flex gap-4 mb-4">
                <div class="form-col flex-1">
                    <label for="id_number" class="form-label">ID Number</label>
                    <input id="id_number" type="text" name="id_number" class="form-input" placeholder="Enter ID number" required>
                    <p class="form-error hidden" id="id_number_error"></p>
                </div>
                <div class="form-col flex-1">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" class="form-input" placeholder="Enter email address" required>
                    <p class="form-error hidden" id="email_error"></p>
                </div>
            </div>
            <div class="mb-4">
                <label for="department_id" class="form-label">Department</label>
                <select id="department_id" name="department_id" class="form-select" required>
                    <option value="">Select Department</option>
                    @foreach($departments ?? [] as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <p class="form-error hidden" id="department_id_error"></p>
            </div>
            <div class="mb-4">
                <label class="form-label">Roles</label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="roles[]" value="student">
                        <span class="ml-2">Student</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="roles[]" value="adviser">
                        <span class="ml-2">Adviser</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="roles[]" value="admin">
                        <span class="ml-2">Administrator</span>
                    </label>
                </div>
                <p class="form-error hidden" id="roles_error"></p>
            </div>
            <div class="form-row flex gap-4 mb-4">
                <div class="form-col flex-1">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-input" placeholder="Enter password (minimum 8 characters)" required minlength="8">
                    <p class="form-error hidden" id="password_error"></p>
                </div>
                <div class="form-col flex-1">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Confirm password" required minlength="8">
                    <p class="form-error hidden" id="password_confirmation_error"></p>
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="closeModal('addUserModal')" class="btn btn-gray">Cancel</button>
                <button type="submit" onclick="submitAddUserForm(event)" class="btn btn-green">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-green-900">
            <h3 class="text-lg font-semibold text-white">Approve User Request</h3>
            <button onclick="closeModal('approveModal')" class="text-white hover:text-gray-200 bg-green-800 rounded px-2 py-1 focus:outline-none"><i class="fas fa-times"></i></button>
        </div>
        <form id="approveRequestForm" method="POST" class="px-6 pt-6 pb-2">
            @csrf
            <input type="hidden" name="request_id" id="approve_request_id">
            <div class="mb-4">
                <label for="student_name" class="form-label">Student Name</label>
                <input id="student_name" type="text" name="student_name" class="form-input" required readonly>
            </div>
            <div class="mb-4">
                <label for="student_email" class="form-label">Student Email</label>
                <input id="student_email" type="email" name="student_email" class="form-input" required readonly>
            </div>
            <div class="mb-4">
                <label for="student_department" class="form-label">Department</label>
                <input id="student_department" type="text" name="student_department" class="form-input" required readonly>
            </div>
            <div class="mb-4">
                <label for="student_id_number" class="form-label">ID Number</label>
                <input id="student_id_number" type="text" name="student_id_number" class="form-input" required readonly>
            </div>
            <div class="mb-4">
                <label for="student_role" class="form-label">Role</label>
                <input id="student_role" type="text" name="student_role" class="form-input" required readonly>
            </div>
            <div class="mb-4">
                <label for="approval_notes" class="form-label">Approval Notes</label>
                <textarea id="approval_notes" name="approval_notes" class="form-textarea" placeholder="Enter any notes for the student (optional)"></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="closeModal('approveModal')" class="btn btn-gray">Cancel</button>
                <x-button onclick="submitApproveRequestForm(event)" variant="primary" icon="fas fa-check">Approve Request</x-button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-0 relative">
        <div class="flex items-center justify-between px-6 py-4 border-b rounded-t-lg bg-red-900">
            <h3 class="text-lg font-semibold text-white">Reject User Request</h3>
            <button onclick="closeModal('rejectModal')" class="text-white hover:text-gray-200 bg-red-800 rounded px-2 py-1 focus:outline-none"><i class="fas fa-times"></i></button>
        </div>
        <form id="rejectRequestForm" method="POST" class="px-6 pt-6 pb-2">
            @csrf
            <input type="hidden" name="request_id" id="reject_request_id">
            <div class="mb-4">
                <label for="reject_reason" class="form-label">Reason for Rejection</label>
                <textarea id="reject_reason" name="reject_reason" class="form-textarea" required></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 pb-2 bg-white rounded-b-lg">
                <button type="button" onclick="closeModal('rejectModal')" class="btn btn-gray">Cancel</button>
                <x-button onclick="submitRejectRequestForm(event)" variant="danger" icon="fas fa-times">Reject Request</x-button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Make modal form content flush (no extra padding on modal-content, only on form) */
    #addUserModal .modal-content {
        padding: 0 !important;
    }
    #addUserModal .modal-body {
        padding: 0 !important;
    }
    #addUserModal form {
        padding: 1.5rem !important;
    }
    /* Match form input font size to app (14px) */
    #addUserModal .form-input,
    #addUserModal .form-select {
        font-size: 14px !important;
    }
    #addUserModal .form-label {
        font-size: 14px !important;
    }

    /* Remove border and box-shadow on row hover in registration requests table */
    [x-show="tab === 'requests'"] .data-table tr:hover {
        border: none !important;
        box-shadow: none !important;
    }
    /* Remove roundness from table header in registration requests table */
    [x-show="tab === 'requests'"] .data-table thead tr th:first-child {
        border-top-left-radius: 0 !important;
    }
    [x-show="tab === 'requests'"] .data-table thead tr th:last-child {
        border-top-right-radius: 0 !important;
    }
    [x-show="tab === 'requests'"] .data-table thead tr th {
        border-radius: 0 !important;
    }

    /* Remove roundness from table header in user accounts table */
    [x-show="tab === 'accounts'"] .data-table thead tr th:first-child {
        border-top-left-radius: 0 !important;
    }
    [x-show="tab === 'accounts'"] .data-table thead tr th:last-child {
        border-top-right-radius: 0 !important;
    }
    [x-show="tab === 'accounts'"] .data-table thead tr th {
        border-radius: 0 !important;
    }

    .search-input,
    .filter-select {
        font-size: 14px !important;
    }
</style>

<script>
function showAddUserModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
    document.getElementById('addUserModal').classList.add('show');
    setupRealTimeValidation();
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('show');
}

function submitAddUserForm(event) {
    console.log('submitAddUserForm called'); // DEBUG
    if (event) event.preventDefault();
    const form = document.getElementById('addUserForm');
    clearFormErrors();

    if (!validateForm(form)) {
        showToast('Please fill in all required fields.', 'error');
        return;
    }

    const formData = new FormData(form);
    let submitBtn = event ? event.target : document.querySelector('#addUserModal .modal-footer .x-button, #addUserModal .modal-footer button');
    const originalText = submitBtn ? submitBtn.innerHTML : '';
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding User...';
        submitBtn.disabled = true;
    }

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(async response => {
        let data;
        try {
            data = await response.json();
        } catch {
            throw new Error('Invalid JSON response');
        }
        if (response.status === 422 && data.errors) {
            showFormErrors(data.errors);
            showToast('Please fix the errors below and try again.', 'error');
            return;
        }
        if (!response.ok) {
            throw new Error(data.message || 'An error occurred');
        }
        if (data.success && data.user) {
            closeModal('addUserModal');
            resetForm('addUserForm');
            showToast('User added successfully!', 'success');
            insertUserRow(data.user, data.show_url, data.current_user_id);
        } else {
            showToast(data.message || 'An error occurred while adding the user.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while adding the user.', 'error');
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
}

function insertUserRow(user, showUrl, currentUserId) {
    const tbody = document.querySelector('.data-table tbody');
    const noUsersRow = tbody.querySelector('tr td[colspan]');
    if (noUsersRow) noUsersRow.parentElement.remove();

    // Use roles array for new users, fallback to role string for old users
    let roles = user.roles && user.roles.length ? user.roles : (user.role ? [user.role] : []);
    let role = roles.length ? roles[0] : '';
    let colorClass = 'bg-gray-100 text-gray-800';
    let roleDisplay = role === 'admin' ? 'Administrator' : (role ? role.charAt(0).toUpperCase() + role.slice(1) : '');
    if (role === 'admin') colorClass = 'bg-red-100 text-red-800';
    else if (role === 'adviser') colorClass = 'bg-blue-100 text-blue-800';
    else if (role === 'student') colorClass = 'bg-green-100 text-green-800';

    let initials = '';
    if (user.first_name && user.last_name) {
        initials = (user.first_name[0] || '').toUpperCase() + (user.last_name[0] || '').toUpperCase();
    } else if (user.name) {
        initials = (user.name[0] || '').toUpperCase();
    }
    let departmentName = user.department && user.department.name ? user.department.name : 'N/A';
    let dateCreated = user.created_at ? user.created_at.substring(0, 10) : '';
    let highlight = user.id === currentUserId ? ' style="background-color: #f5f6fa;"' : '';

    const newRow = document.createElement('tr');
    newRow.className = 'cursor-pointer hover:bg-gray-100 transition';
    newRow.setAttribute('onclick', `window.location='${showUrl || '#'}'`);
    if (highlight) newRow.setAttribute('style', 'background-color: #f5f6fa;');
    newRow.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-green-600">${initials}</span>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">${user.name || (user.first_name + ' ' + user.last_name)}</div>
                    <div class="text-sm text-gray-500">${user.email}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${colorClass}">${roleDisplay}</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${departmentName}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.email}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${dateCreated}</td>
    `;
    if (tbody.firstChild) {
        tbody.insertBefore(newRow, tbody.firstChild);
    } else {
        tbody.appendChild(newRow);
    }
}

function showFormErrors(errors) {
    Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(field + '_error');
        const inputElement = document.querySelector(`#addUserForm [name="${field}"]`);

        if (errorElement) {
            let message = errors[field][0];
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            errorElement.classList.add('mt-1', 'text-sm', 'text-red-600');
        }

        if (inputElement) {
            inputElement.classList.remove('bg-gray-100', 'focus:bg-white');
            inputElement.classList.add('bg-red-50', 'focus:bg-red-50');
        }
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = [
        'first_name',
        'last_name',
        'id_number',
        'email',
        'department_id',
        'password',
        'password_confirmation'
    ];
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        const errorElement = document.getElementById(fieldName + '_error');
        if (!field || !field.value.trim()) {
            isValid = false;
            if (errorElement) {
                errorElement.textContent = `${getFieldLabel(fieldName)} is required.`;
                errorElement.classList.remove('hidden');
                errorElement.classList.add('mt-1', 'text-sm', 'text-red-600');
            }
            if (field) {
                field.classList.remove('bg-gray-100', 'focus:bg-white');
                field.classList.add('bg-red-50', 'focus:bg-red-50');
            }
        }
    });
    // Roles[] checkboxes validation
    const roles = form.querySelectorAll('input[name="roles[]"]:checked');
    const rolesError = document.getElementById('roles_error');
    if (!roles.length) {
        isValid = false;
        if (rolesError) {
            rolesError.textContent = 'At least one role must be selected.';
            rolesError.classList.remove('hidden');
            rolesError.classList.add('mt-1', 'text-sm', 'text-red-600');
        }
    } else if (rolesError) {
        rolesError.textContent = '';
        rolesError.classList.add('hidden');
    }
    // Email format validation
    const email = form.querySelector('[name="email"]');
    if (email && email.value && !/^\S+@\S+\.\S+$/.test(email.value)) {
        isValid = false;
        const errorElement = document.getElementById('email_error');
        if (errorElement) {
            errorElement.textContent = 'The email field must be a valid email address.';
            errorElement.classList.remove('hidden');
            errorElement.classList.add('mt-1', 'text-sm', 'text-red-600');
        }
        email.classList.remove('bg-gray-100', 'focus:bg-white');
        email.classList.add('bg-red-50', 'focus:bg-red-50');
    }
    // Password length
    const password = form.querySelector('[name="password"]');
    if (password && password.value && password.value.length < 8) {
        isValid = false;
        const errorElement = document.getElementById('password_error');
        if (errorElement) {
            errorElement.textContent = 'The password must be at least 8 characters.';
            errorElement.classList.remove('hidden');
            errorElement.classList.add('mt-1', 'text-sm', 'text-red-600');
        }
        password.classList.remove('bg-gray-100', 'focus:bg-white');
        password.classList.add('bg-red-50', 'focus:bg-red-50');
    }
    // Password confirmation
    const confirmPassword = form.querySelector('[name="password_confirmation"]');
    if (password && confirmPassword && password.value && confirmPassword.value && password.value !== confirmPassword.value) {
        isValid = false;
        const errorElement = document.getElementById('password_confirmation_error');
        if (errorElement) {
            errorElement.textContent = 'The password confirmation does not match.';
            errorElement.classList.remove('hidden');
            errorElement.classList.add('mt-1', 'text-sm', 'text-red-600');
        }
        confirmPassword.classList.remove('bg-gray-100', 'focus:bg-white');
        confirmPassword.classList.add('bg-red-50', 'focus:bg-red-50');
    }
    return isValid;
}

function getFieldLabel(fieldName) {
    var labels = {
        'first_name': 'First Name',
        'last_name': 'Last Name',
        'id_number': 'ID Number',
        'email': 'Email Address',
        'department_id': 'Department',
        'role': 'Role',
        'password': 'Password',
        'password_confirmation': 'Confirm Password'
    };
    return labels[fieldName] || fieldName;
}

function clearFormErrors() {
    const form = document.getElementById('addUserForm');
    if (!form) return;
    const errorElements = form.querySelectorAll('.form-error');
    errorElements.forEach(el => {
        el.textContent = '';
        el.classList.add('hidden');
    });
    const inputs = form.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.classList.remove('bg-red-50', 'focus:bg-red-50');
        input.classList.add('bg-gray-100', 'focus:bg-white');
    });
}

function resetForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        clearFormErrors();
    }
}

// Add real-time validation
function setupRealTimeValidation() {
    const form = document.getElementById('addUserForm');
    if (!form) return;

    // Add event listeners for all required fields
    const requiredFields = ['first_name', 'last_name', 'id_number', 'email', 'department_id', 'password', 'password_confirmation'];

    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('input', () => validateField(fieldName));
            field.addEventListener('change', () => validateField(fieldName));
            field.addEventListener('blur', () => validateField(fieldName));
        }
    });
    // Real-time validation for roles[] checkboxes
    const roleCheckboxes = form.querySelectorAll('input[name="roles[]"]');
    roleCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const checked = form.querySelectorAll('input[name="roles[]"]:checked').length;
            const rolesError = document.getElementById('roles_error');
            if (!checked) {
                rolesError.textContent = 'At least one role must be selected.';
                rolesError.classList.remove('hidden');
                rolesError.classList.add('mt-1', 'text-sm', 'text-red-600');
            } else {
                rolesError.textContent = '';
                rolesError.classList.add('hidden');
            }
        });
    });
}

function validateField(fieldName) {
    const form = document.getElementById('addUserForm');
    const field = form.querySelector(`[name="${fieldName}"]`);
    const errorElement = document.getElementById(fieldName + '_error');

    if (!field || !errorElement) return;

    let isValid = true;
    let errorMessage = '';

    // Check if field is empty
    if (!field.value.trim()) {
        isValid = false;
        errorMessage = `${getFieldLabel(fieldName)} is required.`;
    } else {
        // Specific validation based on field type
        switch(fieldName) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }
                break;

            case 'password':
                if (field.value.length < 8) {
                    isValid = false;
                    errorMessage = 'Password must be at least 8 characters long.';
                }
                break;

            case 'password_confirmation':
                const passwordField = form.querySelector('[name="password"]');
                if (passwordField && field.value !== passwordField.value) {
                    isValid = false;
                    errorMessage = 'Password confirmation does not match.';
                }
                break;
        }
    }

    // Update field appearance and error message
    if (isValid) {
        field.classList.remove('bg-red-50', 'focus:bg-red-50');
        field.classList.add('bg-gray-100', 'focus:bg-white');
        errorElement.textContent = '';
        errorElement.classList.add('hidden');
    } else {
        field.classList.remove('bg-gray-100', 'focus:bg-white');
        field.classList.add('bg-red-50', 'focus:bg-red-50');
        errorElement.textContent = errorMessage;
        errorElement.classList.remove('hidden');
    }

    return isValid;
}

function openApproveModal(requestId, studentName) {
    const modal = document.getElementById('approveModal');
    const requestIdInput = document.getElementById('approve_request_id');
    const studentNameInput = document.getElementById('student_name');
    const studentEmailInput = document.getElementById('student_email');
    const studentDepartmentInput = document.getElementById('student_department');
    const studentIdNumberInput = document.getElementById('student_id_number');
    const studentRoleInput = document.getElementById('student_role');
    const approveForm = document.getElementById('approveRequestForm');

    if (requestIdInput) requestIdInput.value = requestId;
    if (studentNameInput) studentNameInput.value = studentName;

    // Set form action dynamically
    if (approveForm) {
        approveForm.action = `/admin/user-requests/${requestId}/approve`;
    }

    // Fetch student details for the request
    fetch(`/admin/user-requests/${requestId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const requestData = data.request;
                if (studentEmailInput) studentEmailInput.value = requestData.email;
                if (studentDepartmentInput) studentDepartmentInput.value = requestData.department.name;
                if (studentIdNumberInput) studentIdNumberInput.value = requestData.id_number;
                if (studentRoleInput) studentRoleInput.value = requestData.role.charAt(0).toUpperCase() + requestData.role.slice(1);
            } else {
                showToast(data.message || 'Failed to fetch request details.', 'error');
            }
        })
        .catch(error => {
            console.error('Error fetching request details:', error);
            showToast('Error fetching request details.', 'error');
        });

    modal.classList.remove('hidden');
    modal.classList.add('show');
}

function openRejectModal(requestId, studentName) {
    const modal = document.getElementById('rejectModal');
    const requestIdInput = document.getElementById('reject_request_id');
    const rejectReasonTextarea = document.getElementById('reject_reason');
    const rejectForm = document.getElementById('rejectRequestForm');

    if (requestIdInput) requestIdInput.value = requestId;
    if (rejectForm) {
        rejectForm.action = `/admin/user-requests/${requestId}/reject`;
    }

    // Clear previous reason
    if (rejectReasonTextarea) {
        rejectReasonTextarea.value = '';
        rejectReasonTextarea.classList.remove('bg-red-50', 'focus:bg-red-50');
    }

    modal.classList.remove('hidden');
    modal.classList.add('show');
}

function submitApproveRequestForm(event) {
    if (event) event.preventDefault();
    const form = document.getElementById('approveRequestForm');
    const formData = new FormData(form);

    let submitBtn = event.target;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Approving...';
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(async response => {
        let data;
        try {
            data = await response.json();
        } catch {
            throw new Error('Invalid JSON response');
        }
        if (response.status === 422 && data.errors) {
            showFormErrors(data.errors);
            showToast('Please fix the errors below and try again.', 'error');
            return;
        }
        if (!response.ok) {
            throw new Error(data.message || 'An error occurred');
        }
        if (data.success) {
            closeModal('approveModal');
            showToast('Request approved successfully!', 'success');
            // Optionally, refresh the requests table or remove the approved request row
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(data.message || 'An error occurred while approving the request.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while approving the request.', 'error');
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
}

function submitRejectRequestForm(event) {
    if (event) event.preventDefault();
    const form = document.getElementById('rejectRequestForm');
    const formData = new FormData(form);

    let submitBtn = event.target;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Rejecting...';
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(async response => {
        let data;
        try {
            data = await response.json();
        } catch {
            throw new Error('Invalid JSON response');
        }
        if (response.status === 422 && data.errors) {
            showFormErrors(data.errors);
            showToast('Please fix the errors below and try again.', 'error');
            return;
        }
        if (!response.ok) {
            throw new Error(data.message || 'An error occurred');
        }
        if (data.success) {
            closeModal('rejectModal');
            showToast('Request rejected successfully!', 'success');
            // Optionally, refresh the requests table or remove the rejected request row
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(data.message || 'An error occurred while rejecting the request.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while rejecting the request.', 'error');
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
}

// ...existing scripts for real-time validation, etc...
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('show');
        }
    });
}
</script>
@endsection
