@php
    $links = [
        ['label' => 'Portfolio',       'route' => 'home'],
        ['label' => 'Collection',      'route' => 'collection.index'],
        ['label' => 'Materials',       'route' => 'materials.index'],
        ['label' => 'Virtual Fitting', 'route' => 'virtual-fitting'],
        ['label' => 'About',           'route' => 'about'],
    ];
@endphp

<header style="background:#FFFFFF;border-bottom:1px solid #DCD6D0;position:sticky;top:0;z-index:100;box-shadow:0 2px 12px rgba(23,42,57,0.06);">
    <nav class="mx-auto max-w-7xl px-5 lg:px-8" aria-label="Main navigation">
        <div style="display:flex;align-items:center;gap:1.25rem;height:76px;">

            {{-- ── Wordmark / Logo ─────────────────── --}}
            <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;">
                <span style="width:48px;height:48px;background:#FFFFFF;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                    <img src="{{ asset('images/clothiq.png') }}" alt="Clothiq logo" width="48" height="48" style="width:100%;height:100%;object-fit:contain;">
                </span>
                <span style="font-size:1.125rem;font-weight:900;letter-spacing:0.07em;text-transform:uppercase;color:#172A39;">Clothiq</span>
            </a>

            {{-- ── Desktop Links ────────────────────── --}}
            <div class="hidden lg:flex items-center" style="gap:0.25rem;margin-left:auto;margin-right:auto;">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        style="position:relative;padding:0.6rem 1rem;font-size:0.8125rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;text-decoration:none;border-radius:0.5rem;transition:all 0.15s;
                            {{ $isActive
                                ? 'color:#172A39;background:#F6F4F1;'
                                : 'color:#6E7575;background:transparent;' }}"
                        onmouseover="if(!this.dataset.active){this.style.color='#172A39';this.style.background='#F6F4F1';}"
                        onmouseout="if(!this.dataset.active){this.style.color='#6E7575';this.style.background='transparent';}"
                        @if ($isActive) data-active="1" @endif
                    >
                        {{ $link['label'] }}
                        @if ($isActive)
                            <span style="position:absolute;bottom:0;left:1rem;right:1rem;height:3px;background:#FC563C;border-radius:2px;"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- ── CTA Button ───────────────────────── --}}
            <div class="flex items-center gap-3" style="flex-shrink:0;">
                <a
                    href="{{ route('order.create') }}"
                    class="btn-accent"
                    style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;background:#FC563C;color:#FFFFFF !important;padding:0.6rem 1.25rem;font-size:0.8125rem;font-weight:800;letter-spacing:0.04em;border-radius:0.625rem;text-decoration:none;box-shadow:0 3px 12px rgba(252,86,60,0.35);transition:all 0.15s;"
                    onmouseover="this.style.background='#E44229';this.style.boxShadow='0 6px 18px rgba(252,86,60,0.45)';this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.background='#FC563C';this.style.boxShadow='0 3px 12px rgba(252,86,60,0.35)';this.style.transform='translateY(0)'"
                >
                    Request Order
                </a>

                {{-- Mobile menu toggle --}}
                <button
                    id="nav-toggle"
                    type="button"
                    style="display:none;align-items:center;justify-content:center;width:42px;height:42px;border-radius:0.625rem;border:1px solid #DCD6D0;background:#FFFFFF;cursor:pointer;color:#172A39;"
                    class="lg:hidden"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    aria-label="Toggle navigation"
                >
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── Mobile Menu ──────────────────────────── --}}
        <div id="mobile-menu" class="hidden lg:hidden" style="border-top:1px solid #DCD6D0;padding:0.875rem 0 1.25rem;">
            @foreach ($links as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a
                    href="{{ route($link['route']) }}"
                    style="display:block;padding:0.75rem 0.75rem;font-size:0.875rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;text-decoration:none;border-radius:0.5rem;
                        {{ $isActive ? 'color:#172A39;background:#F6F4F1;border-left:3px solid #FC563C;' : 'color:#6E7575;' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>

<style>
    @media (max-width:1023px) {
        #nav-toggle { display:flex !important; }
    }
</style>
