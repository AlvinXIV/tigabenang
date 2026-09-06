<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F7F7F5]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Tigabenang</title>

    <link rel="icon" type="image/png" href="{{ asset('images/clothiq-logo.png') }}?v=3">
    
    <!-- Optimized Google Fonts: Plus Jakarta Sans & JetBrains Mono (Non-blocking with display=swap) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap">
    </noscript>
    
    <script>
        (function() {
            try {
                if (localStorage.getItem('tigabenang_admin_sidebar_collapsed') === 'true') {
                    document.documentElement.classList.add('sidebar-collapsed');
                }
            } catch(e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @livewireStyles

    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            --color-bg: #F7F7F5;
            --color-surface: #FFFFFF;
            --color-border: #E2E5E9;
            --color-primary: #102A43;
            --color-primary-hover: #193B5C;
            --color-text: #102A43;
            --color-text-muted: #667085;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        /* ── Standard Button Tokens ── */
        .btn-primary {
            background-color: #102A43;
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
            background-color: #193B5C;
        }
        .btn-primary:active {
            background-color: #0A1C2E;
        }
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: #FFFFFF;
            color: #102A43;
            border: 1px solid #D0D5DD;
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

        /* ── Light Atelier Sidebar Link Styling ── */
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.55rem 0.85rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #102A43;
            text-decoration: none;
            transition: background-color 0.15s ease, color 0.15s ease;
            position: relative;
        }
        .sidebar-nav-link svg {
            color: #667085;
            transition: color 0.15s ease;
        }
        .sidebar-nav-link:hover {
            background-color: #F7F7F5;
            color: #102A43;
        }
        .sidebar-nav-link:hover svg {
            color: #102A43;
        }
        .sidebar-nav-link.active {
            background-color: #102A43;
            color: #FFFFFF;
            font-weight: 600;
        }
        .sidebar-nav-link.active svg {
            color: #FFFFFF;
        }

        /* ── Collapsed / Minimized Sidebar System ── */
        aside#admin-sidebar {
            transition: width 0.2s ease-in-out, transform 0.2s ease-in-out;
        }

        /* ── Sidebar Toggle Button ── */
        .sidebar-toggle-btn {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid #E2E5E9;
            background: #FFFFFF;
            color: #102A43;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
            padding: 0;
        }

        .sidebar-toggle-btn:hover {
            background: #F7F7F5;
            border-color: #D0D5DD;
        }

        .sidebar-toggle-btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 2px rgba(16, 42, 67, 0.2);
        }

        .sidebar-toggle-btn svg {
            width: 18px;
            height: 18px;
            color: #102A43;
        }

        @media (max-width: 1023px) {
            .sidebar-toggle-btn {
                display: none !important;
            }
        }

        .sidebar-tooltip {
            display: none;
        }

        .sidebar-badge-collapsed {
            display: none;
        }

        .sidebar-show-collapsed {
            display: none !important;
        }

        @media (min-width: 1024px) {
            /* Desktop / Tablet Collapsed Mode */
            aside#admin-sidebar.is-collapsed,
            html.sidebar-collapsed aside#admin-sidebar {
                width: 70px !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-hide-collapsed,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-hide-collapsed {
                display: none !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-show-collapsed,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-show-collapsed {
                display: flex !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-brand-header,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-brand-header {
                padding: 0.75rem 0.5rem !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-brand-header > div:first-child,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-brand-header > div:first-child {
                justify-content: center !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-brand-header a,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-brand-header a {
                justify-content: center !important;
                margin: 0 auto !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-nav-container,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-nav-container {
                overflow: visible !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-nav-link,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-nav-link {
                justify-content: center !important;
                padding: 0 !important;
                width: 44px !important;
                height: 44px !important;
                margin: 0 auto !important;
                gap: 0 !important;
            }

            aside#admin-sidebar.is-collapsed .sidebar-badge-collapsed,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-badge-collapsed {
                display: flex !important;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 2px;
                right: 2px;
                min-width: 18px;
                height: 18px;
                padding: 0 4px;
                border-radius: 9999px;
                font-size: 10px;
                font-weight: 700;
                line-height: 1;
                border: 1.5px solid #FFFFFF;
                box-shadow: 0 1px 2px rgba(16, 42, 67, 0.12);
            }

            /* Tooltip Styling */
            aside#admin-sidebar.is-collapsed .sidebar-tooltip-target:hover .sidebar-tooltip,
            aside#admin-sidebar.is-collapsed .sidebar-tooltip-target:focus .sidebar-tooltip,
            aside#admin-sidebar.is-collapsed .sidebar-tooltip-target:focus-visible .sidebar-tooltip,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-tooltip-target:hover .sidebar-tooltip,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-tooltip-target:focus .sidebar-tooltip,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-tooltip-target:focus-visible .sidebar-tooltip {
                display: flex !important;
                align-items: center;
                position: absolute;
                left: calc(100% + 14px);
                top: 50%;
                transform: translateY(-50%);
                background-color: #102A43;
                color: #FFFFFF;
                font-size: 0.75rem;
                font-weight: 600;
                letter-spacing: 0.01em;
                white-space: nowrap;
                padding: 0.4rem 0.75rem;
                border-radius: 6px;
                box-shadow: 0 4px 14px rgba(16, 42, 67, 0.18);
                z-index: 100;
                pointer-events: none;
                animation: sidebarTooltipFadeIn 0.12s ease-out;
            }

            aside#admin-sidebar.is-collapsed .sidebar-tooltip::before,
            html.sidebar-collapsed aside#admin-sidebar .sidebar-tooltip::before {
                content: '';
                position: absolute;
                right: 100%;
                top: 50%;
                transform: translateY(-50%);
                border-width: 5px;
                border-style: solid;
                border-color: transparent #102A43 transparent transparent;
            }
        }

        @keyframes sidebarTooltipFadeIn {
            from { opacity: 0; transform: translateY(-50%) translateX(-4px); }
            to { opacity: 1; transform: translateY(-50%) translateX(0); }
        }

        /* ── Card Styling ── */
        .admin-card {
            background-color: #FFFFFF;
            border: 1px solid #E2E5E9;
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(16, 42, 67, 0.04);
        }

        /* ── Table Row Hover ── */
        .admin-table-row {
            transition: background-color 0.12s ease;
        }
        .admin-table-row:hover {
            background-color: #F7F7F5;
        }

        /* ── Standardized Select / Dropdown Token ── */
        .admin-select {
            height: 40px;
            background-color: #FFFFFF;
            border: 1px solid #D0D5DD;
            border-radius: 8px;
            color: #102A43;
            font-size: 0.8125rem;
            font-family: var(--font-sans);
            padding-left: 0.875rem;
            padding-right: 2.25rem;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23667085'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1rem 1rem;
            cursor: pointer;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .admin-select:focus {
            border-color: #102A43;
            outline: none;
            box-shadow: 0 0 0 2px rgba(16, 42, 67, 0.2);
        }
    </style>
</head>

@php
    $activeNav = 'dashboard';
    if (request()->routeIs('admin.dashboard')) {
        $activeNav = 'dashboard';
    } elseif (request()->routeIs('admin.pesanan.*') || request()->routeIs('admin.orders.*')) {
        $activeNav = 'orders';
    } elseif (request()->routeIs('admin.customers.*')) {
        $activeNav = 'customers';
    } elseif (request()->routeIs('admin.produk.*')) {
        $activeNav = 'products';
    } elseif (request()->routeIs('admin.kategori.*')) {
        $activeNav = 'categories';
    } elseif (request()->routeIs('admin.ukuran.*')) {
        $activeNav = 'sizes';
    } elseif (request()->routeIs('admin.model-3d.*')) {
        $activeNav = 'models3d';
    } elseif (request()->routeIs('admin.analytics')) {
        $activeNav = 'analytics';
    } elseif (request()->routeIs('admin.profile.*') || request()->routeIs('admin.settings') || request()->routeIs('admin.profile.legacy')) {
        $activeNav = 'settings';
    }
@endphp

<body
    class="h-full antialiased text-[#102A43] bg-[#F7F7F5] selection:bg-[#102A43]/20 selection:text-[#102A43] overflow-hidden"
    x-data="{
        sidebarOpen: false,
        currentNav: '{{ $activeNav }}',
        sidebarCollapsed: (function() {
            try {
                return localStorage.getItem('tigabenang_admin_sidebar_collapsed') === 'true';
            } catch(e) {
                return false;
            }
        })(),
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            try {
                localStorage.setItem('tigabenang_admin_sidebar_collapsed', this.sidebarCollapsed ? 'true' : 'false');
                if (this.sidebarCollapsed) {
                    document.documentElement.classList.add('sidebar-collapsed');
                } else {
                    document.documentElement.classList.remove('sidebar-collapsed');
                }
            } catch(e) {}
        }
    }"
>

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
            class="fixed inset-0 z-40 bg-[#102A43]/40 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- ============================================== -->
        <!-- SIDEBAR NAVIGATION                             -->
        <!-- ============================================== -->
        <aside
            id="admin-sidebar"
            :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                sidebarCollapsed ? 'is-collapsed lg:w-[70px]' : 'lg:w-64'
            ]"
            class="fixed inset-y-0 left-0 z-50 w-64 h-full flex flex-col justify-between transition-[width,transform] duration-200 ease-in-out lg:static lg:translate-x-0 shrink-0 select-none bg-white border-r border-[#E2E5E9]"
        >
            <div class="flex-1 flex flex-col min-h-0">
                
                <!-- Brand Header -->
                <div class="sidebar-brand-header shrink-0 p-4 border-b border-[#E2E5E9]">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-decoration-none min-w-0" aria-label="Dashboard Tigabenang">
                            <!-- Official Logo Emblem: Customer Portal monogram container design -->
                            <div class="sidebar-logo-emblem w-10 h-10 rounded-[10px] border border-[#E2E5E9] bg-white flex items-center justify-center shadow-[0_1px_2px_rgba(16,42,67,0.04)] shrink-0 select-none overflow-hidden">
                                <img
                                    src="{{ asset('images/clothiq-logo.png') }}?v=3"
                                    alt="Logo Tigabenang"
                                    width="32"
                                    height="32"
                                    class="h-[78%] w-[78%] object-contain select-none"
                                />
                            </div>
                            <!-- Brand Text (Hidden when collapsed) -->
                            <div class="sidebar-hide-collapsed min-w-0 overflow-hidden">
                                <div class="text-[#102A43] text-sm font-bold tracking-tight truncate">Tigabenang</div>
                                <div class="text-[#667085] text-[11px] font-medium leading-none mt-1 truncate">Konveksi &amp; Atelier Digital</div>
                            </div>
                        </a>

                        <!-- Desktop Toggle Button: 3 Horizontal Lines (Expanded mode) -->
                        <button
                            type="button"
                            @click="toggleSidebar()"
                            class="sidebar-toggle-btn sidebar-hide-collapsed ml-2"
                            :aria-expanded="!sidebarCollapsed"
                            aria-label="Minimalkan sidebar"
                            title="Minimalkan sidebar"
                        >
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Mobile Close Button -->
                        <button
                            @click="sidebarOpen = false"
                            type="button"
                            class="lg:hidden text-[#667085] hover:text-[#102A43] p-1.5 rounded-lg hover:bg-[#F7F7F5] cursor-pointer"
                            aria-label="Tutup menu sidebar"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop Toggle Button: 3 Horizontal Lines (Collapsed mode: centered below emblem) -->
                    <div class="sidebar-show-collapsed hidden flex-col items-center pt-2.5">
                        <button
                            type="button"
                            @click="toggleSidebar()"
                            class="sidebar-toggle-btn"
                            :aria-expanded="!sidebarCollapsed"
                            aria-label="Buka sidebar"
                            title="Buka sidebar"
                        >
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Navigation Groups -->
                <div class="sidebar-nav-container flex-1 px-3 py-4 space-y-5 overflow-y-auto">
                    
                    <!-- IKHTISAR -->
                    <div>
                        <div class="sidebar-hide-collapsed px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Ikhtisar
                        </div>
                        <nav class="space-y-1">
                            <a
                                href="{{ route('admin.dashboard') }}"
                                :class="currentNav === 'dashboard' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'dashboard' ? 'active' : '' }}"
                                aria-label="Dashboard"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Dashboard</span>
                                <div class="sidebar-tooltip">Dashboard</div>
                            </a>
                        </nav>
                    </div>

                    <!-- OPERASIONAL -->
                    <div>
                        <div class="sidebar-show-collapsed hidden w-8 h-px bg-[#E2E5E9] mx-auto my-3"></div>
                        <div class="sidebar-hide-collapsed px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Operasional
                        </div>
                        <nav class="space-y-1">
                            <!-- Pesanan Masuk -->
                            <a
                                href="{{ route('admin.pesanan.index') }}"
                                :class="currentNav === 'orders' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target justify-between {{ $activeNav === 'orders' ? 'active' : '' }}"
                                aria-label="Pesanan Masuk"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span class="sidebar-hide-collapsed truncate">Pesanan Masuk</span>
                                </div>
                                <!-- Expanded Badge -->
                                <span class="sidebar-hide-collapsed text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $activeNav === 'orders' ? 'bg-white/20 text-white' : 'bg-[#EBF1F8] text-[#102A43]' }}" :class="currentNav === 'orders' ? 'bg-white/20 text-white' : 'bg-[#EBF1F8] text-[#102A43]'">
                                    {{ \App\Models\Pemesanan::count() }}
                                </span>

                                <!-- Collapsed Badge -->
                                <span class="sidebar-badge-collapsed {{ $activeNav === 'orders' ? 'bg-white/20 text-white' : 'bg-[#EBF1F8] text-[#102A43]' }}" :class="currentNav === 'orders' ? 'bg-white/20 text-white' : 'bg-[#EBF1F8] text-[#102A43]'">
                                    {{ \App\Models\Pemesanan::count() }}
                                </span>

                                <div class="sidebar-tooltip">Pesanan Masuk ({{ \App\Models\Pemesanan::count() }})</div>
                            </a>

                            <!-- Direktori Pelanggan -->
                            <a
                                href="{{ route('admin.customers.index') }}"
                                :class="currentNav === 'customers' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'customers' ? 'active' : '' }}"
                                aria-label="Direktori Pelanggan"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Direktori Pelanggan</span>
                                <div class="sidebar-tooltip">Direktori Pelanggan</div>
                            </a>
                        </nav>
                    </div>

                    <!-- KATALOG & ASET -->
                    <div>
                        <div class="sidebar-show-collapsed hidden w-8 h-px bg-[#E2E5E9] mx-auto my-3"></div>
                        <div class="sidebar-hide-collapsed px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Katalog &amp; Aset
                        </div>
                        <nav class="space-y-1">
                            <!-- Katalog Produk -->
                            <a
                                href="{{ route('admin.produk.index') }}"
                                :class="currentNav === 'products' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'products' ? 'active' : '' }}"
                                aria-label="Katalog Produk"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Katalog Produk</span>
                                <div class="sidebar-tooltip">Katalog Produk</div>
                            </a>

                            <!-- Kategori Produk -->
                            <a
                                href="{{ route('admin.kategori.index') }}"
                                :class="currentNav === 'categories' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'categories' ? 'active' : '' }}"
                                aria-label="Kategori Produk"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Kategori Produk</span>
                                <div class="sidebar-tooltip">Kategori Produk</div>
                            </a>

                            <!-- Dimensi Ukuran -->
                            <a
                                href="{{ route('admin.ukuran.index') }}"
                                :class="currentNav === 'sizes' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'sizes' ? 'active' : '' }}"
                                aria-label="Dimensi Ukuran"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Dimensi Ukuran</span>
                                <div class="sidebar-tooltip">Dimensi Ukuran</div>
                            </a>

                            <!-- Model Pakaian 3D -->
                            <a
                                href="{{ route('admin.model-3d.index') }}"
                                :class="currentNav === 'models3d' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'models3d' ? 'active' : '' }}"
                                aria-label="Model Pakaian 3D"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Model Pakaian 3D</span>
                                <div class="sidebar-tooltip">Model Pakaian 3D</div>
                            </a>
                        </nav>
                    </div>

                    <!-- LAPORAN & SISTEM -->
                    <div>
                        <div class="sidebar-show-collapsed hidden w-8 h-px bg-[#E2E5E9] mx-auto my-3"></div>
                        <div class="sidebar-hide-collapsed px-3 mb-1.5 text-[10px] font-semibold text-[#98A2B3] uppercase tracking-wider">
                            Laporan &amp; Sistem
                        </div>
                        <nav class="space-y-1">
                            <!-- Analisis Bisnis -->
                            <a
                                href="{{ route('admin.analytics') }}"
                                :class="currentNav === 'analytics' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'analytics' ? 'active' : '' }}"
                                aria-label="Analisis Bisnis"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Analisis Bisnis</span>
                                <div class="sidebar-tooltip">Analisis Bisnis</div>
                            </a>

                            <!-- Pengaturan Akun -->
                            <a
                                href="{{ route('admin.profile.edit') }}"
                                :class="currentNav === 'settings' ? 'active' : ''"
                                class="sidebar-nav-link sidebar-tooltip-target {{ $activeNav === 'settings' ? 'active' : '' }}"
                                aria-label="Pengaturan Akun"
                            >
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="sidebar-hide-collapsed truncate">Pengaturan Akun</span>
                                <div class="sidebar-tooltip">Pengaturan Akun</div>
                            </a>
                        </nav>
                    </div>

                </div>
            </div>

            <!-- Bottom Sidebar: User Profile & Session -->
            <div class="shrink-0 p-3 border-t border-[#E2E5E9] bg-[#F7F7F5]">
                <!-- Expanded view: Direct text identity without placeholder avatar -->
                <div class="sidebar-hide-collapsed flex items-center justify-between">
                    <a href="{{ route('admin.profile.edit') }}" class="group text-decoration-none min-w-0 flex-1 pr-2" aria-label="Pengaturan Profil Admin">
                        <p class="text-[#102A43] font-semibold text-xs truncate group-hover:text-[#193B5C] transition-colors leading-snug">Admin Tigabenang</p>
                        <p class="text-[#667085] text-[11px] font-normal leading-none mt-0.5 truncate">Administrator</p>
                    </a>

                    <a href="{{ route('logout') }}" title="Keluar" aria-label="Keluar" class="text-[#667085] hover:text-rose-600 p-1.5 rounded-md hover:bg-white transition-colors cursor-pointer shrink-0" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                </div>

                <!-- Collapsed view: Clean centered logout action without avatar placeholder -->
                <div class="sidebar-show-collapsed hidden flex-col items-center py-1">
                    <a href="{{ route('logout') }}" class="sidebar-tooltip-target relative group flex items-center justify-center w-10 h-10 rounded-lg text-[#667085] hover:text-rose-600 hover:bg-white transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500/20 cursor-pointer" aria-label="Keluar" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <div class="sidebar-tooltip">Keluar</div>
                    </a>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="GET" class="hidden"></form>
            </div>
        </aside>

        <!-- ============================================== -->
        <!-- MAIN VIEWPORT AREA                             -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col h-full overflow-y-auto min-w-0 bg-[#F7F7F5]">
            
            <!-- Mobile Header Topbar -->
            <div class="lg:hidden shrink-0 h-14 border-b border-[#E2E5E9] px-4 flex items-center justify-between bg-white">
                <button @click="sidebarOpen = true" class="p-1.5 text-[#102A43] hover:text-[#193B5C] cursor-pointer" aria-label="Buka navigasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-[7px] border border-[#E2E5E9] bg-white flex items-center justify-center shadow-2xs overflow-hidden select-none">
                        <img
                            src="{{ asset('images/clothiq-logo.png') }}?v=3"
                            alt="Logo Tigabenang"
                            width="22"
                            height="22"
                            class="h-[78%] w-[78%] object-contain select-none"
                        />
                    </div>
                    <span class="text-xs font-bold tracking-wide text-[#102A43]">TIGABENANG</span>
                </div>
                <a href="{{ route('admin.profile.edit') }}" class="w-7 h-7 rounded-full bg-[#102A43] text-white flex items-center justify-center text-xs font-bold" aria-label="Profil Admin">TB</a>
            </div>

            <!-- Main Body Content (Expanded for dense business software layout) -->
            <main class="flex-1 px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-7 w-full max-w-[1440px] mx-auto min-w-0">
                @include('layouts.partials.flash')
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            <!-- Bottom Minimal Footer -->
            <footer class="shrink-0 px-4 py-4 sm:px-6 lg:px-8 border-t border-[#E2E5E9] text-xs text-[#667085] flex flex-col sm:flex-row items-center justify-between gap-3 w-full max-w-[1440px] mx-auto">
                <p>&copy; {{ date('Y') }} Tigabenang. Hak cipta dilindungi.</p>
                <div class="flex items-center gap-5 text-xs text-[#667085]">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-[#102A43] transition-colors font-medium text-decoration-none">Lihat Toko Pelanggan &rarr;</a>
                    <a href="{{ route('admin.profile.edit') }}" class="hover:text-[#102A43] transition-colors font-medium text-decoration-none">Pengaturan Akun</a>
                </div>
            </footer>

        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>

