<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F7F7F5]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Tigabenang Vendor Portal</title>
    
    <!-- Optimized Google Fonts: Inter & JetBrains Mono (Non-blocking with display=swap) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;600&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;600&display=swap">
    </noscript>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            --color-bg: #F7F7F5;
            --color-surface: #FFFFFF;
            --color-border: #E2E5E9;
            --color-primary: #B8664A;
            --color-primary-hover: #9A4E3A;
            --color-text: #1C2430;
            --color-text-muted: #667085;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        /* ── Standard Button Tokens ── */
        .btn-primary {
            background-color: #B8664A;
            color: #FFFFFF;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
        }
        .btn-primary:hover {
            background-color: #9A4E3A;
        }
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: #FFFFFF;
            color: #1C2430;
            border: 1px solid #E2E5E9;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-secondary:hover {
            background-color: #F7F7F5;
            border-color: #D0D5DD;
        }

        .btn-danger {
            background-color: #FFFFFF;
            color: #DC2626;
            border: 1px solid #FECACA;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-danger:hover {
            background-color: #FEF2F2;
            border-color: #FCA5A5;
        }

        /* ── Sidebar Link Styling ── */
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.55rem 0.85rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #D0D5DD;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .sidebar-nav-link svg {
            color: #98A2B3;
            transition: color 0.15s ease;
        }
        .sidebar-nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }
        .sidebar-nav-link:hover svg {
            color: #FFFFFF;
        }
        .sidebar-nav-link.active {
            background-color: #B8664A;
            color: #FFFFFF;
            font-weight: 600;
        }
        .sidebar-nav-link.active svg {
            color: #FFFFFF;
        }

        /* ── Card Styling ── */
        .admin-card {
            background-color: #FFFFFF;
            border: 1px solid #E2E5E9;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        /* ── Table Row Hover ── */
        .admin-table-row {
            transition: background-color 0.12s ease;
        }
        .admin-table-row:hover {
            background-color: #FAF7F2;
        }
    </style>
</head>
<body class="h-full antialiased text-[#1C2430] bg-[#F7F7F5] selection:bg-[#B8664A]/20 selection:text-[#1C2430] overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- App Container (Fixed Full-Height Viewport) -->
    <div class="h-screen w-full flex overflow-hidden bg-[#F7F7F5]">
        
        <!-- Mobile Sidebar Backdrop -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-[#1C2430]/60 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- ============================================== -->
        <!-- SIDEBAR NAVIGATION                             -->
        <!-- ============================================== -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-64 h-full flex flex-col justify-between transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 shrink-0 select-none bg-[#1C2430] border-r border-[#2A3442]"
        >
            <div class="flex-1 flex flex-col min-h-0">
                
                <!-- Brand Header -->
                <div class="shrink-0 p-5 flex items-center justify-between border-b border-[#2A3442]">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-decoration-none">
                        <div class="w-9 h-9 bg-[#B8664A] rounded-lg flex items-center justify-center shrink-0 font-bold text-sm text-white shadow-xs">
                            TB
                        </div>
                        <div>
                            <div class="text-white text-sm font-bold tracking-tight">Tigabenang</div>
                            <div class="text-[#98A2B3] text-[11px] font-medium leading-none mt-1">Vendor Portal</div>
                        </div>
                    </a>

                    <!-- Mobile Close -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-[#98A2B3] hover:text-white p-1 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Groups -->
                <div class="flex-1 px-3 py-4 space-y-5 overflow-y-auto">
                    
                    <!-- IKHTISAR -->
                    <div>
                        <div class="px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Ikhtisar
                        </div>
                        <nav class="space-y-0.5">
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </nav>
                    </div>

                    <!-- OPERASIONAL -->
                    <div>
                        <div class="px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Operasional
                        </div>
                        <nav class="space-y-0.5">
                            <!-- Pesanan Masuk -->
                            <a
                                href="{{ route('admin.pesanan.index') }}"
                                class="sidebar-nav-link justify-between {{ request()->routeIs('admin.pesanan.*') || request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span>Pesanan Masuk</span>
                                </div>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ request()->routeIs('admin.pesanan.*') ? 'bg-white text-[#B8664A]' : 'bg-white/10 text-white' }}">
                                    {{ \App\Models\Pemesanan::count() }}
                                </span>
                            </a>

                            <!-- Direktori Pelanggan -->
                            <a
                                href="{{ route('admin.customers.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Direktori Pelanggan</span>
                            </a>
                        </nav>
                    </div>

                    <!-- KATALOG & ASET -->
                    <div>
                        <div class="px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Katalog &amp; Aset
                        </div>
                        <nav class="space-y-0.5">
                            <!-- Katalog Produk -->
                            <a
                                href="{{ route('admin.produk.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Katalog Produk</span>
                            </a>

                            <!-- Material Kain -->
                            <a
                                href="{{ route('admin.kategori.index') }}#material"
                                class="sidebar-nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                <span>Material Kain</span>
                            </a>

                            <!-- Kategori Produk -->
                            <a
                                href="{{ route('admin.kategori.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span>Kategori Produk</span>
                            </a>

                            <!-- Dimensi Ukuran -->
                            <a
                                href="{{ route('admin.ukuran.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.ukuran.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                <span>Dimensi Ukuran</span>
                            </a>

                            <!-- Model Pakaian 3D -->
                            <a
                                href="{{ route('admin.model-3d.index') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.model-3d.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>Model Pakaian 3D</span>
                            </a>
                        </nav>
                    </div>

                    <!-- LAPORAN & SISTEM -->
                    <div>
                        <div class="px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Laporan &amp; Sistem
                        </div>
                        <nav class="space-y-0.5">
                            <!-- Analisis Bisnis -->
                            <a
                                href="{{ route('admin.analytics') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Analisis Bisnis</span>
                            </a>

                            <!-- Pengaturan Akun -->
                            <a
                                href="{{ route('admin.profile.edit') }}"
                                class="sidebar-nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Pengaturan Akun</span>
                            </a>
                        </nav>
                    </div>

                </div>
            </div>

            <!-- Bottom Sidebar: User Profile & Session -->
            <div class="shrink-0 p-3.5 border-t border-[#2A3442] bg-[#151C26]">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2.5 group text-decoration-none min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-[#B8664A] text-white flex items-center justify-center text-xs font-semibold shrink-0">
                            TB
                        </div>
                        <div class="text-left truncate">
                            <p class="text-white font-medium text-xs truncate group-hover:text-[#B8664A] transition-colors">Admin Tigabenang</p>
                            <p class="text-[#98A2B3] text-[11px] font-normal leading-none mt-0.5">Administrator</p>
                        </div>
                    </a>

                    <a href="{{ route('logout') }}" title="Keluar" class="text-[#98A2B3] hover:text-rose-400 p-1.5 rounded-md hover:bg-white/5 transition-colors" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="GET" class="hidden">
                    </form>
                </div>
            </div>
        </aside>

        <!-- ============================================== -->
        <!-- MAIN VIEWPORT AREA                             -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col h-full overflow-y-auto min-w-0 bg-[#F7F7F5]">
            
            <!-- Mobile Header Topbar -->
            <div class="lg:hidden shrink-0 h-14 border-b border-[#E2E5E9] px-4 flex items-center justify-between bg-[#1C2430]">
                <button @click="sidebarOpen = true" class="p-1.5 text-white hover:text-[#B8664A] cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-[#B8664A] text-white rounded flex items-center justify-center font-bold text-[10px]">TB</div>
                    <span class="text-xs font-bold tracking-wide text-white">TIGABENANG</span>
                </div>
                <a href="{{ route('admin.profile.edit') }}" class="w-7 h-7 rounded-full bg-[#B8664A] text-white flex items-center justify-center text-xs font-bold">TB</a>
            </div>

            <!-- Main Body Content (Expanded for dense business software layout) -->
            <main class="flex-1 px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-7 w-full max-w-[1440px] mx-auto min-w-0">
                @include('layouts.partials.flash')
                @yield('content')
            </main>

            <!-- Bottom Minimal Footer -->
            <footer class="shrink-0 px-4 py-4 sm:px-6 lg:px-8 border-t border-[#E2E5E9] text-xs text-[#667085] flex flex-col sm:flex-row items-center justify-between gap-3 w-full max-w-[1440px] mx-auto">
                <p>&copy; {{ date('Y') }} Tigabenang. Hak cipta dilindungi.</p>
                <div class="flex items-center gap-5 text-xs text-[#667085]">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-[#B8664A] transition-colors font-medium text-decoration-none">Lihat Toko Pelanggan &rarr;</a>
                    <a href="{{ route('admin.profile.edit') }}" class="hover:text-[#B8664A] transition-colors font-medium text-decoration-none">Pengaturan Akun</a>
                </div>
            </footer>

        </div>
    </div>

    @stack('scripts')
</body>
</html>

