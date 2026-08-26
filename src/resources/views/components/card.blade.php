@props([
    'title' => null,
    'subtitle' => null,
    'action' => null,
    'footer' => null,
    'padding' => 'p-6',
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden ' . $class]) }}>
    @if ($title || $subtitle || $action)
        <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-slate-900 leading-snug">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($action)
                <div class="flex items-center gap-2">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="px-6 py-3.5 bg-slate-50/70 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
            {{ $footer }}
        </div>
    @endif
</div>
