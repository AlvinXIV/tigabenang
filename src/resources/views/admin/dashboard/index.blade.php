@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Dashboard Overview</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Monitor orders, inventory, products, and business activity.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                type="button"
                onclick="alert('Laporan data pesanan & inventori siap diekspor.')"
                class="px-4 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors flex items-center gap-2 cursor-pointer"
            >
                <svg class="w-3.5 h-3.5 text-[#786C62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Export Report</span>
            </button>

            <a
                href="{{ route('admin.produk.create') }}"
                class="px-4 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-2"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Product</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. SUMMARY CARDS (4 Columns)                   -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: TOTAL ORDERS -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    TOTAL ORDERS
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $summary['total_orders']['count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">{{ $summary['total_orders']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 2: PENDING ORDERS -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    PENDING ORDERS
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 022 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $summary['pending_orders']['count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">{{ $summary['pending_orders']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 3: WAITING PRICE -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    WAITING PRICE
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $summary['waiting_price']['count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">{{ $summary['waiting_price']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 4: CONFIRMED ORDERS -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    CONFIRMED ORDERS
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $summary['confirmed_orders']['count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">{{ $summary['confirmed_orders']['subtitle'] }}</p>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. MAIN DASHBOARD CONTENT GRID                 -->
    <!-- ============================================== -->
    <div class="space-y-8">
        
        <!-- FIRST ROW: 2-COLUMN GRID (EQUAL HEIGHT STRETCH) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            
            <!-- Card 1 (2/3 Width): Orders Needing Action -->
            <div class="lg:col-span-2 bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-[#EADACE]/70">
                        <h2 class="text-base font-medium text-[#1C1917]">Orders Needing Action (Penetapan Harga)</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                                    <th class="px-6 py-3.5">ORDER ID</th>
                                    <th class="px-6 py-3.5">CUSTOMER</th>
                                    <th class="px-6 py-3.5">PRODUCT</th>
                                    <th class="px-6 py-3.5">STATUS</th>
                                    <th class="px-6 py-3.5 text-right">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EADACE]/60">
                                @forelse ($ordersNeedingAction as $order)
                                    <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                                        <td class="px-6 py-4 font-mono font-bold text-[#1C1917] whitespace-nowrap">
                                            #ORD-{{ $order->id_pemesanan }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-[#1C1917] whitespace-nowrap">
                                            {{ $order->nama }}
                                        </td>
                                        <td class="px-6 py-4 text-[#574E46] whitespace-nowrap">
                                            {{ $order->produk ? $order->produk->nama_produk : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-[#F7DDD2] text-[#B85331] border border-[#F7DDD2]">
                                                WAITING PRICE
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                            <div class="relative inline-block text-left">
                                                <button
                                                    type="button"
                                                    @click="menuOpen = !menuOpen"
                                                    class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] border border-transparent hover:border-[#EADACE] transition-colors focus:outline-none cursor-pointer"
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
                                                    class="absolute right-0 mt-1 w-44 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                                    style="display: none;"
                                                >
                                                    <div class="py-0.5">
                                                        <a
                                                            href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}"
                                                            class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                                        >
                                                            <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                            <span>Set Price / Detail</span>
                                                        </a>
                                                        <a
                                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->no_hp) }}"
                                                            target="_blank"
                                                            class="flex items-center gap-2 px-3.5 py-2 text-xs text-emerald-800 hover:bg-emerald-50 transition-colors font-medium"
                                                        >
                                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                            </svg>
                                                            <span>Chat via WhatsApp</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-[#78716C]">
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
            <div class="lg:col-span-1 bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] p-6 flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-medium text-[#1C1917]">Product Overview</h2>
                        <svg class="w-4 h-4 text-[#786C62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div>
                            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $productOverview['total_products'] }}</h3>
                            <span class="text-[10px] font-mono font-medium tracking-widest text-[#9E9084] uppercase block mt-1">
                                TOTAL PRODUCTS
                            </span>
                        </div>
                        <div>
                            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono">{{ $productOverview['models_3d_linked'] }}</h3>
                            <span class="text-[10px] font-mono font-medium tracking-widest text-[#9E9084] uppercase block mt-1">
                                3D MODELS LINKED
                            </span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#EADACE]/70 flex items-center justify-end text-xs mt-6">
                    <a href="{{ route('admin.produk.index') }}" class="text-[#B85331] hover:underline font-medium">
                        View Products &rarr;
                    </a>
                </div>
            </div>

        </div>

        <!-- SECOND ROW: FULL WIDTH CARD (Recent Orders) -->
        <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <div class="p-6 border-b border-[#EADACE]/70 flex items-center justify-between">
                <h2 class="text-base font-medium text-[#1C1917]">Recent Orders</h2>
                <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium transition-colors">
                    View All Orders &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                            <th class="px-6 py-3.5">ORDER ID</th>
                            <th class="px-6 py-3.5">CUSTOMER</th>
                            <th class="px-6 py-3.5">PRODUCT</th>
                            <th class="px-6 py-3.5">TOTAL HARGA</th>
                            <th class="px-6 py-3.5">STATUS</th>
                            <th class="px-6 py-3.5 text-right">DATE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADACE]/60">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-[#1C1917] whitespace-nowrap">
                                    #ORD-{{ $order->id_pemesanan }}
                                </td>
                                <td class="px-6 py-4 font-medium text-[#1C1917] whitespace-nowrap">
                                    {{ $order->nama }}
                                </td>
                                <td class="px-6 py-4 text-[#574E46] whitespace-nowrap">
                                    {{ $order->produk ? $order->produk->nama_produk : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono font-medium {{ $order->total_harga ? 'text-[#1C1917]' : 'text-[#78716C] italic' }}">
                                    {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Waiting Price' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($order->total_harga)
                                        <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            CONFIRMED
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-[#F7DDD2] text-[#B85331] border border-[#F7DDD2]">
                                            WAITING PRICE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-[#78716C] font-mono whitespace-nowrap">
                                    {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-[#78716C]">
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
