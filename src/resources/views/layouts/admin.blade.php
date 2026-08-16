<!DOCTYPE html>
<html lang="id" class="h-full bg-[#FAF7F2]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Tigabenang Vendor Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full antialiased font-sans text-[#292524] bg-[#FAF7F2] selection:bg-[#B85331] selection:text-white overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- App Container (Fixed Full-Height Viewport) -->
    <div class="h-screen w-full flex overflow-hidden bg-[#FAF7F2]">
        
        <!-- Mobile Sidebar Backdrop -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-stone-900/60 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- ============================================== -->
        <!-- FIXED SIDEBAR NAVIGATION (Pinned In Place)     -->
        <!-- ============================================== -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-64 h-full bg-[#FAF7F2] border-r border-[#EADACE] flex flex-col justify-between transition-transform duration-200 ease-in-out lg:static lg:translate-x-0 shrink-0 shadow-lg lg:shadow-none select-none"
        >
            <div class="flex-1 flex flex-col min-h-0">
                <!-- Brand Header (Pinned top) -->
                <div class="shrink-0 p-6 pb-5 flex items-start justify-between border-b border-[#EADACE]/70 bg-[#FAF7F2]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#EFE7DE] border border-[#E0D0C2] overflow-hidden flex items-center justify-center shrink-0">
                            <!-- Monogram Icon -->
                            <svg class="w-6 h-6 text-[#B85331]" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M14 14c0-4.4 3.6-8 8-8s8 3.6 8 8c0 7-16 9-16 18 0 4.4 3.6 8 8 8s8-3.6 8-8" stroke="currentColor"/>
                                <path d="M26 14v20" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-base font-bold text-[#B85331] leading-tight">Vendor Portal</h1>
                            <p class="text-[9px] font-mono font-semibold tracking-widest text-[#8C7E72] uppercase">TIGABENANG SUITE</p>
                        </div>
                    </div>

                    <!-- Mobile Close -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-[#8C7E72] hover:text-[#292524] p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Groups (Independent Scrollbar if needed) -->
                <div class="flex-1 px-4 py-5 space-y-6 overflow-y-auto">
                    
                    <!-- Dashboard Main Nav -->
                    <div>
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 text-xs font-semibold tracking-wide transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#B85331] text-white shadow-xs' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>

                    <!-- CATALOG -->
                    <div>
                        <p class="px-3.5 text-[10px] font-mono font-bold tracking-widest text-[#9E9084] uppercase mb-1.5">Catalog</p>
                        <nav class="space-y-0.5">
                            <!-- Products -->
                            <a
                                href="{{ route('admin.produk.index') }}"
                                class="flex items-center gap-3 px-3.5 py-2 text-xs font-medium transition-all {{ request()->routeIs('admin.produk.*') ? 'bg-[#B85331] text-white font-semibold' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Products</span>
                            </a>

                            <!-- Materials -->
                            <a
                                href="{{ route('admin.kategori.index') }}"
                                class="flex items-center gap-3 px-3.5 py-2 text-xs font-medium transition-all {{ request()->routeIs('admin.kategori.*') ? 'bg-[#B85331] text-white font-semibold' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span>Materials & Categories</span>
                            </a>

                            <!-- Size Charts -->
                            <a
                                href="{{ route('admin.ukuran.index') }}"
                                class="flex items-center gap-3 px-3.5 py-2 text-xs font-medium transition-all {{ request()->routeIs('admin.ukuran.*') ? 'bg-[#B85331] text-white font-semibold' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                <span>Size Charts</span>
                            </a>

                            <!-- 3D Models -->
                            <a
                                href="{{ route('admin.model-3d.index') }}"
                                class="flex items-center gap-3 px-3.5 py-2 text-xs font-medium transition-all {{ request()->routeIs('admin.model-3d.*') ? 'bg-[#B85331] text-white font-semibold' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>3D Models</span>
                            </a>
                        </nav>
                    </div>

                    <!-- OPERATIONS -->
                    <div>
                        <p class="px-3.5 text-[10px] font-mono font-bold tracking-widest text-[#9E9084] uppercase mb-1.5">Operations</p>
                        <nav class="space-y-0.5">
                            <a
                                href="{{ route('admin.pesanan.index') }}"
                                class="flex items-center justify-between px-3.5 py-2 text-xs font-medium transition-all {{ request()->routeIs('admin.pesanan.*') ? 'bg-[#B85331] text-white font-semibold' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <span>Orders</span>
                                </div>
                                <span class="text-[9px] font-mono font-bold px-1.5 py-0.5 bg-[#EFE7DE] text-[#8C7E72]">18</span>
                            </a>
                        </nav>
                    </div>

                    <!-- SYSTEM -->
                    <div>
                        <p class="px-3.5 text-[10px] font-mono font-bold tracking-widest text-[#9E9084] uppercase mb-1.5">System</p>
                        <nav class="space-y-0.5">
                            <a
                                href="{{ route('admin.profile.edit') }}"
                                class="flex items-center gap-3 px-3.5 py-2 text-xs font-medium transition-all {{ request()->routeIs('admin.profile.*') ? 'bg-[#B85331] text-white font-semibold' : 'text-[#574E46] hover:bg-[#F2ECE3] hover:text-[#292524]' }}"
                            >
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Settings</span>
                            </a>
                        </nav>
                    </div>

                </div>
            </div>

            <!-- Bottom Actions: New Product Button & User Profile (Pinned bottom) -->
            <div class="shrink-0 p-4 border-t border-[#EADACE]/70 space-y-3 bg-[#FAF7F2]">
                <!-- New Product Button -->
                <a
                    href="{{ route('admin.produk.create') }}"
                    class="block w-full py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-medium text-center tracking-wide transition-all shadow-xs"
                >
                    New Product
                </a>

                <!-- User Profile Bar -->
                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2.5 group">
                        <div class="w-8 h-8 rounded-full bg-[#EFE7DE] border border-[#E0D0C2] flex items-center justify-center text-xs font-bold text-[#B85331]">
                            G
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-[#292524] group-hover:text-[#B85331] transition-colors leading-tight">Vendor Profile</p>
                            <p class="text-[10px] text-[#8C7E72] leading-tight">Tigabenang</p>
                        </div>
                    </a>

                    <a href="{{ route('login') }}" title="Logout" class="text-[#8C7E72] hover:text-[#B85331] p-1.5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- ============================================== -->
        <!-- MAIN VIEWPORT AREA (Scrolls Independently)    -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col h-full overflow-y-auto min-w-0 bg-[#FAF7F2]">
            
            <!-- Mobile Header Topbar -->
            <div class="lg:hidden shrink-0 h-14 bg-white border-b border-[#EADACE] px-4 flex items-center justify-between">
                <button @click="sidebarOpen = true" class="p-2 text-stone-700 hover:text-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <span class="text-xs font-mono font-bold tracking-widest text-[#B85331] uppercase">TIGABENANG VENDOR</span>
                <a href="{{ route('admin.profile.edit') }}" class="w-7 h-7 rounded-full bg-[#EFE7DE] text-[#B85331] flex items-center justify-center text-xs font-bold">G</a>
            </div>

            <!-- Main Body Content -->
            <main class="flex-1 p-6 sm:p-10 max-w-7xl w-full mx-auto">
                @include('layouts.partials.flash')
                @yield('content')
            </main>

            <!-- Bottom Minimal Footer -->
            <footer class="shrink-0 px-10 py-6 border-t border-[#EADACE]/50 text-xs text-[#9E9084] flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Tigabenang. All rights reserved.</p>
                <div class="flex items-center gap-6 text-xs text-[#9E9084]">
                    <a href="#" class="hover:text-[#292524] transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-[#292524] transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-[#292524] transition-colors">Support</a>
                </div>
            </footer>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
