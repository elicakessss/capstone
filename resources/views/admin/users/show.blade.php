@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
@php
    // Ensure departments are available for the edit form
    if (!isset($departments)) {
        $departments = \App\Models\Department::all();
    }
@endphp
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row gap-6 items-stretch">
        <!-- Sidebar / Profile Card -->
        <div class="bg-white rounded-lg shadow p-6 w-full md:w-1/4 flex flex-col items-center self-stretch relative">
            <!-- Removed Edit Button (pen icon) -->
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-user text-5xl text-gray-400"></i>
            </div>
            <div class="text-center">
                <div class="font-bold text-lg text-gray-900" id="user-name">{{ $user->name }}</div>
                <div class="text-sm text-gray-500" id="user-id-number">{{ $user->id_number }}</div>
                <div class="text-sm text-gray-500" id="user-email">{{ $user->email }}</div>
            </div>
            <div class="mt-4 w-full">
                <h4 class="font-semibold text-gray-700 mb-1">Bio</h4>
                <div class="text-sm text-gray-600 min-h-[48px]" id="user-bio">{{ $user->bio ?? 'Bio' }}</div>
            </div>
            <!-- Divider -->
            <div style="border-bottom:1.5px solid #e5e7eb; background:#f3f4f6; width:100%; margin:1.25rem 0 0.5rem 0;"></div>
            <!-- Action Buttons: Edit (Blue), Delete (Red) -->
            <div class="flex gap-2 justify-center w-full mt-2 mb-1">
                <button class="btn btn-blue" type="button" onclick="showEditUserModal()">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-red" type="submit">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col gap-6">
            <div class="bg-white rounded-lg shadow p-6 min-h-[120px] flex items-center justify-between">
                <div class="font-semibold text-gray-700">Councils Participated Section</div>
                <div class="text-gray-400">(To be added soon)</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 min-h-[120px] flex items-center justify-between">
                <div class="font-semibold text-gray-700">Uploaded awards</div>
                <div class="text-gray-400">(To be added soon)</div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal hidden">
    <div class="modal-content p-0" style="border-radius:18px; min-width:350px; max-width:600px; width:100%; margin:auto;">
        <!-- Modal Header -->
        <div class="modal-header" style="border-radius:18px 18px 0 0; padding:1.5rem; background:#00471B; color:white;">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Edit User</h3>
                <x-button onclick="closeModal('editUserModal')" variant="secondary" size="sm" icon="fas fa-times"></x-button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="modal-body p-0" style="padding:0;">
            <form id="editUserForm" action="{{ route('admin.users.update', $user) }}" method="POST" style="padding:1.5rem;">
                @csrf
                @method('PUT')
                <div class="form-row" style="display: flex; gap: 1rem;">
                    <div class="form-col" style="flex: 1;">
                        <label for="first_name" class="form-label">First Name</label>
                        <input id="first_name" type="text" name="first_name" class="form-input" value="{{ old('first_name', $user->first_name) }}" required>
                        <p class="form-error hidden" id="first_name_error"></p>
                    </div>
                    <div class="form-col" style="flex: 1;">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input id="last_name" type="text" name="last_name" class="form-input" value="{{ old('last_name', $user->last_name) }}" required>
                        <p class="form-error hidden" id="last_name_error"></p>
                    </div>
                </div>
                <div class="form-row" style="display: flex; gap: 1rem;">
                    <div class="form-col" style="flex: 1;">
                        <label for="id_number" class="form-label">ID Number</label>
                        <input id="id_number" type="text" name="id_number" class="form-input" value="{{ old('id_number', $user->id_number) }}" required>
                        <p class="form-error hidden" id="id_number_error"></p>
                    </div>
                    <div class="form-col" style="flex: 1;">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        <p class="form-error hidden" id="email_error"></p>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="department_id" class="form-label">Department</label>
                    <select id="department_id" name="department_id" class="form-select" required>
                        <option value="">Select Department</option>
                        @foreach($departments ?? [] as $department)
                            <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <p class="form-error hidden" id="department_id_error"></p>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="adviser" {{ $user->role == 'adviser' ? 'selected' : '' }}>Adviser</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <p class="form-error hidden" id="role_error"></p>
                </div>
                <div class="mb-4">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea id="bio" name="bio" class="form-input" rows="2">{{ old('bio', $user->bio) }}</textarea>
                    <p class="form-error hidden" id="bio_error"></p>
                </div>
                <div class="form-row" style="display: flex; gap: 1rem;">
                    <div class="form-col" style="flex: 1;">
                        <label for="password" class="form-label">Password <span class="text-gray-400">(leave blank to keep current)</span></label>
                        <input id="password" type="password" name="password" class="form-input" placeholder="Enter new password (min 8 chars)">
                        <p class="form-error hidden" id="password_error"></p>
                    </div>
                    <div class="form-col" style="flex: 1;">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Confirm new password">
                        <p class="form-error hidden" id="password_confirmation_error"></p>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <x-button onclick="submitEditUserForm(event)" variant="primary" icon="fas fa-save">Save Changes</x-button>
                </div>
            </form>
            <div class="flex justify-end space-x-3 mt-2">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger" icon="fas fa-trash">Delete</x-button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #editUserModal .modal-content {
        padding: 0 !important;
    }
    #editUserModal .modal-body {
        padding: 0 !important;
    }
    #editUserModal form {
        padding: 1.5rem !important;
    }
    #editUserModal .form-input,
    #editUserModal .form-select {
        font-size: 14px !important;
    }
    #editUserModal .form-label {
        font-size: 14px !important;
    }
