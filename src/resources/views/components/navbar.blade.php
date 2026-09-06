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
        <div class="flex h-20 md:h-[88px] items-center justify-between gap-4">

            <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-2.5 no-underline">
                <span class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-[10px] border border-[#E2E5E9] bg-white">
                    <img src="{{ asset('images/clothiq-logo.png') }}?v=3" alt="Logo FitVendor" width="32" height="32" class="h-[78%] w-[78%] object-contain">
                </span>
                <span class="text-[1.05rem] font-semibold tracking-tight text-[#102A43]">FitVendor</span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['routeMatch'] ?? $link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        class="border-b-2 px-3 py-2 text-sm no-underline transition-colors {{ $isActive ? 'border-[#102A43] font-semibold text-[#102A43]' : 'border-transparent font-medium text-[#667085] hover:text-[#102A43]' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="hidden lg:block">
                <a href="{{ route('order.create') }}" class="btn-primary min-h-0 inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold">
                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.154-.598 4.793 4.793 0 0 0 1.258-3.023C3.996 15.752 3 13.978 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                    </svg>
                    <span>Konsultasikan pesanan</span>
                </a>
            </div>

            <div class="flex items-center gap-2 lg:hidden">
                <a
                    href="{{ route('order.create') }}"
                    class="btn-primary min-h-0 inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold"
                    aria-label="Konsultasikan pesanan"
                >
                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.154-.598 4.793 4.793 0 0 0 1.258-3.023C3.996 15.752 3 13.978 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                    </svg>
                    <span>Konsultasi</span>
                </a>
                <button
                    id="nav-toggle"
                    data-nav-toggle
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-[10px] border border-[#E2E5E9] bg-white text-[#102A43]"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" data-nav-panel class="hidden border-t border-[#E2E5E9] py-3 lg:hidden">
            <div class="flex flex-col gap-1">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['routeMatch'] ?? $link['route']); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        class="rounded-[10px] px-3 py-3 text-sm no-underline {{ $isActive ? 'bg-[#102A43] font-semibold text-white' : 'font-medium text-[#667085]' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('order.create') }}" class="btn-primary min-h-0 mt-2 inline-flex w-full items-center justify-center gap-1.5 py-2.5 text-xs font-semibold">
                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.154-.598 4.793 4.793 0 0 0 1.258-3.023C3.996 15.752 3 13.978 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                    </svg>
                    <span>Konsultasikan pesanan</span>
                </a>
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
