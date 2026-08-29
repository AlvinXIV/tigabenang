@props([
    'variant' => 'slate',
    'dot' => false,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'px-2 py-0.5 text-[11px]',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];

    $variants = [
        'emerald' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
        'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
        'amber'   => 'bg-amber-50 text-amber-700 border border-amber-200/80',
        'warning' => 'bg-amber-50 text-amber-700 border border-amber-200/80',
        'sky'     => 'bg-sky-50 text-sky-700 border border-sky-200/80',
        'info'    => 'bg-sky-50 text-sky-700 border border-sky-200/80',
        'indigo'  => 'bg-indigo-50 text-indigo-700 border border-indigo-200/80',
        'primary' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/80',
        'rose'    => 'bg-rose-50 text-rose-700 border border-rose-200/80',
        'danger'  => 'bg-rose-50 text-rose-700 border border-rose-200/80',
        'purple'  => 'bg-purple-50 text-purple-700 border border-purple-200/80',
        'slate'   => 'bg-slate-100 text-slate-700 border border-slate-200',
    ];

    $dotColors = [
        'emerald' => 'bg-emerald-500',
        'success' => 'bg-emerald-500',
        'amber'   => 'bg-amber-500',
        'warning' => 'bg-amber-500',
        'sky'     => 'bg-sky-500',
        'info'    => 'bg-sky-500',
        'indigo'  => 'bg-indigo-500',
        'primary' => 'bg-indigo-500',
        'rose'    => 'bg-rose-500',
        'danger'  => 'bg-rose-500',
        'purple'  => 'bg-purple-500',
        'slate'   => 'bg-slate-400',
    ];

    $badgeClass = 'inline-flex items-center gap-1.5 font-medium rounded-full ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['slate']);
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$variant] ?? 'bg-slate-400' }} animate-pulse"></span>
    @endif
    {{ $slot }}
</span>
