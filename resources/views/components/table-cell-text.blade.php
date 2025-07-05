@props([
    'value' => '',
    'class' => 'text-sm text-gray-900'
])

<td class="px-6 py-4 whitespace-nowrap {{ $class }}">
    {{ $value }}
</td>
