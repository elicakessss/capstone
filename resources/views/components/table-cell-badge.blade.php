@props([
    'value' => '',
    'type' => 'default',
    'variant' => ''
])

@php
$badgeClasses = [
    // Status badges
    'active' => 'bg-green-100 text-green-800',
    'inactive' => 'bg-gray-100 text-gray-800',
    'pending' => 'bg-yellow-100 text-yellow-800',
    'approved' => 'bg-green-100 text-green-800',
    'rejected' => 'bg-red-100 text-red-800',

    // Role badges
    'admin' => 'bg-red-100 text-red-800',
    'adviser' => 'bg-yellow-100 text-yellow-800',
    'student' => 'bg-blue-100 text-blue-800',

    // Default
    'default' => 'bg-gray-100 text-gray-800'
];

$badgeClass = $badgeClasses[$variant] ?? $badgeClasses['default'];
@endphp

<td class="px-6 py-4 whitespace-nowrap">
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
        {{ $value }}
    </span>
</td>
