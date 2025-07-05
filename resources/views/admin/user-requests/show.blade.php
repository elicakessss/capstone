@extends('layouts.app')

@section('title', 'User Registration Request Details')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.user-requests.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Registration Request Details</h1>
                <p class="text-gray-600 mt-1">Review student registration information</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            @if($userRequest->isPending())
                <button onclick="openApproveModal({{ $userRequest->id }}, '{{ $userRequest->full_name }}')"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Approve
                </button>
                <button onclick="openRejectModal({{ $userRequest->id }}, '{{ $userRequest->full_name }}')"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reject
                </button>
            @endif
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Student Information Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 h-16 w-16">
                        <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-xl font-medium text-gray-700">
                                {{ strtoupper(substr($userRequest->first_name, 0, 1) . substr($userRequest->last_name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $userRequest->full_name }}</h2>
                        <p class="text-gray-600">{{ $userRequest->email }}</p>
                        <div class="mt-2">
                            @if($userRequest->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pending Review
                                </span>
                            @elseif($userRequest->status === 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">First Name</label>
                        <p class="text-lg text-gray-900">{{ $userRequest->first_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Name</label>
                        <p class="text-lg text-gray-900">{{ $userRequest->last_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Student ID Number</label>
                        <p class="text-lg text-gray-900">{{ $userRequest->id_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <p class="text-lg text-gray-900">{{ $userRequest->email }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                        <p class="text-lg text-gray-900">{{ $userRequest->department->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if($userRequest->admin_notes)
                <!-- Admin Notes Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Admin Notes</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $userRequest->admin_notes }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Timeline Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Timeline</h3>
                <div class="space-y-4">
                    <!-- Submitted -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Request Submitted</p>
                            <p class="text-xs text-gray-500">{{ $userRequest->created_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    @if($userRequest->reviewed_at)
                        <!-- Reviewed -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($userRequest->status === 'approved')
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Request {{ ucfirst($userRequest->status) }}</p>
                                <p class="text-xs text-gray-500">{{ $userRequest->reviewed_at->format('M j, Y \a\t g:i A') }}</p>
                                @if($userRequest->reviewer)
                                    <p class="text-xs text-gray-500">by {{ $userRequest->reviewer->name }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            @if($userRequest->isPending())
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button onclick="openApproveModal({{ $userRequest->id }}, '{{ $userRequest->full_name }}')"
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors text-left">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Approve Request
                        </button>
                        <button onclick="openRejectModal({{ $userRequest->id }}, '{{ $userRequest->full_name }}')"
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors text-left">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reject Request
                        </button>
                    </div>
                </div>
            @endif

            <!-- Request Details Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Details</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Request ID</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $userRequest->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($userRequest->status) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Submitted</span>
                        <span class="text-sm font-medium text-gray-900">{{ $userRequest->created_at->diffForHumans() }}</span>
                    </div>
                    @if($userRequest->reviewed_at)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Reviewed</span>
                            <span class="text-sm font-medium text-gray-900">{{ $userRequest->reviewed_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the same modals from index.blade.php -->
<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="approveForm" method="POST" action="{{ route('admin.user-requests.approve', $userRequest) }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Approve Registration
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to approve the registration request for <strong id="approveName">{{ $userRequest->full_name }}</strong>? This will create their user account.
                                </p>
                                <div class="mt-4">
                                    <label for="approveNotes" class="block text-sm font-medium text-gray-700">Admin Notes (Optional)</label>
                                    <textarea id="approveNotes" name="admin_notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Any additional notes..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Approve
                    </button>
                    <button type="button" onclick="closeModal('approveModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="rejectForm" method="POST" action="{{ route('admin.user-requests.reject', $userRequest) }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Reject Registration
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to reject the registration request for <strong id="rejectName">{{ $userRequest->full_name }}</strong>?
                                </p>
                                <div class="mt-4">
                                    <label for="rejectNotes" class="block text-sm font-medium text-gray-700">Reason for Rejection <span class="text-red-500">*</span></label>
                                    <textarea id="rejectNotes" name="admin_notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Please provide a reason for rejection..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject
                    </button>
                    <button type="button" onclick="closeModal('rejectModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openApproveModal(requestId, name) {
    document.getElementById('approveModal').classList.remove('hidden');
}

function openRejectModal(requestId, name) {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');

    if (event.target === approveModal) {
        closeModal('approveModal');
    }
    if (event.target === rejectModal) {
        closeModal('rejectModal');
    }
}
</script>
@endsection
