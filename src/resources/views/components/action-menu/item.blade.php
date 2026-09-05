@props([
    'href' => null,
    'danger' => false,
    'target' => null,
    'icon' => null,
])

@php
    $baseClasses = 'w-full flex items-center gap-2 px-3 py-2 text-xs text-left transition-colors cursor-pointer text-decoration-none border-0 bg-transparent';
    $colorClasses = $danger
        ? 'text-rose-600 hover:bg-rose-50 hover:text-rose-700'
        : 'text-[#1C2430] hover:bg-[#F7F7F5] hover:text-[#102A43]';
    $classes = $baseClasses . ' ' . $colorClasses;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} @if($target) target="{{ $target }}" @endif>
        @if ($icon)
            <span class="shrink-0 w-4 h-4 flex items-center justify-center">{!! $icon !!}</span>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="shrink-0 w-4 h-4 flex items-center justify-center">{!! $icon !!}</span>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
