@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-white rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Atelier Operations Live
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Dashboard Overview</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Monitor pesanan custom, antrean produksi, inventori katalog, dan performa atelier.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                type="button"
                onclick="alert('Laporan data pesanan & inventori siap diekspor.')"
                class="btn-cream-pill px-5 py-2.5 text-xs tracking-wide uppercase gap-2 cursor-pointer shadow-xs"
            >
                <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Export Report</span>
            </button>

            <a
                href="{{ route('admin.produk.create') }}"
                class="btn-navy-pill px-6 py-2.5 text-xs tracking-wide uppercase gap-2 shadow-md cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>+ New Product</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. SUMMARY CARDS (4 Columns)                   -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: TOTAL ORDERS -->
        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    TOTAL ORDERS
                </span>
                <div class="w-10 h-10 rounded-xl bg-[#172A39] text-[#FAF8F5] flex items-center justify-center shadow-md shadow-[#172A39]/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight">{{ $summary['total_orders']['count'] }}</h3>
                <p class="text-xs text-[#555E68] mt-1 font-semibold">{{ $summary['total_orders']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 2: PENDING ORDERS -->
        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    PENDING ORDERS
                </span>
                <div class="w-10 h-10 rounded-xl bg-[#172A39] text-[#FAF8F5] flex items-center justify-center shadow-md shadow-[#172A39]/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 022 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight">{{ $summary['pending_orders']['count'] }}</h3>
                <p class="text-xs text-[#555E68] mt-1 font-semibold">{{ $summary['pending_orders']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 3: WAITING PRICE -->
        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    WAITING PRICE
                </span>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 border border-amber-300 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight">{{ $summary['waiting_price']['count'] }}</h3>
                <p class="text-xs text-[#555E68] mt-1 font-semibold">{{ $summary['waiting_price']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 4: CONFIRMED ORDERS -->
        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    CONFIRMED ORDERS
                </span>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-900 border border-emerald-300 flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight">{{ $summary['confirmed_orders']['count'] }}</h3>
                <p class="text-xs text-[#555E68] mt-1 font-semibold">{{ $summary['confirmed_orders']['subtitle'] }}</p>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. MAIN DASHBOARD CONTENT GRID                 -->
    <!-- ============================================== -->
    <div class="space-y-8">
        
        <!-- FIRST ROW: 2-COLUMN GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            
            <!-- Card 1 (2/3 Width): Orders Needing Action -->
            <div class="lg:col-span-2 admin-card-rich overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="p-5 border-b border-[#DCD6D0] bg-[#FAF8F5] flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#172A39]"></span>
                            <h2 class="text-sm sm:text-base font-black text-[#172A39]">Orders Needing Action (Penetapan Harga)</h2>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black tracking-wider uppercase">
                                    <th class="px-6 py-3.5">ORDER ID</th>
                                    <th class="px-6 py-3.5">CUSTOMER</th>
                                    <th class="px-6 py-3.5">PRODUCT</th>
                                    <th class="px-6 py-3.5">STATUS</th>
                                    <th class="px-6 py-3.5 text-right">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#DCD6D0] bg-white">
                                @forelse ($ordersNeedingAction as $order)
                                    <tr class="admin-table-row">
                                        <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap">
                                            #ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap">
                                            {{ $order->nama }}
                                        </td>
                                        <td class="px-6 py-4 text-[#555E68] whitespace-nowrap font-bold">
                                            {{ $order->produk ? $order->produk->nama_produk : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-[10px] font-black tracking-wider uppercase bg-amber-100 text-amber-900 border border-amber-300 rounded-full">
                                                WAITING PRICE
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                            <div class="relative inline-block text-left">
                                                <button
                                                    type="button"
                                                    @click="menuOpen = !menuOpen"
                                                    class="p-2 text-[#172A39] hover:bg-[#FAF8F5] rounded-xl border border-[#DCD6D0] hover:border-[#172A39] transition-all focus:outline-none cursor-pointer shadow-2xs"
                                                    title="Actions"
                                                >
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="5" r="2"></circle>
                                                        <circle cx="12" cy="12" r="2"></circle>
                                                        <circle cx="12" cy="19" r="2"></circle>
                                                    </svg>
                                                </button>

                                                <div
                                                    x-show="menuOpen"
                                                    @click.away="menuOpen = false"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="absolute right-0 mt-2 w-52 bg-white border-1.5 border-[#DCD6D0] rounded-2xl shadow-2xl py-2 z-30 text-left"
                                                    style="display: none;"
                                                >
                                                    <a
                                                        href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}"
                                                        class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-[#172A39] hover:bg-[#FAF8F5] transition-colors font-bold text-decoration-none"
                                                    >
                                                        <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        <span>Set Price / Detail</span>
                                                    </a>
                                                    <a
                                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->no_hp) }}"
                                                        target="_blank"
                                                        class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-emerald-700 hover:bg-emerald-50 transition-colors font-bold text-decoration-none"
                                                    >
                                                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                                                        </svg>
                                                        <span>Chat via WhatsApp</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-[#6E7575] font-medium">
                                            Tidak ada pesanan yang memerlukan penetapan harga.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card 2 (1/3 Width): Product Overview -->
            <div class="lg:col-span-1 admin-card-rich p-6 flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-[#DCD6D0] pb-4">
                        <h2 class="text-base font-black text-[#172A39]">Product Overview</h2>
                        <div class="w-9 h-9 rounded-xl bg-[#172A39] text-white flex items-center justify-center shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-[#FAF8F5] border border-[#DCD6D0] rounded-2xl p-4">
                            <h3 class="text-3xl font-black text-[#172A39] tracking-tight">{{ $productOverview['total_products'] }}</h3>
                            <span class="text-[10px] font-black tracking-widest text-[#6E7575] uppercase block mt-1">
                                TOTAL PRODUCTS
                            </span>
                        </div>
                        <div class="bg-[#FAF8F5] border border-[#DCD6D0] rounded-2xl p-4">
                            <h3 class="text-3xl font-black text-[#172A39] tracking-tight">{{ $productOverview['models_3d_linked'] }}</h3>
                            <span class="text-[10px] font-black tracking-widest text-[#6E7575] uppercase block mt-1">
                                3D MODELS LINKED
                            </span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#DCD6D0] flex items-center justify-end text-xs mt-6">
                    <a href="{{ route('admin.produk.index') }}" class="btn-navy-pill px-5 py-2 text-xs uppercase tracking-wider">
                        View Products &rarr;
                    </a>
                </div>
            </div>

        </div>

        <!-- SECOND ROW: FULL WIDTH CARD (Recent Orders) -->
        <div class="admin-card-rich overflow-hidden">
            <div class="p-5 border-b border-[#DCD6D0] bg-[#FAF8F5] flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#172A39]"></span>
                    <h2 class="text-base font-black text-[#172A39]">Recent Orders</h2>
                </div>
                <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#172A39] hover:underline font-black transition-colors">
                    View All Orders &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black tracking-wider uppercase">
                            <th class="px-6 py-3.5">ORDER ID</th>
                            <th class="px-6 py-3.5">CUSTOMER</th>
                            <th class="px-6 py-3.5">PRODUCT</th>
                            <th class="px-6 py-3.5">TOTAL HARGA</th>
                            <th class="px-6 py-3.5">STATUS</th>
                            <th class="px-6 py-3.5 text-right">DATE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#DCD6D0] bg-white">
                        @forelse ($recentOrders as $order)
                            <tr class="admin-table-row">
                                <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap">
                                    #ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap">
                                    {{ $order->nama }}
                                </td>
                                <td class="px-6 py-4 text-[#555E68] whitespace-nowrap font-bold">
                                    {{ $order->produk ? $order->produk->nama_produk : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-black text-[#172A39]">
                                    {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Waiting Price' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($order->total_harga)
                                        <span class="px-3 py-1 text-[10px] font-black tracking-wider uppercase bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-full">
                                            CONFIRMED
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-[10px] font-black tracking-wider uppercase bg-amber-100 text-amber-900 border border-amber-300 rounded-full">
                                            WAITING PRICE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-[#555E68] font-bold whitespace-nowrap">
                                    {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-[#6E7575] font-medium">
                                    Belum ada pesanan terbaru di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
