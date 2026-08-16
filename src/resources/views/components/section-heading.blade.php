@props([
    'eyebrow' => null,
    'title',
    'actionLabel' => null,
    'actionUrl' => null,
    'align' => 'left',
])

<div @class([
    'flex flex-col gap-6 md:flex-row md:items-end md:justify-between',
    'text-center md:text-center' => $align === 'center',
])>
    <div class="{{ $align === 'center' ? 'mx-auto max-w-2xl' : 'max-w-2xl' }}">
        @if ($eyebrow)
            <p class="text-[11px] uppercase tracking-[0.28em] text-terracotta">{{ $eyebrow }}</p>
        @endif
        <h2 class="mt-3 font-serif text-4xl leading-tight text-charcoal md:text-5xl">{{ $title }}</h2>
        @isset($slot)
            @if (trim((string) $slot) !== '')
                <div class="mt-4 text-sm leading-relaxed text-muted md:text-base">
                    {{ $slot }}
                </div>
            @endif
        @endisset
    </div>

    @if ($actionLabel && $actionUrl)
        <a href="{{ $actionUrl }}" class="shrink-0 text-[11px] uppercase tracking-[0.22em] text-terracotta transition-colors hover:text-terracotta-dark">
            {{ $actionLabel }}
        </a>
    @endif
</div>
