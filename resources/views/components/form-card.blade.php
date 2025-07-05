@props([
    'title' => '',
    'subtitle' => '',
    'borderColor' => '#00471B'
])

<div class="bg-white rounded-lg shadow-sm border-l-4" style="border-left-color: {{ $borderColor }};">
    @if($title)
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
        @if($subtitle)
        <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
