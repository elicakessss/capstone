## 🚀 Data Table Component Usage

### **Basic Usage (Auto-detect fields):**
```blade
<x-data-table 
    title="Users"
    :data="$users"
/>
```

### **Advanced Usage (Custom fields & actions):**
```blade
<x-data-table 
    title="System Users"
    :data="$users"
    :columns="[
        ['key' => 'user', 'label' => 'User', 'type' => 'user'],
        ['key' => 'id_number', 'label' => 'ID Number'],
        ['key' => 'department', 'label' => 'Department', 'type' => 'relationship'],
        ['key' => 'role', 'label' => 'Role', 'type' => 'badge', 'badges' => [
            'admin' => 'bg-red-100 text-red-800',
            'student' => 'bg-blue-100 text-blue-800'
        ]],
        ['key' => 'created_at', 'label' => 'Joined', 'type' => 'date']
    ]"
    :actions="[
        ['icon' => 'fas fa-eye', 'route' => 'admin.users.show'],
        ['icon' => 'fas fa-edit', 'route' => 'admin.users.edit']
    ]"
    :filters="['role' => ['all' => 'All Roles', 'admin' => 'Admins']]"
/>
```

### **Column Types:**
- `text` - Plain text (default)
- `user` - User with avatar & name
- `badge` - Colored status badges
- `date` - Formatted dates
- `relationship` - Related model data

### **Action Types:**
- **Link Actions:** `route` or `url`
- **Button Actions:** `type => 'button'`, `onclick`
- **Conditional:** `condition => function($item) { return $item->is_active; }`

### **Icon-Only Actions:**
All actions now display as icons with tooltips (title attribute)
