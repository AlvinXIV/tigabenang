<!DOCTYPE html>
<html lang="id" class="h-full bg-[#FAF8F5]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Clothiq Atelier Management Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --navy-dark: #0E1B25;
            --navy-primary: #172A39;
            --navy-surface: #1E3345;
            --cream-bg: #FAF8F5;
            --cream-card: #FFFFFF;
            --cream-border: #DCD6D0;
            --cream-accent: #EAE2D8;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--cream-bg);
            color: var(--navy-primary);
        }

        /* ── Tactical Pill Buttons with Rich Affordance ── */
        .btn-navy-pill {
            background: linear-gradient(135deg, #1E3345 0%, #172A39 50%, #0E1B25 100%) !important;
            color: #FFFFFF !important;
            border: 1.5px solid #1E3345 !important;
            border-radius: 9999px !important;
            font-weight: 800 !important;
            box-shadow: 0 4px 14px rgba(23, 42, 57, 0.28) !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .btn-navy-pill:hover {
            background: linear-gradient(135deg, #2A455C 0%, #1E3345 50%, #172A39 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 22px rgba(23, 42, 57, 0.38) !important;
        }
        .btn-navy-pill:active {
            transform: translateY(0) scale(0.98) !important;
        }

        .btn-cream-pill {
            background: linear-gradient(135deg, #FAF8F5 0%, #F2ECE5 50%, #EAE2D8 100%) !important;
            color: #172A39 !important;
            border: 2px solid #EAE2D8 !important;
            border-radius: 9999px !important;
            font-weight: 900 !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25) !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .btn-cream-pill:hover {
            background: #FFFFFF !important;
            border-color: #FFFFFF !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35) !important;
        }
        .btn-cream-pill:active {
            transform: translateY(0) scale(0.98) !important;
        }

        /* ── Sidebar Nav Link Styling ── */
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.65rem 1rem;
            border-radius: 9999px;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #FAF8F5 !important;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }
        .sidebar-nav-link svg {
            color: #AFC1D0 !important;
            transition: all 0.2s ease;
        }
        .sidebar-nav-link:hover {
            background: rgba(255, 255, 255, 0.12) !important;
            color: #FFFFFF !important;
            transform: translateX(6px);
        }
        .sidebar-nav-link:hover svg {
            color: #FFFFFF !important;
            transform: scale(1.1);
        }
        .sidebar-nav-link.active {
            background: linear-gradient(135deg, #FAF8F5 0%, #F0E8DC 100%) !important;
            color: #172A39 !important;
            font-weight: 900 !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.35) !important;
        }
        .sidebar-nav-link.active svg {
            color: #172A39 !important;
        }

        /* ── Sidebar Section Header ── */
        .sidebar-section-header {
            color: #AFC1D0 !important;
            font-size: 0.6875rem !important;
            font-weight: 900 !important;
            letter-spacing: 0.18em !important;
            text-transform: uppercase !important;
            opacity: 1 !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar-section-header::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(175, 193, 208, 0.2);
        }

        /* ── Rich Card Styling ── */
        .admin-card-rich {
            background: #FFFFFF;
            border: 1.5px solid #DCD6D0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 16px rgba(23, 42, 57, 0.04);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .admin-card-rich:hover {
            border-color: #B8B0A8;
            box-shadow: 0 10px 28px rgba(23, 42, 57, 0.08);
            transform: translateY(-2px);
        }

        /* ── Interactive Table Rows ── */
        .admin-table-row {
            transition: all 0.15s ease;
        }
        .admin-table-row:hover {
            background-color: #F5EFE8 !important;
        }
    </style>
</head>
<body class="h-full antialiased font-sans text-[#172A39] bg-[#FAF8F5] selection:bg-[#172A39] selection:text-white overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- App Container (Fixed Full-Height Viewport) -->
    <div class="h-screen w-full flex overflow-hidden bg-[#FAF8F5]">
        
        <!-- Mobile Sidebar Backdrop -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-[#0E1B25]/75 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- ============================================== -->
        <!-- FIXED DEEP NAVY LUXURY SIDEBAR NAVIGATION      -->
        <!-- ============================================== -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-64 h-full flex flex-col justify-between transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 shrink-0 select-none shadow-2xl lg:shadow-none"
            style="background:linear-gradient(180deg, #172A39 0%, #12212E 40%, #0A141C 100%);border-right:1.5px solid rgba(234, 226, 216, 0.15);"
        >
            <div class="flex-1 flex flex-col min-h-0">
                
                <!-- Brand Header (Pinned top) -->
                <div class="shrink-0 p-5 flex items-center justify-between border-b border-white/10" style="background:rgba(255, 255, 255, 0.04);">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 text-decoration-none">
                        <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-md shadow-black/30 overflow-hidden border-2 border-[#EAE2D8]">
                            <img src="{{ asset('images/clothiq-logo.png') }}?v=2" alt="Clothiq Logo" width="34" height="34" class="w-4/5 h-4/5 object-contain">
                        </div>
                        <div>
                            <div style="color:#FFFFFF !important; font-size:1.125rem; font-weight:900; letter-spacing:0.14em; line-height:1; text-transform:uppercase;">Clothiq</div>
                            <div style="color:#E2D7C8 !important; font-size:0.625rem; font-weight:800; letter-spacing:0.2em; text-transform:uppercase; margin-top:0.35rem; opacity:1 !important;">ATELIER PORTAL</div>
                        </div>
                    </a>

                    <!-- Mobile Close -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-white/80 hover:text-white p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Groups (Independent Scrollbar) -->
                <div class="flex-1 px-3.5 py-5 space-y-6 overflow-y-auto">
                    
                    <!-- Dashboard Main Nav -->
                    <div>
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>

                    <!-- CATALOG -->
                    <div>
                        <div class="px-3.5 mb-2.5 sidebar-section-header">
                            <span>CATALOG</span>
                        </div>
                        <nav class="space-y-1">
                            <!-- Products -->
                            <a
                                href="{{ route('admin.produk.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Products</span>
                            </a>

                            <!-- Materials & Categories -->
                            <a
                                href="{{ route('admin.kategori.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span>Materials &amp; Categories</span>
                            </a>

                            <!-- Size Charts -->
                            <a
                                href="{{ route('admin.ukuran.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.ukuran.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                <span>Size Charts</span>
                            </a>

                            <!-- 3D Models -->
                            <a
                                href="{{ route('admin.model-3d.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.model-3d.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>3D Models</span>
                            </a>
                        </nav>
                    </div>

                    <!-- OPERATIONS -->
                    <div>
                        <div class="px-3.5 mb-2.5 sidebar-section-header">
                            <span>OPERATIONS</span>
                        </div>
                        <nav class="space-y-1">
                            <!-- Orders -->
                            <a
                                href="{{ route('admin.pesanan.index') }}"
                                class="sidebar-nav-link justify-between {{ request()->routeIs('admin.pesanan.*') || request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span>Orders</span>
                                </div>
                                <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full {{ request()->routeIs('admin.pesanan.*') ? 'bg-[#172A39] text-white' : 'bg-white/20 text-[#FAF8F5]' }}">
                                    {{ \App\Models\Pemesanan::count() }}
                                </span>
                            </a>

                            <!-- Customers -->
                            <a
                                href="{{ route('admin.customers.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Customers</span>
                            </a>

                            <!-- Analytics -->
                            <a
                                href="{{ route('admin.analytics') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Analytics</span>
                            </a>
                        </nav>
                    </div>

                    <!-- SYSTEM -->
                    <div>
                        <div class="px-3.5 mb-2.5 sidebar-section-header">
                            <span>SYSTEM</span>
                        </div>
                        <nav class="space-y-1">
                            <!-- Settings -->
                            <a
                                href="{{ route('admin.profile.edit') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Settings</span>
                            </a>
                        </nav>
                    </div>

                </div>
            </div>

            <!-- Bottom Actions: New Product Button & User Profile (Pinned bottom) -->
            <div class="shrink-0 p-4 border-t border-white/15 space-y-3" style="background:rgba(0, 0, 0, 0.25);">
                <!-- New Product Button in High Contrast Cream/Gold Capsule -->
                <a
                    href="{{ route('admin.produk.create') }}"
                    class="btn-cream-pill w-full py-3 text-xs uppercase tracking-wider text-center"
                >
                    + NEW PRODUCT
                </a>

                <!-- User Profile Bar -->
                <div class="flex items-center justify-between pt-1 px-1">
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2.5 group text-decoration-none">
                        <div class="w-8 h-8 rounded-full bg-white text-[#172A39] flex items-center justify-center text-xs font-black shadow-md">
                            C
                        </div>
                        <div class="text-left">
                            <p style="color:#FFFFFF !important; font-weight:800; font-size:0.8125rem; line-height:1.2;" class="group-hover:text-[#EAE2D8] transition-colors">Clothiq Atelier</p>
                            <p style="color:#AFC1D0 !important; font-weight:700; font-size:0.6875rem; line-height:1.2;">Administrator</p>
                        </div>
                    </a>

                    <a href="{{ route('login') }}" title="Logout" style="color:#AFC1D0 !important;" class="hover:text-white p-1.5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- ============================================== -->
        <!-- MAIN VIEWPORT AREA (Scrolls Independently)    -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col h-full overflow-y-auto min-w-0 bg-[#FAF8F5]">
            
            <!-- Mobile Header Topbar -->
            <div class="lg:hidden shrink-0 h-16 border-b border-[#DCD6D0] px-4 flex items-center justify-between" style="background:#172A39;">
                <button @click="sidebarOpen = true" class="p-2 text-white hover:text-[#EAE2D8] cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/clothiq-logo.png') }}?v=2" alt="Clothiq Logo" width="24" height="24" class="w-6 h-6 object-contain">
                    <span class="text-xs font-black tracking-widest text-white uppercase">CLOTHIQ ATELIER</span>
                </div>
                <a href="{{ route('admin.profile.edit') }}" class="w-7 h-7 rounded-full bg-white text-[#172A39] flex items-center justify-center text-xs font-black">C</a>
            </div>

            <!-- Main Body Content -->
            <main class="flex-1 p-6 sm:p-10 max-w-6xl w-full mx-auto">
                @include('layouts.partials.flash')
                @yield('content')
            </main>

            <!-- Bottom Minimal Footer -->
            <footer class="shrink-0 px-6 sm:px-10 py-6 border-t border-[#DCD6D0] text-xs text-[#6E7575] flex flex-col sm:flex-row items-center justify-between gap-4 max-w-6xl w-full mx-auto">
                <p>&copy; {{ date('Y') }} Clothiq Atelier. All rights reserved.</p>
                <div class="flex items-center gap-6 text-xs text-[#6E7575]">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-[#172A39] transition-colors font-bold text-decoration-none">View Storefront &rarr;</a>
                    <a href="{{ route('admin.profile.edit') }}" class="hover:text-[#172A39] transition-colors font-bold text-decoration-none">Settings</a>
                </div>
            </footer>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
