@php
    $links = [
        ['label' => 'Home',            'route' => 'home',            'routeMatch' => 'home'],
        ['label' => 'About',           'route' => 'about',           'routeMatch' => 'about'],
        ['label' => 'Collection',      'route' => 'collection.index','routeMatch' => 'collection.*'],
        ['label' => 'Materials',       'route' => 'materials.index', 'routeMatch' => 'materials.*'],
        ['label' => 'Virtual Fitting', 'route' => 'virtual-fitting', 'routeMatch' => 'virtual-fitting'],
    ];
@endphp

<header
    id="main-navbar"
    class="main-navbar"
    style="background: linear-gradient(135deg, #FAF8F5 0%, #F2ECE5 25%, #EAE2D8 65%, #E1D7CC 100%); border-bottom: 1px solid #D5CDC4; position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 20px rgba(23, 42, 57, 0.06), 0 1px 3px rgba(23, 42, 57, 0.03); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease, background 0.3s ease, box-shadow 0.3s ease;"
>
    <nav class="mx-auto max-w-[1480px] px-6 lg:px-12" aria-label="Main navigation">
        <div style="display: flex; align-items: center; justify-content: space-between; height: 88px;">

            {{-- ── Wordmark / Logo with Gradient Accents (Larger & Wider) ─────────────────── --}}
            <a href="{{ route('home') }}" class="group" style="display: flex; align-items: center; gap: 1.125rem; text-decoration: none; outline: none; flex-shrink: 0;">
                <span style="width: 58px; height: 58px; background: linear-gradient(145deg, #FFFFFF 0%, #F8F6F3 55%, #EDE8E2 100%); border: 1.5px solid rgba(213, 205, 196, 0.95); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; box-shadow: 0 6px 18px rgba(23, 42, 57, 0.1), inset 0 1px 2px #FFFFFF; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <img src="{{ asset('images/clothiq-logo.png') }}?v=2" alt="Clothiq logo" width="46" height="46" style="width: 86%; height: 86%; object-fit: contain; transition: transform 0.25s ease;" class="group-hover:scale-105">
                </span>
                <span style="font-size: 1.85rem; font-weight: 900; letter-spacing: 0.15em; text-transform: uppercase; line-height: 1; background: linear-gradient(135deg, #172A39 0%, #233B4E 60%, #0E1B25 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: inherit; display: inline-flex; align-items: center;">
                    Clothiq
                </span>
            </a>

            {{-- ── Desktop Floating Nav Pill Capsule (Larger & Shifted Left) ────────────────────── --}}
            <div class="hidden lg:flex items-center" style="margin-right: 2.5rem;">
                <div
                    class="nav-capsule"
                    style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.96) 0%, rgba(246, 243, 239, 0.92) 100%); border: 1.5px solid rgba(213, 205, 196, 0.95); border-radius: 9999px; padding: 7px 10px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 6px 24px rgba(23, 42, 57, 0.1), inset 0 1px 2px #FFFFFF; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);"
                >
                    @foreach ($links as $link)
                        @php $isActive = request()->routeIs($link['routeMatch'] ?? $link['route']); @endphp
                        <a
                            href="{{ route($link['route']) }}"
                            class="nav-pill-item {{ $isActive ? 'nav-pill-item--active' : '' }}"
                            style="{{ $isActive
                                ? 'background: linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%); color: #FFFFFF; font-weight: 800; padding: 11px 26px; border-radius: 9999px; font-size: 1.05rem; letter-spacing: 0.01em; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.15); box-shadow: 0 4px 16px rgba(23, 42, 57, 0.32), inset 0 1px 1px rgba(255, 255, 255, 0.25); transition: all 0.2s ease;'
                                : 'color: #4B5563; font-weight: 600; padding: 11px 22px; border-radius: 9999px; font-size: 1.05rem; letter-spacing: 0.01em; text-decoration: none; transition: all 0.2s ease;' }}"
                            onmouseover="if(!this.classList.contains('nav-pill-item--active')){this.style.color='#172A39';this.style.background='linear-gradient(135deg, #FFFFFF 0%, #F5F1EB 100%)';this.style.boxShadow='0 3px 10px rgba(23, 42, 57, 0.09), inset 0 1px 1px #FFFFFF';}"
                            onmouseout="if(!this.classList.contains('nav-pill-item--active')){this.style.color='#4B5563';this.style.background='transparent';this.style.boxShadow='none';}"
                        >
                            {{ $link['label'] }}
                        </a>
                    @endforeach

                    {{-- Vertical Divider with Gradient --}}
                    <span style="width: 2px; height: 26px; background: linear-gradient(180deg, rgba(213, 205, 196, 0.2) 0%, rgba(213, 205, 196, 0.95) 50%, rgba(213, 205, 196, 0.2) 100%); margin: 0 8px; display: inline-block;"></span>

                    {{-- Mail / Order Icon in Navy Gradient (Larger) --}}
                    @php $isOrderActive = request()->routeIs('order.*'); @endphp
                    <a
                        href="{{ route('order.create') }}"
                        title="Request Order"
                        aria-label="Request Order"
                        class="nav-pill-icon {{ $isOrderActive ? 'nav-pill-icon--active' : '' }}"
                        style="width: 44px; height: 44px; border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s ease;
                            {{ $isOrderActive
                                ? 'background: linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%); color: #FFFFFF; border: 1px solid rgba(255, 255, 255, 0.15); box-shadow: 0 4px 16px rgba(23, 42, 57, 0.32), inset 0 1px 1px rgba(255, 255, 255, 0.25);'
                                : 'background: linear-gradient(135deg, #FFFFFF 0%, #F5F1EC 100%); color: #172A39; border: 1.5px solid rgba(213, 205, 196, 0.9); box-shadow: 0 3px 8px rgba(23, 42, 57, 0.08);' }}"
                        onmouseover="if(!this.classList.contains('nav-pill-icon--active')){this.style.color='#FFFFFF';this.style.background='linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%)';this.style.borderColor='rgba(23, 42, 57, 0.8)';this.style.boxShadow='0 4px 16px rgba(23, 42, 57, 0.32), inset 0 1px 1px rgba(255, 255, 255, 0.25)';this.style.transform='scale(1.08)';}"
                        onmouseout="if(!this.classList.contains('nav-pill-icon--active')){this.style.color='{{ $isOrderActive ? '#FFFFFF' : '#172A39' }}';this.style.background='{{ $isOrderActive ? 'linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%)' : 'linear-gradient(135deg, #FFFFFF 0%, #F5F1EC 100%)' }}';this.style.borderColor='{{ $isOrderActive ? 'rgba(255, 255, 255, 0.15)' : 'rgba(213, 205, 196, 0.9)' }}';this.style.boxShadow='{{ $isOrderActive ? '0 4px 16px rgba(23, 42, 57, 0.32)' : '0 3px 8px rgba(23, 42, 57, 0.08)' }}';this.style.transform='scale(1)';}"
                    >
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- ── Mobile Nav Controls ───────────────────────── --}}
            <div class="flex items-center gap-2.5 lg:hidden">
                {{-- Mobile Quick Order Link --}}
                <a
                    href="{{ route('order.create') }}"
                    aria-label="Request Order"
                    style="width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(213, 205, 196, 0.9); background: linear-gradient(135deg, #FFFFFF 0%, #F5F1EC 100%); display: flex; align-items: center; justify-content: center; color: #172A39; text-decoration: none; box-shadow: 0 2px 8px rgba(23, 42, 57, 0.06);"
                >
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </a>

                {{-- Mobile Menu Toggle Button --}}
                <button
                    id="nav-toggle"
                    data-nav-toggle
                    type="button"
                    style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 12px; border: 1px solid rgba(213, 205, 196, 0.9); background: linear-gradient(135deg, #FFFFFF 0%, #F5F1EC 100%); cursor: pointer; color: #172A39; box-shadow: 0 2px 8px rgba(23, 42, 57, 0.06);"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    aria-label="Toggle navigation"
                    aria-expanded="false"
                >
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── Mobile Dropdown Menu with Gradient Treatment ──────────────────── --}}
        <div
            id="mobile-menu"
            data-nav-panel
            class="hidden lg:hidden"
            style="border-top: 1px solid rgba(213, 205, 196, 0.8); padding: 1.25rem 0 1.75rem; background: linear-gradient(180deg, #FAF8F5 0%, #EFE7DE 100%);"
        >
            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['routeMatch'] ?? $link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1.25rem; font-size: 1rem; font-weight: {{ $isActive ? '800' : '600' }}; text-decoration: none; border-radius: 0.875rem; transition: all 0.15s ease;
                            {{ $isActive
                                ? 'color: #FFFFFF; background: linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%); box-shadow: 0 4px 12px rgba(23, 42, 57, 0.25);'
                                : 'color: #555E68; background: transparent;' }}"
                    >
                        <span>{{ $link['label'] }}</span>
                        @if ($isActive)
                            <span style="width: 7px; height: 7px; border-radius: 50%; background: #FAF8F5;"></span>
                        @endif
                    </a>
                @endforeach

                <div style="margin-top: 0.875rem; padding-top: 0.875rem; border-top: 1px solid rgba(213, 205, 196, 0.8);">
                    <a
                        href="{{ route('order.create') }}"
                        style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.875rem 1.25rem; background: linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%); color: #FFFFFF; font-size: 1rem; font-weight: 800; border-radius: 0.875rem; text-decoration: none; box-shadow: 0 4px 16px rgba(23, 42, 57, 0.35);"
                    >
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>Request Order</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    /* ── Hide on scroll styles ── */
    .main-navbar.navbar--hidden {
        transform: translateY(-100%) !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }

    .main-navbar.navbar--scrolled {
        background: linear-gradient(135deg, rgba(250, 248, 245, 0.96) 0%, rgba(242, 236, 229, 0.94) 25%, rgba(234, 226, 216, 0.94) 65%, rgba(225, 215, 204, 0.94) 100%) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        box-shadow: 0 8px 32px rgba(23, 42, 57, 0.1) !important;
        border-bottom-color: #D5CDC4 !important;
    }

    @media (max-width: 1023px) {
        #nav-toggle { display: flex !important; }
    }
