@props([
    'title' => '',
    'value' => '',
    'icon' => 'fas fa-chart-bar',
    'iconColor' => 'blue',
    'trend' => null, // 'up', 'down', or null
    'trendValue' => null
])

@php
$iconColorClasses = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'red' => 'bg-red-100 text-red-600',
    'gray' => 'bg-gray-100 text-gray-600',
    'spup-green' => 'bg-green-100 text-green-800',
    'spup-yellow' => 'bg-yellow-100 text-yellow-800',
];

$iconClass = $iconColorClasses[$iconColor] ?? $iconColorClasses['blue'];
@endphp

<div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex items-center">
        <div class="w-12 h-12 {{ $iconClass }} rounded-lg flex items-center justify-center">
            <i class="{{ $icon }}"></i>
        </div>
        <div class="ml-4 flex-1">
            <p class="text-sm text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>

            @if($trend && $trendValue)
            <div class="flex items-center mt-1">
                @if($trend === 'up')
                    <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                    <span class="text-xs text-green-600">+{{ $trendValue }}</span>
                @elseif($trend === 'down')
                    <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i>
                    <span class="text-xs text-red-600">-{{ $trendValue }}</span>
                @endif
                <span class="text-xs text-gray-500 ml-1">from last month</span>
            </div>
            @endif
        </div>

        @if($slot->isNotEmpty())
        <div class="ml-4">
            {{ $slot }}
        </div>
        @endif
    </div>
</div>
