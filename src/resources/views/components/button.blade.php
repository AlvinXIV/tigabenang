@props([
    'variant' => 'primary',
    'type' => 'button',
    'size' => 'md',
    'href' => null,
])

@php
    $baseStyles = 'inline-flex items-center justify-center font-medium rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm';
    
    $sizes = [
        'xs' => 'px-2.5 py-1 text-xs gap-1.5',
        'sm' => 'px-3 py-1.5 text-xs font-semibold gap-2',
        'md' => 'px-4 py-2.5 text-sm gap-2',
        'lg' => 'px-5 py-3 text-base gap-2.5',
    ];
    
    $variants = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white focus:ring-indigo-500 shadow-indigo-200/50',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 focus:ring-slate-400 border border-slate-200',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white focus:ring-emerald-500 shadow-emerald-200/50',
        'danger' => 'bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white focus:ring-rose-500 shadow-rose-200/50',
        'warning' => 'bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white focus:ring-amber-400 shadow-amber-200/50',
        'outline' => 'bg-transparent border border-slate-300 hover:bg-slate-50 active:bg-slate-100 text-slate-700 focus:ring-slate-400',
        'ghost' => 'bg-transparent hover:bg-slate-100 active:bg-slate-200 text-slate-600 shadow-none',
        'dark' => 'bg-slate-900 hover:bg-slate-800 text-white focus:ring-slate-900',
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
