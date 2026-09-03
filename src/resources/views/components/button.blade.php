@props([
    'variant' => 'primary',
    'type' => 'button',
    'size' => 'md',
    'href' => null,
])

@php
    $baseStyles = 'inline-flex items-center justify-center font-medium rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $sizes = [
        'xs' => 'px-2.5 py-1 text-xs gap-1.5',
        'sm' => 'px-3 py-1.5 text-xs gap-2',
        'md' => 'px-4 py-2.5 text-xs sm:text-sm gap-2',
        'lg' => 'px-5 py-3 text-sm gap-2.5',
    ];
    
    $variants = [
        'primary' => 'bg-[#B8664A] hover:bg-[#9A4E3A] active:bg-[#8A4330] text-white focus:ring-[#B8664A]/30 border border-transparent shadow-2xs',
        'secondary' => 'bg-white hover:bg-[#F7F7F5] active:bg-[#EEEFEC] text-[#1C2430] focus:ring-slate-300 border border-[#E2E5E9] shadow-2xs',
        'success' => 'bg-[#3F7A62] hover:bg-[#346551] active:bg-[#2A5242] text-white focus:ring-[#3F7A62]/30 border border-transparent shadow-2xs',
        'danger' => 'bg-white hover:bg-rose-50 active:bg-rose-100 text-rose-700 focus:ring-rose-200 border border-rose-200 shadow-2xs',
        'warning' => 'bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white focus:ring-amber-300 border border-transparent shadow-2xs',
        'outline' => 'bg-transparent border border-[#E2E5E9] hover:bg-[#F7F7F5] text-[#1C2430] focus:ring-slate-300',
        'ghost' => 'bg-transparent hover:bg-[#F7F7F5] text-[#667085] hover:text-[#1C2430]',
        'dark' => 'bg-[#1C2430] hover:bg-[#151C26] text-white focus:ring-[#1C2430]/30 shadow-2xs',
    ];

    $classes = $baseStyles . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

