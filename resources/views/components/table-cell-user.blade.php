@props([
    'user' => null,
    'name' => '',
    'profilePicture' => null,
    'initials' => ''
])

<td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center">
        <div class="flex-shrink-0 h-10 w-10">
            @if($profilePicture)
                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $profilePicture) }}" alt="{{ $name }}">
            @else
                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                    <span class="text-sm font-medium text-gray-700">
                        {{ $initials ?: strtoupper(substr($name, 0, 2)) }}
                    </span>
                </div>
            @endif
        </div>
        <div class="ml-4">
            <div class="text-sm font-medium text-gray-900">{{ $name }}</div>
        </div>
    </div>
</td>
