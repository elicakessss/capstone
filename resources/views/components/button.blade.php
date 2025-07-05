@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, auth
    'size' => 'md', // sm, md, lg
    'fullWidth' => false,
    'disabled' => false,
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left' // left, right
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 transform hover:scale-105';

    $variantClasses = [
        'primary' => 'bg-green-800 text-white hover:bg-green-900 focus:ring-green-500',
        'secondary' => 'bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-500',
        'auth' => 'bg-green-800 text-white hover:bg-green-900 focus:ring-green-500'
    ];

    $sizeClasses = [
        'sm' => 'px-4 py-1.5 text-sm',
        'md' => 'px-4 py-2',
        'lg' => 'px-4 py-3'
    ];

    $classes = collect([
        $baseClasses,
        $variantClasses[$variant] ?? $variantClasses['primary'],
        $sizeClasses[$size] ?? $sizeClasses['md'],
        $fullWidth ? 'w-full' : '',
        $disabled ? 'opacity-50 cursor-not-allowed' : ''
    ])->filter()->implode(' ');
@endphp

@if($href)
    <a href="{{ $href }}"
       class="{{ $classes }}"
       {{ $disabled ? 'tabindex="-1" aria-disabled="true"' : '' }}
       {{ $attributes->except(['href']) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}"
            class="{{ $classes }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->except(['type']) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'ml-2' : '' }}"></i>
        @endif
    </button>
@endif
