@props([
    'eyebrow' => null,
    'title',
    'actionLabel' => null,
    'actionUrl' => null,
    'align' => 'left',
])

<div @class([
    'flex flex-col gap-6 md:flex-row md:items-end md:justify-between',
    'text-center md:flex-col md:items-center' => $align === 'center',
])>
    <div class="{{ $align === 'center' ? 'mx-auto max-w-2xl' : 'max-w-2xl' }}">
        @if ($eyebrow)
            <span class="section-badge mb-4">{{ $eyebrow }}</span>
        @endif
        <h2 class="text-3xl font-bold leading-tight tracking-tight text-primary md:text-4xl">{{ $title }}</h2>
        @isset($slot)
            @if (trim((string) $slot) !== '')
                <div class="mt-3 text-sm leading-relaxed text-text-muted md:text-base">
                    {{ $slot }}
                </div>
            @endif
        @endisset
    </div>

    @if ($actionLabel && $actionUrl)
        <a href="{{ $actionUrl }}" class="section-badge shrink-0 hover:opacity-70 transition-opacity">
            {{ $actionLabel }}
        </a>
    @endif
</div>
