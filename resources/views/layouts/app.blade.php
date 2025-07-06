<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Portfolio System')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Product+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN for testing -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green': {
                            800: '#00471B',
                            900: '#003d17',
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            600: '#16a34a',
                            'spup': '#00471B',
                        },
                        'yellow': {
                            400: '#FFCC00',
                            500: '#eab308',
                            600: '#ca8a04',
                            50: '#fefce8',
                            100: '#fef3c7',
                            'spup': '#FFCC00',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles for Enhanced Interactions -->
    <style>
        /* Custom hover animations */
        .sidebar-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar-item:hover {
            transform: scale(1.02) translateX(2px);
        }

        .sidebar-item:hover::before,
        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #00471B;
            border-radius: 0 2px 2px 0;
        }

        /* Department Card Hover - match button scale */
        .card-hover {
            transition: transform 0.15s cubic-bezier(0.4,0,0.2,1), box-shadow 0.15s;
        }
        .card-hover:hover, .card-hover:focus {
            transform: scale(1.06);
            box-shadow: 0 6px 16px -4px rgba(0, 71, 27, 0.08), 0 6px 6px -4px rgba(0, 71, 27, 0.03);
        }

        /* Pulse animation for notifications */
        .pulse-yellow {
            animation: pulse-yellow 2s infinite;
        }

        @keyframes pulse-yellow {
            0%, 100% {
                opacity: 1;
                background-color: #FFCC00;
            }
            50% {
                opacity: 0.7;
                background-color: #e6b800;
            }
        }

        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(0, 71, 27, 0.1);
            border-radius: 2px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 71, 27, 0.3);
            border-radius: 2px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 71, 27, 0.5);
        }

        /* Ripple effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Stats Card Pattern - Reusable Class */
        .stats-card {
            @apply bg-white rounded-lg shadow-sm p-6 hover:shadow-lg transition-all duration-200 transform hover:scale-105 cursor-pointer;
        }

        .stats-card-green {
            border-color: #00471B;
        }

        .stats-card-yellow {
            border-color: #FFCC00;
        }

        /* Stats Card Content Utilities */
        .stat-icon {
            @apply w-12 h-12 rounded-lg flex items-center justify-center;
        }

        .stat-icon-blue { @apply bg-blue-100 text-blue-600; }
        .stat-icon-green { @apply bg-green-100 text-green-600; }
        .stat-icon-yellow { @apply bg-yellow-100 text-yellow-600; }
        .stat-icon-purple { @apply bg-purple-100 text-purple-600; }
        .stat-icon-red { @apply bg-red-100 text-red-600; }
        .stat-icon-gray { @apply bg-gray-100 text-gray-600; }

        .stat-content { @apply ml-4; }
        .stat-label { @apply text-sm text-gray-600; }
        .stat-value { @apply text-2xl font-bold text-gray-900; }

        /* Form Design Utilities */
        /* Removed all form-card, form-label, form-select, form-textarea, form-file-area, etc. styles to allow per-page form styling only. */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            border-radius: 6px;
            font-size: 14px;
            height: 42px;
            min-height: 42px;
            padding: 0 1.5rem;
            gap: 0.5rem;
            transition: transform 0.15s cubic-bezier(0.4,0,0.2,1), background 0.15s, color 0.15s;
            outline: none;
            box-shadow: none;
            border: none;
            cursor: pointer;
            background: #fff;
        }
        .btn:active {
            transform: scale(0.98);
        }
        .btn:focus, .btn:hover {
            transform: scale(1.06);
            z-index: 1;
        }
        .btn-green {
            background: #00471B;
            color: #fff;
        }
        .btn-green i, .btn-green svg {
            color: #fff;
            transition: color 0.15s;
        }
        .btn-green:hover, .btn-green:focus {
            background: #00471B;
            color: #FFD600;
        }
        .btn-green:hover i, .btn-green:focus i,
        .btn-green:hover svg, .btn-green:focus svg {
            color: #FFD600;
        }
        .btn-blue {
            background: #2563eb;
            color: #fff;
        }
        .btn-blue i, .btn-blue svg {
            color: #fff;
        }
        .btn-blue:hover, .btn-blue:focus {
            background: #1d4ed8;
            color: #fff;
        }
        .btn-blue:hover i, .btn-blue:focus i,
        .btn-blue:hover svg, .btn-blue:focus svg {
            color: #fff;
        }
        .btn-red {
            background: #dc2626;
            color: #fff;
        }
        .btn-red i, .btn-red svg {
            color: #fff;
        }
        .btn-red:hover, .btn-red:focus {
            background: #b91c1c;
            color: #fff;
        }
        .btn-red:hover i, .btn-red:focus i,
        .btn-red:hover svg, .btn-red:focus svg {
            color: #fff;
        }
        .btn-white {
            background: #fff;
            color: #222;
            border: 1.5px solid #e5e7eb;
        }
        .btn-white i, .btn-white svg {
            color: #222;
        }
        .btn-white:hover, .btn-white:focus {
            background: #f5faff;
            color: #222;
        }
        .btn-white:hover i, .btn-white:focus i,
        .btn-white:hover svg, .btn-white:focus svg {
            color: #222;
        }

        /* Mobile Navigation Styles */
        .mobile-nav-item {
            position: relative;
            transition: all 0.2s ease;
        }

        .mobile-nav-item.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #00471B;
            border-radius: 0 0 2px 2px;
        }

        /* Table Action Styles */
        .table-action {
            @apply inline-flex items-center justify-center w-8 h-8 text-sm transition-all duration-200 rounded-lg hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-1;
        }

        .table-action-view,
        .table-action-view i {
            color: #16a34a !important;
        }

        .table-action-view:hover,
        .table-action-view:hover i {
            color: #15803d !important;
            background-color: #f0fdf4;
        }

        .table-action-edit,
        .table-action-edit i {
            color: #2563eb !important;
        }

        .table-action-edit:hover,
        .table-action-edit:hover i {
            color: #1d4ed8 !important;
            background-color: #eff6ff;
        }

        .table-action-delete,
        .table-action-delete i {
            color: #dc2626 !important;
        }

        .table-action-delete:hover,
        .table-action-delete:hover i {
            color: #b91c1c !important;
            background-color: #fef2f2;
        }

        .table-action-approve,
        .table-action-approve i {
            color: #16a34a !important;
        }

        .table-action-approve:hover,
        .table-action-approve:hover i {
            color: #15803d !important;
            background-color: #f0fdf4;
        }

        .table-action-reject,
        .table-action-reject i {
            color: #dc2626 !important;
        }

        .table-action-reject:hover,
        .table-action-reject:hover i {
            color: #b91c1c !important;
            background-color: #fef2f2;
        }

        .table-action-toggle {
            @apply focus:ring-gray-500;
        }

        .table-action-toggle.active,
        .table-action-toggle.active i {
            color: #dc2626 !important;
        }

        .table-action-toggle.active:hover,
        .table-action-toggle.active:hover i {
            color: #b91c1c !important;
            background-color: #fef2f2;
        }

        .table-action-toggle.inactive,
        .table-action-toggle.inactive i {
            color: #16a34a !important;
        }

        .table-action-toggle.inactive:hover,
        .table-action-toggle.inactive:hover i {
            color: #15803d !important;
            background-color: #f0fdf4;
        }

        /* Tooltip styles for table actions */
        .table-action[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 4px;
        }

        .table-action[title]:hover::before {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
        }

        /* Data Table Component Styles */
        .data-table tbody tr {
            transition: background 0.2s ease-in-out;
        }
        .data-table tbody tr:hover {
            border-left: none !important;
            box-shadow: none !important;
        }
        /* Green Table Header Styles */
        .data-table thead {
            background-color: #00471B !important;
        }
        .data-table thead th {
            color: white !important;
            background-color: #00471B !important;
            border-radius: 0 !important;
        }
        .data-table thead th:first-child {
            border-top-left-radius: 0 !important;
        }
        .data-table thead th:last-child {
            border-top-right-radius: 0 !important;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff; /* Restore white background */
            border-radius: 18px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            background-color: #00471B;
            color: white;
            padding: 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            background-color: #f9fafb;
            padding: 1rem 1.5rem;
            border-radius: 0 0 12px 12px;
            border-top: 1px solid #e5e7eb;
        }

        /* Unified form input style for forms only */
        .form-input, .form-select {
            width: 100%;
            padding: 1rem 1.25rem;
            border-radius: 6px !important; /* Match button border radius */
            border: 1.5px solid #e5e7eb !important; /* Match filter select/search bar */
            background: #fff !important; /* Match filter select/search bar */
            font-size: 1.1rem;
            color: #222;
            margin-bottom: 0.5rem;
            box-shadow: none !important;
            height: 42px !important; /* Match button height */
            min-height: 42px !important;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus, .form-select:focus {
            outline: 2px solid #0a3d1a;
            border-color: #0a3d1a !important;
            background: #f5faff !important;
        }
        /* .form-input is for forms only. Use .search-input for search bar. */
        /* Search bar and filter option unified design */
        .search-input {
            background: #fff !important;
            border: 1.5px solid #e5e7eb !important;
            border-radius: 6px !important; /* Match button border radius */
            color: #222 !important;
            font-size: 14px !important; /* Match global font size */
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif !important; /* Match global font */
            padding: 1rem 1.25rem;
            height: 42px !important;
            min-height: 42px !important;
            box-shadow: none !important;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-input:focus {
            outline: 2px solid #0a3d1a;
            border-color: #0a3d1a !important;
            background: #f5faff !important;
        }
        .form-select, .filter-select {
            background: #fff !important;
            border: 1.5px solid #e5e7eb !important;
            border-radius: 6px !important;
            color: #222 !important;
            font-size: 14px !important;
            height: 42px !important;
            min-height: 42px !important;
            padding: 0 1.25rem !important; /* Reduce vertical padding for better alignment */
            box-shadow: none !important;
            line-height: 1.2 !important;
        }
        .form-select:focus, .filter-select:focus, .form-select:active, .filter-select:active {
            outline: 2px solid #00471B;
            border-color: #00471B !important;
            background: #f5faff !important;
        }

        /* Remove Product Sans from font-family, use only system fonts */
        body, .font-sans, .antialiased {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif !important;
            font-size: 14px;
        }
        h1, .page-header {
            font-size: 20px !important;
        }
        h2, .section-title {
            font-size: 16px !important;
        }

        /* Sidebar Navigation Compactness */
        .sidebar-item {
            margin-bottom: 0.15rem !important; /* Reduce vertical spacing */
            padding-top: 0.55rem !important;
            padding-bottom: 0.55rem !important;
        }
        .sidebar-section {
            margin-bottom: 1.1rem !important; /* Slightly more space between groups */
        }
        /* Remove extra space between links in a group */
        .sidebar-section .space-y-1 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 0 !important;
        }

        /* Reusable Org Card */
        .org-card {
            @apply bg-white rounded-lg shadow p-6 flex flex-col gap-2 transition cursor-pointer;
        }
        .org-card:focus, .org-card:hover {
            transform: scale(1.025);
            box-shadow: 0 10px 25px -5px rgba(0, 71, 27, 0.10), 0 10px 10px -5px rgba(0, 71, 27, 0.04);
        }
        .org-card .org-title {
            @apply text-lg font-semibold text-gray-800 mb-1;
        }
        .org-card .org-type {
            @apply text-sm text-gray-500 mb-1;
        }
        .org-card .org-description {
            @apply text-gray-600 mb-2 line-clamp-2;
        }
        .org-card .org-term {
            @apply inline-block px-2 py-1 text-xs rounded bg-green-100 text-green-800;
        }
    </style>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Table Actions Helper -->
    <script>
        // Global function to render table actions
        function renderTableActions(actions) {
            return actions.map(action => {
                if (!action) return '';

                const iconClass = action.icon || '';
                const title = action.title || action.tooltip || '';
                const variant = action.variant || action.type;
                const customClass = action.class || '';
                const baseClass = `table-action table-action-${variant} ${customClass}`;

                if (action.type === 'link' || action.url) {
                    return `<a href="${action.url}"
                              class="${baseClass}"
                              title="${title}"
                              ${action.target ? `target="${action.target}"` : ''}>
                              <i class="${iconClass}"></i>
                            </a>`;
                } else if (action.type === 'button' || action.action || action.onclick) {
                    const clickHandler = action.action || action.onclick || '';
                    return `<button type="button"
                                   onclick="${clickHandler}"
                                   class="${baseClass}"
                                   title="${title}"
                                   ${action.disabled ? 'disabled' : ''}>
                              <i class="${iconClass}"></i>
                            </button>`;
                } else if (action.type === 'form') {
                    const method = action.method || 'POST';
                    const confirmMsg = action.confirm || '';
                    return `<form method="${method}"
                                  action="${action.url}"
                                  class="inline-block"
                                  ${confirmMsg ? `onsubmit="return confirm('${confirmMsg}')"` : ''}>
                              <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
                              ${method.toUpperCase() !== 'POST' ? `<input type="hidden" name="_method" value="${method}">` : ''}
                              <button type="submit"
                                      class="${baseClass}"
                                      title="${title}">
                                <i class="${iconClass}"></i>
                              </button>
                            </form>`;
                }
                return '';
            }).join('');
        }

        // Modal Helper Functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';

                // Setup real-time validation for add user modal
                if (modalId === 'addUserModal') {
                    setTimeout(() => {
                        if (typeof setupRealTimeValidation === 'function') {
                            setupRealTimeValidation();
                        }
                    }, 100);
                }
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        function resetForm(formId) {
            const form = document.getElementById(formId);
            if (form) {
                form.reset();

                // Clear error messages
                const errorElements = form.querySelectorAll('.error-message, .text-red-600');
                errorElements.forEach(el => {
                    el.textContent = '';
                    el.classList.add('hidden');
                });

                // Reset input styling - remove error states and restore normal states
                const inputElements = form.querySelectorAll('input, select');
                inputElements.forEach(el => {
                    el.classList.remove('bg-red-50', 'focus:bg-red-50', 'border-red-500');
                    el.classList.add('bg-gray-100', 'focus:bg-white');
                });
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    openModal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            }
        });

        // Modal open/close helpers for global modal
        function openGlobalModal(title, bodyHtml, footerHtml) {
            document.getElementById('globalModalTitle').innerHTML = title || 'Modal';
            document.getElementById('globalModalBody').innerHTML = bodyHtml || '';
            document.getElementById('globalModalFooter').innerHTML = footerHtml || '';
            document.getElementById('globalModal').classList.remove('hidden');
            document.getElementById('globalModal').classList.add('show');
        }
        function closeGlobalModal() {
            document.getElementById('globalModal').classList.add('hidden');
            document.getElementById('globalModal').classList.remove('show');
        }
    </script>
    <script>
    // Global Toast Notification
    function showToast(message, type = 'success') {
        // Remove any existing toast
        const existing = document.getElementById('custom-toast');
        if (existing) existing.remove();

        // Create toast element
        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.style.position = 'fixed';
        toast.style.bottom = '32px';
        toast.style.right = '32px';
        toast.style.background = '#00471B'; // System green shade
        toast.style.color = 'white';
        toast.style.padding = '16px 24px';
        toast.style.borderRadius = '8px';
        toast.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
        toast.style.zIndex = 9999;
        toast.style.fontSize = '16px';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '12px';

        // Add icon based on type
        const icon = document.createElement('span');
        if (type === 'success') {
            icon.innerHTML = `<svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="10" fill="#FFD600"/><path d="M6 10.5L9 13.5L14 8.5" stroke="#00471B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
        } else {
            icon.innerHTML = `<svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="10" fill="#FFD600"/><path d="M7 7L13 13M13 7L7 13" stroke="#B91C1C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
        }
        icon.style.display = 'inline-block';
        icon.style.marginRight = '8px';
        toast.appendChild(icon);

        const text = document.createElement('span');
        text.textContent = message;
        toast.appendChild(text);

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 2000); // Dismiss after 2 seconds
    }
    </script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
    <div class="flex h-screen overflow-hidden bg-white">
        <!-- Header (Full Width) -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-100 h-20">
            <div class="flex items-center justify-between h-full px-6">
                <!-- Left Side - Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <img src="/images/spup.png" alt="SPUP Logo" class="w-10 h-10 object-contain">
                    </div>
                    <div>
                        <span class="text-xl font-bold" style="color: #00471B;">St. Paul University Philippines</span>
                        <p class="text-sm" style="color: #00471B;">Paulinian Student Government E-Portfolio and Evaluation System</p>
                    </div>
                </div>

                <!-- Center - Empty (no breadcrumb) -->
                <div class="flex-1">
                </div>

                <!-- Right Side - User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="p-2 text-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 hover:shadow-lg" style="color: #00471B;">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 h-2 w-2 rounded-full pulse-yellow" style="background-color: #FFCC00;"></span>
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-3 p-2 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 hover:shadow-lg" style="color: #00471B;">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="font-medium text-gray-800">{{ Auth::user()->name ?? 'John Doe' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar (Desktop Only) -->
        <div class="hidden md:block fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transform translate-x-0 transition-transform duration-300 ease-in-out border-r border-gray-100" style="top: 80px;">
            <div class="flex flex-col h-full">
                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                    <!-- Dashboard (Common to all roles) -->
                    <a href="{{ route('dashboard') ?? '#' }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 {{ request()->routeIs('dashboard') ? 'bg-white shadow-md active' : 'hover:bg-white hover:shadow-lg' }}" style="color: #00471B;">
                        <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                            <i class="fas fa-home text-lg"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>

                    <!-- User Tabs: Portfolio, Organization, Profile (All users) -->
                    <div class="sidebar-section">
                        <a href="{{ route('portfolio.index') }}" class="sidebar-item group flex items-center px-4 py-2 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 {{ request()->routeIs('portfolio.*') ? 'bg-white shadow-md active' : 'hover:bg-white hover:shadow-lg' }}" style="color: #00471B;">
                            <div class="w-8 h-8 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                <i class="fas fa-folder-open text-lg"></i>
                            </div>
                            <span>Portfolio</span>
                        </a>
                        <a href="{{ route('councils.index') }}" class="sidebar-item group flex items-center px-4 py-2 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 {{ request()->routeIs('councils.*') ? 'bg-white shadow-md active' : 'hover:bg-white hover:shadow-lg' }}" style="color: #00471B;">
                            <div class="w-8 h-8 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <span>Organization</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="sidebar-item group flex items-center px-4 py-2 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 {{ request()->routeIs('profile.edit') ? 'bg-white shadow-md active' : 'hover:bg-white hover:shadow-lg' }}" style="color: #00471B;">
                            <div class="w-8 h-8 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                <i class="fas fa-user text-lg"></i>
                            </div>
                            <span>Profile</span>
                        </a>
                    </div>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <!-- Admin Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Admin Settings</h3>
                            <div class="space-y-1">
                                <!-- <a href="{{ route('admin.departments') ?? '#' }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.departments') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-building text-lg"></i>
                                    </div>
                                    <span>Departments</span>
                                </a> -->
                                <a href="{{ route('admin.orgs.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.orgs.index') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <span>Organizations</span>
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.users.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-user-shield text-lg"></i>
                                    </div>
                                    <span>Users</span>
                                </a>
                                <a href="{{ route('admin.forms.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('admin.forms.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-clipboard-list text-lg"></i>
                                    </div>
                                    <span>Evaluation Forms</span>
                                </a>
                            </div>
                        </div>
                    @elseif(auth()->check() && auth()->user()->role === 'adviser')
                        <!-- Adviser Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Portfolio</h3>
                            <div class="space-y-1">
                                <a href="{{ route('portfolio.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('portfolio.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-folder-open text-lg"></i>
                                    </div>
                                    <span>My Portfolio</span>
                                </a>
                            </div>
                        </div>

                        <!-- Councils Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Councils</h3>
                            <div class="space-y-1">
                                <a href="{{ route('councils.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('councils.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <span>My Councils</span>
                                </a>
                            </div>
                        </div>

                        <!-- Evaluation Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Evaluation</h3>
                            <div class="space-y-1">
                                <a href="{{ route('evaluations.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('evaluations.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-clipboard-check text-lg"></i>
                                    </div>
                                    <span>My Evaluations</span>
                                </a>
                                <a href="#" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-chart-line text-lg"></i>
                                    </div>
                                    <span>Evaluation Reports</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Student Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Portfolio</h3>
                            <div class="space-y-1">
                                <a href="{{ route('portfolio.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('portfolio.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-folder-open text-lg"></i>
                                    </div>
                                    <span>My Portfolio</span>
                                </a>
                                <a href="{{ route('portfolio.documents') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('portfolio.documents') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-upload text-lg"></i>
                                    </div>
                                    <span>Upload Documents</span>
                                </a>
                            </div>
                        </div>

                        <!-- Organization Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Councils</h3>
                            <div class="space-y-1">
                                <a href="{{ route('councils.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('councils.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <span>My Councils</span>
                                </a>
                            </div>
                        </div>

                        <!-- Evaluation Section -->
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold uppercase tracking-wider mb-3" style="color: #00471B;">Evaluation</h3>
                            <div class="space-y-1">
                                <a href="{{ route('evaluations.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-200 transform hover:scale-105 hover:bg-white hover:shadow-lg {{ request()->routeIs('evaluations.*') ? 'bg-white shadow-md active' : '' }}" style="color: #00471B;">
                                    <div class="w-10 h-10 flex items-center justify-center mr-3 transition-all duration-200" style="color: #00471B;">
                                        <i class="fas fa-star text-lg"></i>
                                    </div>
                                    <span>My Evaluations</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden md:ml-64" style="margin-top: 80px;">
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6 pb-20 md:pb-6">
                @yield('content')
            </main>
        </div>

        <!-- Mobile Bottom Navigation (Mobile Only) -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 md:hidden">
            <div class="flex justify-around items-center h-16">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <!-- Admin Mobile Nav -->
                    <a href="{{ route('dashboard') ?? '#' }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-home text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('admin.departments') ?? '#' }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('admin.departments') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-building text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('admin.orgs.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('admin.orgs.index') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-users text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-user-shield text-xl mb-1"></i>
                    </a>
                @elseif(auth()->check() && auth()->user()->role === 'adviser')
                    <!-- Adviser Mobile Nav -->
                    <a href="{{ route('dashboard') ?? '#' }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-home text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('portfolio.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('portfolio.*') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-folder-open text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('councils.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('councils.*') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-users text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('evaluations.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('evaluations.*') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-clipboard-check text-xl mb-1"></i>
                    </a>
                @else
                    <!-- Student Mobile Nav -->
                    <a href="{{ route('dashboard') ?? '#' }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-home text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('portfolio.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('portfolio.index') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-folder-open text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('portfolio.documents') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('portfolio.documents') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-upload text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('councils.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('councils.*') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-users text-xl mb-1"></i>
                    </a>
                    <a href="{{ route('evaluations.index') }}" class="mobile-nav-item flex-1 flex flex-col items-center justify-center py-2 {{ request()->routeIs('evaluations.*') ? 'active' : '' }}" style="color: #00471B;">
                        <i class="fas fa-star text-xl mb-1"></i>
                    </a>
                @endif
            </div>
        </nav>
    </div>

    @stack('scripts')
</body>
</html>
