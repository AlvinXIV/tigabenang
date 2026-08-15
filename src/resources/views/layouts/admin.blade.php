<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Tigabenang Fashion Vendor</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full antialiased font-sans text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false, profileOpen: false, notifOpen: false }">

    <div class="min-h-full flex flex-col lg:flex-row">
        
        <!-- Mobile Sidebar Backdrop -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- ============================================== -->
        <!-- SIDEBAR NAVIGATION                             -->
        <!-- ============================================== -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shrink-0 shadow-xl lg:shadow-none"
        >
            <!-- Brand & Logo -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-cyan-400 flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        T
                    </div>
                    <div>
                        <span class="text-base font-extrabold text-white tracking-tight flex items-center gap-1.5">
                            Tigabenang
                            <span class="text-[10px] font-semibold bg-indigo-500/20 text-indigo-300 px-1.5 py-0.5 rounded-md border border-indigo-500/30">ADMIN</span>
                        </span>
                        <p class="text-[11px] text-slate-400 font-medium">Digital Fashion Vendor</p>
                    </div>
                </a>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
                
                <!-- Group: Menu Utama -->
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>
                    <nav class="space-y-1">
                        <!-- Dashboard -->
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            <span>Dashboard Overview</span>
                        </a>

                        <!-- Pesanan / Permintaan Customer -->
                        <a
                            href="{{ route('admin.pesanan.index') }}"
                            class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.pesanan.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Pesanan & Custom</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">3 Baru</span>
                        </a>
                    </nav>
                </div>

                <!-- Group: Katalog & Produk -->
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Katalog & Fitting</p>
                    <nav class="space-y-1">
                        <!-- Kategori Produk -->
                        <a
                            href="{{ route('admin.kategori.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.kategori.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span>Kategori Produk</span>
                        </a>

                        <!-- Katalog Pakaian -->
                        <a
                            href="{{ route('admin.produk.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.produk.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span>Katalog Pakaian</span>
                        </a>

                        <!-- Matriks Ukuran (Size Guide) -->
                        <a
                            href="{{ route('admin.ukuran.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.ukuran.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                            <span>Matriks Ukuran (cm)</span>
                        </a>

                        <!-- Model 3D Fitting Assets -->
                        <a
                            href="{{ route('admin.model-3d.index') }}"
                            class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.model-3d.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>Aset Model 3D (.glb)</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">3D</span>
                        </a>
                    </nav>
                </div>

                <!-- Group: Pengaturan Perusahaan -->
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Vendor & Perusahaan</p>
                    <nav class="space-y-1">
                        <!-- Profil Vendor -->
                        <a
                            href="{{ route('admin.profile.edit') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span>Profil & Visi Misi</span>
                        </a>
                    </nav>
                </div>

            </div>

            <!-- Sidebar Footer / SDG 8 Badge -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
                <div class="bg-slate-800/60 rounded-xl p-3 border border-slate-700/50 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 shrink-0 font-bold text-xs">
                        SDG 8
                    </div>
                    <div class="text-[11px] leading-tight">
                        <p class="font-bold text-slate-200">Decent Work & Growth</p>
                        <p class="text-slate-400 text-[10px]">Digitalisasi UMKM Fashion</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ============================================== -->
        <!-- MAIN CONTENT AREA                              -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
            
            <!-- TOP NAVBAR -->
            <header class="h-20 bg-white border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-8 shadow-xs">
                <!-- Left: Hamburger (Mobile) & Breadcrumb / Title -->
                <div class="flex items-center gap-4">
                    <button
                        @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <span>Admin</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="text-indigo-600">@yield('title', 'Dashboard')</span>
                        </div>
                        <h1 class="text-lg font-bold text-slate-900">@yield('page-title', 'Overview')</h1>
                    </div>
                </div>

                <!-- Right: Quick Search, Notifications, Profile Dropdown -->
                <div class="flex items-center gap-3">
                    
                    <!-- Quick Search Shortcut -->
                    <div class="hidden md:flex items-center relative">
                        <input
                            type="text"
                            placeholder="Cari pesanan, produk..."
                            class="pl-9 pr-4 py-2 text-xs bg-slate-100/80 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all w-52 focus:w-64"
                        />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Notification Button with Badge -->
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button
                            @click="notifOpen = !notifOpen"
                            class="p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 relative transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div
                            x-show="notifOpen"
                            @click.away="notifOpen = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            style="display: none;"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-200/80 p-4 z-50"
                        >
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <h4 class="text-xs font-bold text-slate-900 uppercase">Notifikasi Pesanan</h4>
                                <span class="text-[11px] text-indigo-600 font-semibold">3 Baru</span>
                            </div>
                            <div class="py-2 divide-y divide-slate-100 text-xs">
                                <div class="py-2.5">
                                    <p class="font-semibold text-slate-800">Pesanan Custom #TB-9021</p>
                                    <p class="text-slate-500 text-[11px]">50 pcs Jaket Coach Taslan - Ahmad Fauzi</p>
                                    <span class="text-[10px] text-slate-400 mt-1 inline-block">10 menit yang lalu</span>
                                </div>
                                <div class="py-2.5">
                                    <p class="font-semibold text-slate-800">Pesanan Baru #TB-9020</p>
                                    <p class="text-slate-500 text-[11px]">100 pcs Kaos Combed 24s - Komunitas Vespa</p>
                                    <span class="text-[10px] text-slate-400 mt-1 inline-block">1 jam yang lalu</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.pesanan.index') }}" class="block text-center text-xs text-indigo-600 font-semibold pt-2 border-t border-slate-100 hover:underline">Lihat Semua Pesanan</a>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button
                            @click="profileOpen = !profileOpen"
                            class="flex items-center gap-3 p-1.5 pl-2.5 rounded-2xl hover:bg-slate-100 transition-colors border border-slate-200/60"
                        >
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-slate-800 leading-tight">Gibral (Admin)</p>
                                <p class="text-[11px] text-slate-400 leading-tight">Vendor Tigabenang</p>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-800 text-white font-bold text-sm flex items-center justify-center shadow-xs">
                                G
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            x-show="profileOpen"
                            @click.away="profileOpen = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            style="display: none;"
                            class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-200/80 p-2 z-50"
                        >
                            <div class="px-3 py-2 border-b border-slate-100 mb-1">
                                <p class="text-xs font-bold text-slate-900">Gibral (Super Admin)</p>
                                <p class="text-[11px] text-slate-500 truncate">admin@tigabenang.com</p>
                            </div>
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-xl">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil Vendor
                            </a>
                            <a href="{{ route('admin.model-3d.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 rounded-xl">
                                <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Aset 3D Fitting
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar (Logout)
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- MAIN BODY CONTENT -->
            <main class="flex-1 p-4 sm:p-8">
                <!-- Flash Notification Banner -->
                @include('layouts.partials.flash')

                <!-- Page Content -->
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="px-8 py-4 bg-white border-t border-slate-200/80 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>&copy; {{ date('Y') }} <span class="font-bold text-slate-700">Tigabenang</span> - Vendor Pakaian & Konveksi Digital. Mendukung SDG 8.</p>
                <div class="flex items-center gap-4 text-slate-400">
                    <span>Virtual Fitting 3D Engine v1.0</span>
                    <span>•</span>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Bantuan Admin</a>
                </div>
            </footer>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
