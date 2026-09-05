@props([
    'variant' => 'slate',
    'dot' => false,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-2.5 py-0.5 text-[11px]',
        'lg' => 'px-3 py-1 text-xs',
    ];

    $variants = [
        'emerald' => 'bg-emerald-50 text-emerald-800 border border-emerald-200',
        'success' => 'bg-emerald-50 text-emerald-800 border border-emerald-200',
        'amber'   => 'bg-amber-50 text-amber-800 border border-amber-200',
        'warning' => 'bg-amber-50 text-amber-800 border border-amber-200',
        'rose'    => 'bg-rose-50 text-rose-700 border border-rose-200',
        'danger'  => 'bg-rose-50 text-rose-700 border border-rose-200',
        'terracotta' => 'bg-[#EBF1F7] text-[#102A43] border border-[#D0DFEB]',
        'primary' => 'bg-[#EBF1F7] text-[#102A43] border border-[#D0DFEB]',
        'info'    => 'bg-sky-50 text-sky-800 border border-sky-200',
        'slate'   => 'bg-slate-100 text-slate-700 border border-slate-200',
        'neutral' => 'bg-slate-100 text-slate-700 border border-slate-200',
    ];

    $dotColors = [
        'emerald' => 'bg-emerald-600',
        'success' => 'bg-emerald-600',
        'amber'   => 'bg-amber-600',
        'warning' => 'bg-amber-600',
        'rose'    => 'bg-rose-600',
        'danger'  => 'bg-rose-600',
        'terracotta' => 'bg-[#102A43]',
        'primary' => 'bg-[#102A43]',
        'info'    => 'bg-sky-600',
        'slate'   => 'bg-slate-500',
        'neutral' => 'bg-slate-500',
    ];

    $badgeClass = 'inline-flex items-center gap-1.5 font-medium rounded-full ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['slate']);
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$variant] ?? 'bg-slate-400' }}"></span>
    @endif
    {{ $slot }}
</span>