</style>

<script>
    (function() {
        const navbar = document.getElementById('main-navbar');
        if (!navbar) return;

        let lastScrollY = Math.max(0, window.scrollY || window.pageYOffset);
        let ticking = false;
        const deltaThreshold = 10; // min px of scroll movement to trigger

        function handleScroll() {
            const currentScrollY = Math.max(0, window.scrollY || window.pageYOffset);
            const mobileMenu = document.getElementById('mobile-menu');
            const isMobileMenuOpen = mobileMenu && !mobileMenu.classList.contains('hidden');

            // When at or near the very top of the page, always show navbar
            if (currentScrollY <= 20) {
                navbar.classList.remove('navbar--hidden');
                navbar.classList.remove('navbar--scrolled');
            } else {
                navbar.classList.add('navbar--scrolled');

                // Don't auto-hide if user has the mobile menu opened
                if (!isMobileMenuOpen) {
                    // Scrolling DOWN -> Hide navbar
                    if (currentScrollY > lastScrollY && (currentScrollY - lastScrollY) > deltaThreshold) {
                        navbar.classList.add('navbar--hidden');
                    }
                    // Scrolling UP -> Reveal navbar
                    else if (currentScrollY < lastScrollY && (lastScrollY - currentScrollY) > deltaThreshold) {
                        navbar.classList.remove('navbar--hidden');
                    }
                }
            }

            lastScrollY = currentScrollY;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(handleScroll);
                ticking = true;
            }
        }, { passive: true });
    })();
</script>
