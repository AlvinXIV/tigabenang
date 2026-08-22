@php
    $links = [
        ['label' => 'Portfolio', 'url' => route('home').'#work', 'active' => request()->routeIs('home')],
        ['label' => 'Collection', 'url' => route('collection.index'), 'active' => request()->routeIs('collection.*')],
        ['label' => 'Materials', 'url' => route('materials.index'), 'active' => request()->routeIs('materials.*')],
        ['label' => 'Virtual Fitting', 'url' => route('virtual-fitting'), 'active' => request()->routeIs('virtual-fitting')],
        ['label' => 'About', 'url' => route('about'), 'active' => request()->routeIs('about')],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-line bg-ivory/95 backdrop-blur-sm">
    <div class="relative mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:grid lg:grid-cols-3 lg:px-8">
        <a href="{{ route('home') }}" class="font-serif text-xl tracking-[0.22em] text-charcoal lg:text-[1.35rem]">
            FITVENDOR
        </a>

        <nav class="hidden items-center justify-center gap-8 lg:flex" aria-label="Primary">
            @foreach ($links as $link)
                <a
                    href="{{ $link['url'] }}"
                    class="text-[11px] font-medium uppercase tracking-[0.22em] transition-colors {{ $link['active'] ? 'text-terracotta' : 'text-ink/80 hover:text-terracotta' }}"
                    @if ($link['active']) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden justify-end lg:flex">
            <span class="text-[10px] uppercase tracking-[0.28em] text-muted">Custom Atelier</span>
        </div>

        <button
            type="button"
            class="inline-flex h-10 w-10 items-center justify-center border border-line text-charcoal lg:hidden"
            data-nav-toggle
            aria-expanded="false"
            aria-controls="mobile-navigation"
            aria-label="Open menu"
        >
            <span class="flex flex-col gap-1.5" aria-hidden="true">
                <span class="block h-px w-5 bg-charcoal"></span>
                <span class="block h-px w-5 bg-charcoal"></span>
                <span class="block h-px w-3 bg-charcoal"></span>
            </span>
        </button>
    </div>

    <nav
        id="mobile-navigation"
        class="hidden border-t border-line bg-ivory lg:hidden"
        data-nav-panel
        aria-label="Mobile"
    >
        <div class="flex flex-col px-5 py-4">
            @foreach ($links as $link)
                <a
                    href="{{ $link['url'] }}"
                    class="border-b border-line py-4 text-sm uppercase tracking-[0.2em] {{ $link['active'] ? 'text-terracotta' : 'text-charcoal' }}"
                    @if ($link['active']) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
