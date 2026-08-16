@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">

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
                class="px-4 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-medium tracking-wide transition-colors flex items-center gap-2 cursor-pointer"
            >
                <svg class="w-3.5 h-3.5 text-[#786C62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Export Report</span>
            </button>

            <a
                href="{{ route('admin.produk.create') }}"
                class="px-4 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-medium tracking-wide transition-all shadow-xs flex items-center gap-2"
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
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight">{{ $summary['total_orders']['count'] }}</h3>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight">{{ $summary['pending_orders']['count'] }}</h3>
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
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight">{{ $summary['waiting_price']['count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">{{ $summary['waiting_price']['subtitle'] }}</p>
            </div>
        </div>

        <!-- Card 4: LOW STOCK -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    LOW STOCK
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight">{{ $summary['low_stock']['count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">{{ $summary['low_stock']['subtitle'] }}</p>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. MAIN DASHBOARD CONTENT (Two-Column Layout)  -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- ========================================== -->
        <!-- LEFT COLUMN (2/3): ORDERS                  -->
        <!-- ========================================== -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Card 1: Orders Needing Action -->
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
                <div class="p-6 border-b border-[#EADACE]/70">
                    <h2 class="text-base font-medium text-[#1C1917]">Orders Needing Action</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/50 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                                <th class="px-6 py-3">ORDER ID</th>
                                <th class="px-6 py-3">CUSTOMER</th>
                                <th class="px-6 py-3">PRODUCT</th>
                                <th class="px-6 py-3">STATUS</th>
                                <th class="px-6 py-3 text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EADACE]/60">
                            @foreach ($ordersNeedingAction as $order)
                                <tr class="hover:bg-[#FAF7F2]/60 transition-colors">
                                    <td class="px-6 py-4 font-mono font-medium text-[#292524] whitespace-nowrap">
                                        {{ $order['order_code'] }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-[#1C1917] whitespace-nowrap">
                                        {{ $order['customer_name'] }}
                                    </td>
                                    <td class="px-6 py-4 text-[#574E46] whitespace-nowrap">
                                        {{ $order['product_name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($order['status'] === 'Waiting Price')
                                            <span class="px-2 py-0.5 text-[10px] font-mono bg-[#EFE7DE] text-[#786C62] rounded-none">
                                                Waiting Price
                                            </span>
                                        @elseif ($order['status'] === 'New')
                                            <span class="px-2 py-0.5 text-[10px] font-mono bg-[#EFE7DE] text-[#786C62] rounded-none">
                                                New
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-mono bg-[#EFE7DE] text-[#786C62] rounded-none">
                                                {{ $order['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a
                                            href="{{ $order['route'] }}"
                                            class="{{ in_array($order['action_label'], ['Set Price', 'Review']) ? 'text-[#B85331] font-medium hover:underline' : 'text-[#78716C] hover:text-[#292524]' }} text-xs transition-colors"
                                        >
                                            {{ $order['action_label'] }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card 2: Recent Orders -->
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
                <div class="p-6 border-b border-[#EADACE]/70 flex items-center justify-between">
                    <h2 class="text-base font-medium text-[#1C1917]">Recent Orders</h2>
                    <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] transition-colors">
                        View All Orders
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/50 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                                <th class="px-6 py-3">ORDER ID</th>
                                <th class="px-6 py-3">CUSTOMER</th>
                                <th class="px-6 py-3">PRODUCT</th>
                                <th class="px-6 py-3">FINAL PRICE</th>
                                <th class="px-6 py-3">STATUS</th>
                                <th class="px-6 py-3 text-right">DATE</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EADACE]/60">
                            @foreach ($recentOrders as $order)
                                <tr class="hover:bg-[#FAF7F2]/60 transition-colors">
                                    <td class="px-6 py-4 font-mono font-medium text-[#292524] whitespace-nowrap">
                                        {{ $order['order_code'] }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-[#1C1917] whitespace-nowrap">
                                        {{ $order['customer_name'] }}
                                    </td>
                                    <td class="px-6 py-4 text-[#574E46] whitespace-nowrap">
                                        {{ $order['product_name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium {{ $order['is_waiting_price'] ? 'text-[#78716C] italic' : 'text-[#1C1917]' }}">
                                        {{ $order['final_price'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[#574E46]">
                                        {{ $order['status'] }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-[#78716C] whitespace-nowrap">
                                        {{ $order['date'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN (1/3): WIDGETS & INVENTORY    -->
        <!-- ========================================== -->
        <div class="space-y-8">
            
            <!-- Widget 1: Material Alerts -->
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] p-6">
                <h2 class="text-base font-medium text-[#1C1917] mb-5">Material Alerts</h2>

                <div class="space-y-4">
                    @foreach ($materialAlerts as $mat)
                        <div class="p-4 border border-[#EADACE]/70 bg-[#FAF7F2]/30 space-y-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-[#1C1917]">{{ $mat['name'] }}</h3>
                                @if ($mat['is_low_stock'])
                                    <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#F7DDD2] text-[#B85331] rounded-none">
                                        LOW STOCK
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 text-[9px] font-mono font-bold tracking-wider uppercase bg-[#EFE7DE] text-[#786C62] rounded-none">
                                        IN STOCK
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">AVAILABLE</span>
                                    <span class="text-base font-normal text-[#1C1917] mt-0.5 block">{{ $mat['available_stock'] }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">REORDER AT</span>
                                    <span class="text-base font-normal text-[#1C1917] mt-0.5 block">{{ $mat['reorder_level'] }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-[#EADACE]/50">
                                <a href="{{ route('admin.kategori.index') }}" class="text-xs text-[#B85331] hover:underline font-medium">
                                    View Material
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Widget 2: Product Overview -->
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-medium text-[#1C1917]">Product Overview</h2>
                    <svg class="w-4 h-4 text-[#786C62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <h3 class="text-2xl font-normal text-[#1C1917] tracking-tight">{{ $productOverview['total_products'] }}</h3>
                        <span class="text-[10px] font-mono font-medium tracking-widest text-[#9E9084] uppercase block mt-1">
                            TOTAL PRODUCTS
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-normal text-[#1C1917] tracking-tight">{{ $productOverview['models_3d_linked'] }}</h3>
                        <span class="text-[10px] font-mono font-medium tracking-widest text-[#9E9084] uppercase block mt-1">
                            3D MODELS LINKED
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#EADACE]/70 flex items-center justify-between text-xs">
                    <span class="text-[#B85331] font-medium">{{ $productOverview['incomplete_products'] }} Incomplete Products</span>
                    <a href="{{ route('admin.produk.index') }}" class="text-[#78716C] hover:text-[#B85331] transition-colors font-medium">
                        View Products
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
