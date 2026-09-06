@php
    $links = [
        ['label' => 'Beranda',          'route' => 'home',             'routeMatch' => 'home'],
        ['label' => 'Koleksi',          'route' => 'collection.index', 'routeMatch' => 'collection.*'],
        ['label' => 'Virtual fitting',  'route' => 'virtual-fitting',  'routeMatch' => 'virtual-fitting'],
        ['label' => 'Tentang',          'route' => 'about',            'routeMatch' => 'about'],
    ];
@endphp

<header
    id="main-navbar"
    class="main-navbar"
    style="background:#FFFFFF;position:sticky;top:0;z-index:100;width:100%;max-width:100%;overflow-x:clip;transition:transform 0.3s ease, box-shadow 0.2s ease;"
>
    <nav class="mx-auto max-w-[1200px] px-5 lg:px-8" aria-label="Navigasi utama">
        <div class="flex h-20 md:h-[88px] items-center justify-between gap-6">

            <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3 no-underline">
                <span class="flex h-11 w-11 md:h-12 md:w-12 items-center justify-center overflow-hidden rounded-xl border border-[#E2E5E9] bg-white shadow-xs transition-transform duration-200 group-hover:scale-105">
                    <img src="{{ asset('images/clothiq-logo.png') }}?v=3" alt="Logo Tigabenang" width="38" height="38" class="h-[82%] w-[82%] object-contain">
                </span>
                <span class="text-xl md:text-[1.25rem] font-bold tracking-tight text-[#102A43]">Tigabenang</span>
            </a>

            <div class="hidden items-center gap-2 lg:flex">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['routeMatch'] ?? $link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        class="border-b-2 px-4 py-2 text-[0.95rem] md:text-base no-underline transition-colors {{ $isActive ? 'border-[#102A43] font-semibold text-[#102A43]' : 'border-transparent font-medium text-[#667085] hover:text-[#102A43]' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-2 lg:hidden">
                <button
                    id="nav-toggle"
                    data-nav-toggle
                    type="button"
                    class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#E2E5E9] bg-white text-[#102A43]"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" data-nav-panel class="hidden border-t border-[#E2E5E9] py-3.5 lg:hidden">
            <div class="flex flex-col gap-1.5">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['routeMatch'] ?? $link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        class="rounded-xl px-4 py-3 text-base no-underline {{ $isActive ? 'bg-[#102A43] font-semibold text-white' : 'font-medium text-[#667085]' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>
</header>

<style>
    .main-navbar.navbar--hidden {
        transform: translateY(-100%) !important;
        pointer-events: none !important;
    }
    .main-navbar.navbar--scrolled {
        box-shadow: 0 1px 0 #E2E5E9 !important;
    }
    @media (max-width: 767px) {
        .main-navbar nav > div.flex {
            height: 4.25rem;
            gap: 1rem;
        }
        .main-navbar a.group span.flex.h-11 {
            height: 2.5rem;
            width: 2.5rem;
        }
        .main-navbar a.group > span.text-xl {
            font-size: 1.125rem;
        }
        .main-navbar #nav-toggle {
            height: 2.5rem;
            width: 2.5rem;
        }
        .main-navbar #mobile-menu {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        .main-navbar #mobile-menu a {
            padding-top: 0.625rem;
            padding-bottom: 0.625rem;
            font-size: 0.9375rem;
        }
    }
</style>

<script>
    (function() {
        const navbar = document.getElementById('main-navbar');
        if (!navbar) return;

        let lastScrollY = Math.max(0, window.scrollY || window.pageYOffset);
        let ticking = false;
        const deltaThreshold = 10;

        function handleScroll() {
            const currentScrollY = Math.max(0, window.scrollY || window.pageYOffset);
            const mobileMenu = document.getElementById('mobile-menu');
            const isMobileMenuOpen = mobileMenu && !mobileMenu.classList.contains('hidden');

            if (currentScrollY <= 20) {
                navbar.classList.remove('navbar--hidden');
                navbar.classList.remove('navbar--scrolled');
            } else {
                navbar.classList.add('navbar--scrolled');
                if (!isMobileMenuOpen) {
                    if (currentScrollY > lastScrollY && (currentScrollY - lastScrollY) > deltaThreshold) {
                        navbar.classList.add('navbar--hidden');
                    } else if (currentScrollY < lastScrollY && (lastScrollY - currentScrollY) > deltaThreshold) {
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
