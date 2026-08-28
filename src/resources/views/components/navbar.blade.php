@php
    $links = [
        ['label' => 'Portfolio',       'route' => 'home'],
        ['label' => 'Collection',      'route' => 'collection.index'],
        ['label' => 'Materials',       'route' => 'materials.index'],
        ['label' => 'Virtual Fitting', 'route' => 'virtual-fitting'],
        ['label' => 'About',           'route' => 'about'],
    ];
@endphp

<header style="background:#FFFFFF;border-bottom:1px solid #D8DDEF;position:sticky;top:0;z-index:100;box-shadow:0 1px 8px rgba(1,31,123,0.06);">
    <nav class="mx-auto max-w-7xl px-5 lg:px-8" aria-label="Main navigation">
        <div style="display:flex;align-items:center;gap:1.25rem;height:76px;">

            {{-- ── Wordmark / Logo ─────────────────── --}}
            <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;">
                <span style="width:52px;height:52px;background:#FFFFFF;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                    <img src="{{ asset('images/clothiq.png') }}" alt="Clothiq logo" width="52" height="52" style="width:100%;height:100%;object-fit:contain;">
                </span>
                <span style="font-size:1.125rem;font-weight:900;letter-spacing:0.07em;text-transform:uppercase;color:#011F7B;">Clothiq</span>
            </a>

            {{-- ── Desktop Links ────────────────────── --}}
            <div class="hidden lg:flex items-center" style="gap:0.125rem;margin-left:auto;margin-right:auto;">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        style="padding:0.5rem 0.875rem;font-size:0.7875rem;font-weight:600;letter-spacing:0.07em;text-transform:uppercase;text-decoration:none;border-radius:0.5rem;transition:all 0.15s;
                            {{ $isActive
                                ? 'color:#011F7B;background:#E6EAF8;'
                                : 'color:#4E5A88;background:transparent;' }}"
                        onmouseover="if(!this.dataset.active){this.style.color='#011F7B';this.style.background='#F5F7FF';}"
                        onmouseout="if(!this.dataset.active){this.style.color='#4E5A88';this.style.background='transparent';}"
                        @if ($isActive) data-active="1" @endif
                    >
                        {{ $link['label'] }}
                        @if ($isActive)
                            <span style="display:block;height:2px;background:#FFBA09;border-radius:1px;margin-top:2px;margin-bottom:-6px;"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- ── CTA Button ───────────────────────── --}}
            <div class="flex items-center gap-3" style="flex-shrink:0;">
                <a
                    href="{{ route('order.create') }}"
                    style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;background:#011F7B;color:#FFFFFF;padding:0.5rem 1.125rem;font-size:0.775rem;font-weight:700;letter-spacing:0.05em;border-radius:0.5rem;text-decoration:none;transition:background 0.15s,box-shadow 0.15s;box-shadow:0 2px 8px rgba(1,31,123,0.2);"
                    onmouseover="this.style.background='#011060';this.style.boxShadow='0 4px 16px rgba(1,31,123,0.35)'"
                    onmouseout="this.style.background='#011F7B';this.style.boxShadow='0 2px 8px rgba(1,31,123,0.2)'"
                >
                    Request Order
                </a>

                {{-- Mobile menu toggle --}}
                <button
                    id="nav-toggle"
                    type="button"
                    style="display:none;align-items:center;justify-content:center;width:40px;height:40px;border-radius:0.5rem;border:none;background:transparent;cursor:pointer;color:#011F7B;"
                    class="lg:hidden"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    aria-label="Toggle navigation"
                >
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── Mobile Menu ──────────────────────────── --}}
        <div id="mobile-menu" class="hidden lg:hidden" style="border-top:1px solid #D8DDEF;padding:0.75rem 0 1rem;">
            @foreach ($links as $link)
                @php $isActive = request()->routeIs($link['route']); @endphp
                <a
                    href="{{ route($link['route']) }}"
                    style="display:block;padding:0.625rem 0.5rem;font-size:0.8125rem;font-weight:600;letter-spacing:0.07em;text-transform:uppercase;text-decoration:none;border-radius:0.5rem;
                        {{ $isActive ? 'color:#011F7B;background:#E6EAF8;' : 'color:#4E5A88;' }}"
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
