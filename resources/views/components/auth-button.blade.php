@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, outline
    'size' => 'md', // sm, md, lg
    'href' => null,
    'disabled' => false,
])

@php
$baseClasses = 'font-medium rounded transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none';

$variants = [
    'primary' => 'bg-green-800 text-white hover:bg-green-900 hover:text-yellow-400 focus:text-yellow-400 focus:ring-green-500',
    'secondary' => 'bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-500',
    'outline' => 'bg-white text-green-800 border border-green-800 hover:bg-green-50 hover:text-yellow-400 focus:text-yellow-400 focus:ring-green-500',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2 text-base',
    'lg' => 'w-full py-3 px-4 text-lg',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}
       @if($disabled) aria-disabled="true" @endif>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $classes]) }}
            @if($disabled) disabled @endif>
        {{ $slot }}
    </button>
@endif
