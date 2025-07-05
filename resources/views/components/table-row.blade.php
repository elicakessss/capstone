@props([
    'actions' => []
])

<tr class="hover:bg-gray-50">
    {{ $slot }}

    @if(count($actions) > 0)
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <x-table-actions :actions="$actions" />
        </td>
    @endif
</tr>