</style>

<script>
function showEditUserModal() {
    document.getElementById('editUserModal').classList.remove('hidden');
    document.getElementById('editUserModal').classList.add('show');
    setupEditUserValidation();
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('show');
}
function submitEditUserForm(event) {
    event.preventDefault();
    const form = document.getElementById('editUserForm');
    clearEditFormErrors();
    if (!validateEditForm(form)) {
        showToast('Please fill in all required fields.', 'error');
        return;
    }
    const formData = new FormData(form);
    if (!formData.has('_method')) {
        formData.append('_method', 'PUT');
    }
    const submitBtn = event.target;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
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
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        if (data.success === true) {
            closeModal('editUserModal');
            showToast('User updated successfully!', 'success');
            if (data.user) {
                let fullName = data.user.name;
                if (typeof data.user.first_name !== 'undefined' && typeof data.user.last_name !== 'undefined') {
                    fullName = `${data.user.first_name} ${data.user.last_name}`.trim();
                }
                const nameEls = document.querySelectorAll('#user-name, #account-name');
                nameEls.forEach(el => el.textContent = fullName);
                const idEls = document.querySelectorAll('#user-id-number, #account-id-number');
                idEls.forEach(el => el.textContent = data.user.id_number);
                const emailEls = document.querySelectorAll('#user-email, #account-email');
                emailEls.forEach(el => el.textContent = data.user.email);
                const bioEls = document.querySelectorAll('#user-bio, #account-bio');
                bioEls.forEach(el => el.textContent = data.user.bio || 'Bio');
            }
        } else {
            if (data.errors && Object.keys(data.errors).length > 0) {
                showEditFormErrors(data.errors);
                showToast('Please fix the errors below and try again.', 'error');
            } else {
                closeModal('editUserModal');
                showToast(data.message || 'An error occurred while updating the user.', 'error');
            }
        }
    })
    .catch(error => {
        closeModal('editUserModal');
        showToast('An error occurred while updating the user.', 'error');
        setTimeout(() => { window.location.reload(); }, 1500);
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}
function clearEditFormErrors() {
    document.querySelectorAll('#editUserForm .form-error').forEach(e => {
        e.textContent = '';
        e.classList.add('hidden');
    });
    document.querySelectorAll('#editUserForm .form-input, #editUserForm .form-select').forEach(f => {
        f.classList.remove('bg-red-50', 'focus:bg-red-50');
        f.classList.add('bg-gray-100', 'focus:bg-white');
    });
}
function showEditFormErrors(errors) {
    Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(field + '_error');
        const inputElement = document.querySelector(`#editUserForm [name="${field}"]`);
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
function validateEditForm(form) {
    let isValid = true;
    const requiredFields = [
        'first_name',
        'last_name',
        'id_number',
        'email',
        'role',
        'department_id'
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
    // Password length (if provided)
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
function setupEditUserValidation() {
    const form = document.getElementById('editUserForm');
    if (!form) return;
    const requiredFields = ['first_name', 'last_name', 'id_number', 'email', 'role', 'department_id', 'password', 'password_confirmation'];
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.addEventListener('input', () => validateEditField(fieldName));
            field.addEventListener('change', () => validateEditField(fieldName));
            field.addEventListener('blur', () => validateEditField(fieldName));
        }
    });
}
function validateEditField(fieldName) {
    const form = document.getElementById('editUserForm');
    const field = form.querySelector(`[name="${fieldName}"]`);
    const errorElement = document.getElementById(fieldName + '_error');
    if (!field || !errorElement) return;
    let isValid = true;
    let errorMessage = '';
    if (!field.value.trim()) {
        isValid = false;
        errorMessage = `${getFieldLabel(fieldName)} is required.`;
    } else {
        switch(fieldName) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }
                break;
            case 'password':
                if (field.value.length > 0 && field.value.length < 8) {
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
</script>
@endsection
