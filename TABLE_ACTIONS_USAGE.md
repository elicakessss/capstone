# Table Actions Component Usage

## Overview
The `<x-table-actions>` component provides a consistent, reusable way to display action buttons in table rows across the application. It supports multiple action types with standardized styling and hover effects.

## Basic Usage

```blade
<x-table-actions :actions="[
    [
        'type' => 'link',
        'url' => route('admin.users.show', $user),
        'variant' => 'view',
        'icon' => 'fas fa-eye',
        'tooltip' => 'View Details'
    ]
]" />
```

## Action Types

### 1. Link Actions
```blade
[
    'type' => 'link',
    'url' => route('admin.users.edit', $user),
    'variant' => 'edit',
    'icon' => 'fas fa-edit',
    'tooltip' => 'Edit User',
    'target' => '_blank' // Optional
]
```

### 2. Button Actions
```blade
[
    'type' => 'button',
    'onclick' => 'deleteUser(' . $user->id . ')',
    'variant' => 'delete',
    'icon' => 'fas fa-trash',
    'tooltip' => 'Delete User',
    'id' => 'delete-btn-' . $user->id, // Optional
    'class' => 'custom-class', // Optional
    'disabled' => false // Optional
]
```

### 3. Form Actions
```blade
[
    'type' => 'form',
    'url' => route('admin.users.destroy', $user),
    'method' => 'DELETE',
    'variant' => 'delete',
    'icon' => 'fas fa-trash',
    'tooltip' => 'Delete User',
    'confirm' => 'Are you sure you want to delete this user?' // Optional
]
```

## Available Variants

| Variant   | Color  | Use Case              |
|-----------|--------|-----------------------|
| `view`    | Green  | View/Read actions     |
| `edit`    | Blue   | Edit/Update actions   |
| `delete`  | Red    | Delete/Remove actions |
| `approve` | Green  | Approve actions       |
| `reject`  | Red    | Reject actions        |
| `toggle`  | Dynamic| Toggle status actions |

## Complex Example

```blade
<x-table-actions :actions="[
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
    ],
    $user->id !== auth()->id() ? [
        'type' => 'button',
        'onclick' => 'toggleStatus(' . $user->id . ')',
        'variant' => 'toggle',
        'class' => $user->is_active ? 'active' : 'inactive',
        'icon' => $user->is_active ? 'fas fa-user-slash' : 'fas fa-user-check',
        'tooltip' => $user->is_active ? 'Deactivate' : 'Activate'
    ] : null
]" />
```

## Styling Features

- **Consistent sizing**: All actions are 32x32px (w-8 h-8)
- **Hover effects**: Scale, color change, and background highlight
- **Focus states**: Proper keyboard navigation support
- **Tooltips**: Built-in tooltip support on hover
- **Responsive**: Works on all screen sizes
- **Accessibility**: Proper ARIA labels and focus indicators

## CSS Classes

The component uses these predefined CSS classes:

- `.table-action` - Base action button styling
- `.table-action-view` - Green styling for view actions
- `.table-action-edit` - Blue styling for edit actions
- `.table-action-delete` - Red styling for delete actions
- `.table-action-approve` - Green styling for approve actions
- `.table-action-reject` - Red styling for reject actions
- `.table-action-toggle` - Dynamic styling for toggle actions

## Best Practices

1. **Limit actions**: Keep to 2-4 actions per row for better UX
2. **Consistent icons**: Use FontAwesome icons consistently
3. **Clear tooltips**: Always provide descriptive tooltips
4. **Conditional actions**: Use null to conditionally exclude actions
5. **Proper permissions**: Check user permissions before showing actions

## Migration from Old Style

### Before (old hardcoded style):
```blade
<a href="{{ route('admin.users.show', $user) }}" 
   class="text-green-600 hover:text-green-900 mr-3" 
   title="View User">
    <i class="fas fa-eye"></i>
</a>
```

### After (using component):
```blade
<x-table-actions :actions="[
    [
        'type' => 'link',
        'url' => route('admin.users.show', $user),
        'variant' => 'view',
        'icon' => 'fas fa-eye',
        'tooltip' => 'View User'
    ]
]" />
```
