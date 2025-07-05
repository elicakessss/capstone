# Data Table Components Documentation

## Overview
The data table component system provides a consistent, reusable way to display tabular data across the application. It consists of several components that work together to create modern, responsive tables.

## Components

### 1. `<x-data-table>`
The main table wrapper component that provides structure, search, filtering, and pagination.

#### Props:
- `title` - Table title (optional)
- `description` - Table description (optional)
- `headers` - Array of column headers
- `data` - Collection of data items
- `searchable` - Enable search functionality (boolean)
- `searchUrl` - URL for search form submission
- `searchPlaceholder` - Search input placeholder text
- `searchValue` - Current search value
- `filters` - Array of filter configurations
- `pagination` - Pagination links
- `emptyIcon` - Icon for empty state
- `emptyTitle` - Title for empty state
- `emptyDescription` - Description for empty state
- `class` - Additional CSS classes

#### Example:
```blade
<x-data-table 
    title="System Users"
    :headers="['User', 'Email', 'Role', 'Status', 'Actions']"
    :data="$users"
    searchable="true"
    :searchUrl="route('admin.users.index')"
    searchPlaceholder="Search users..."
    :searchValue="request('search')"
    :pagination="$users->links()">
    
    @foreach($users as $user)
        {{-- Table rows go here --}}
    @endforeach
</x-data-table>
```

### 2. `<x-table-row>`
Individual table row wrapper that handles actions and hover effects.

#### Props:
- `actions` - Array of action configurations

#### Example:
```blade
<x-table-row :actions="$userActions">
    <x-table-cell-user :name="$user->name" />
    <x-table-cell-text :value="$user->email" />
    {{-- More cells --}}
</x-table-row>
```

### 3. `<x-table-cell-user>`
Specialized cell for displaying user information with avatar.

#### Props:
- `name` - User's full name
- `profilePicture` - Path to profile picture (optional)
- `initials` - User initials (optional, auto-generated if not provided)

#### Example:
```blade
<x-table-cell-user 
    :name="$user->name"
    :profilePicture="$user->profile_picture"
    :initials="strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1))" />
```

### 4. `<x-table-cell-badge>`
Cell for displaying status badges with predefined colors.

#### Props:
- `value` - Text to display in badge
- `variant` - Badge style variant

#### Available Variants:
- `active` - Green badge for active status
- `inactive` - Gray badge for inactive status
- `pending` - Yellow badge for pending status
- `approved` - Green badge for approved status
- `rejected` - Red badge for rejected status
- `admin` - Red badge for admin role
- `adviser` - Yellow badge for adviser role
- `student` - Blue badge for student role

#### Example:
```blade
<x-table-cell-badge 
    :value="$user->is_active ? 'Active' : 'Inactive'"
    :variant="$user->is_active ? 'active' : 'inactive'" />
```

### 5. `<x-table-cell-text>`
Basic text cell for simple data display.

#### Props:
- `value` - Text to display
- `class` - Additional CSS classes (optional)

#### Example:
```blade
<x-table-cell-text :value="$user->email" />
<x-table-cell-text :value="$user->created_at->format('M j, Y')" class="text-sm text-gray-500" />
```

### 6. `<x-table-actions>`
Action buttons component for table rows.

#### Props:
- `actions` - Array of action configurations

#### Action Configuration:
```php
[
    'type' => 'link|button|form',
    'url' => 'URL for link actions',
    'variant' => 'view|edit|delete|approve|reject|toggle',
    'icon' => 'FontAwesome icon class',
    'tooltip' => 'Tooltip text',
    'onclick' => 'JavaScript for button actions',
    'class' => 'Additional CSS classes'
]
```

## Filter Configuration

Filters can be added to tables using the `filters` prop:

```php
:filters="[
    [
        'type' => 'select',
        'name' => 'role',
        'url' => route('admin.users.index'),
        'selected' => request('role', 'all'),
        'options' => [
            'all' => 'All Roles',
            'student' => 'Students',
            'adviser' => 'Advisers',
            'admin' => 'Administrators'
        ]
    ]
]"
```

## Complete Example

```blade
<x-data-table 
    title="System Users"
    description="Manage system users, roles, and permissions"
    :headers="['User', 'ID Number', 'Department', 'Role', 'Status', 'Actions']"
    :data="$users"
    searchable="true"
    :searchUrl="route('admin.users.index')"
    searchPlaceholder="Search users..."
    :searchValue="request('search')"
    :filters="[
        [
            'type' => 'select',
            'name' => 'role',
            'url' => route('admin.users.index'),
            'selected' => request('role', 'all'),
            'options' => [
                'all' => 'All Roles',
                'student' => 'Students',
                'adviser' => 'Advisers',
                'admin' => 'Administrators'
            ]
        ]
    ]"
    :pagination="$users->appends(request()->query())->links()"
    emptyIcon="fas fa-users"
    emptyTitle="No users found"
    emptyDescription="There are no users in the system yet.">
    
    @foreach($users as $user)
        @php
            $userActions = [
                [
                    'type' => 'link',
                    'url' => route('admin.users.show', $user),
                    'variant' => 'view',
                    'icon' => 'fas fa-eye',
                    'tooltip' => 'View User Details'
                ],
                [
                    'type' => 'link',
                    'url' => route('admin.users.edit', $user),
                    'variant' => 'edit',
                    'icon' => 'fas fa-edit',
                    'tooltip' => 'Edit User'
                ]
            ];
            
            if($user->id !== auth()->id()) {
                $userActions[] = [
                    'type' => 'button',
                    'onclick' => 'toggleUserStatus(' . $user->id . ')',
                    'variant' => 'toggle',
                    'class' => 'table-action-toggle ' . ($user->is_active ? 'active' : 'inactive'),
                    'icon' => $user->is_active ? 'fas fa-user-slash' : 'fas fa-user-check',
                    'tooltip' => $user->is_active ? 'Deactivate User' : 'Activate User'
                ];
            }
        @endphp
        
        <x-table-row :actions="$userActions">
            <x-table-cell-user 
                :name="$user->name"
                :profilePicture="$user->profile_picture"
                :initials="strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1))" />
            
            <x-table-cell-text :value="$user->id_number" />
            
            <x-table-cell-text :value="$user->department->name ?? 'N/A'" />
            
            <x-table-cell-badge 
                :value="$user->role === 'admin' ? 'Administrator' : ucfirst($user->role)"
                :variant="$user->role" />
            
            <x-table-cell-badge 
                :value="$user->is_active ? 'Active' : 'Inactive'"
                :variant="$user->is_active ? 'active' : 'inactive'" />
        </x-table-row>
    @endforeach

    <x-slot name="empty">
        @if(request('search') || request('role'))
            <div class="mt-6">
                <a href="{{ route('admin.users.index') }}" class="text-green-600 hover:text-green-500">
                    Clear filters
                </a>
            </div>
        @endif
    </x-slot>
</x-data-table>
```

## Benefits

1. **Consistency** - All tables across the application have the same look and feel
2. **Reusability** - Components can be used in any table implementation
3. **Maintainability** - Updates to table styling apply globally
4. **Flexibility** - Easy to customize with props and slots
5. **Type Safety** - Clear structure for actions and configurations
6. **Responsive** - Built-in responsive design for all screen sizes
7. **Accessibility** - Proper ARIA labels and keyboard navigation

## Migration Guide

To convert existing hardcoded tables:

1. Replace table wrapper with `<x-data-table>`
2. Replace `<tr>` elements with `<x-table-row>`
3. Replace `<td>` elements with appropriate cell components
4. Move action buttons to the `actions` prop
5. Configure search and filters as needed
