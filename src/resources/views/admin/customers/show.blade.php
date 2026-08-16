@extends('layouts.admin')

@section('title', 'Customer - ' . $customer['name'])

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & BACK LINK                      -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase font-mono tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Customers</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">{{ $customer['name'] }}</h1>
                <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                    ● ACTIVE CLIENT
                </span>
            </div>
            <p class="text-xs text-[#78716C] mt-0.5">
                {{ $customer['company'] }}
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.customers.index') }}"
                class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Back to Directory
            </a>
            <a
                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer['phone']) }}"
                target="_blank"
                class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-2"
            >
                <span>Contact via WhatsApp</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. MAIN CONTENT (2/3 & 1/3 COLUMNS)            -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- LEFT COLUMN (2/3): Order History & Delivery Address -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Order History Table Card -->
            <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
                <div class="p-6 border-b border-[#EADACE]/70">
                    <h2 class="text-base font-medium text-[#1C1917]">Order History</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Custom apparel production orders placed by this customer.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                                <th class="px-6 py-3">ORDER CODE</th>
                                <th class="px-6 py-3">PRODUCT</th>
                                <th class="px-6 py-3 text-center">QTY</th>
                                <th class="px-6 py-3">TOTAL</th>
                                <th class="px-6 py-3">STATUS</th>
                                <th class="px-6 py-3 text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EADACE]/60">
                            @foreach ($customer['orders'] as $ord)
                                <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        <a href="{{ route('admin.pesanan.show', $ord['id']) }}" class="font-mono font-bold text-[#B85331] hover:underline">
                                            {{ $ord['order_code'] }}
                                        </a>
                                        <span class="text-[10px] font-mono text-[#9E9084] block">{{ $ord['date'] }}</span>
                                    </td>
                                    <td class="px-6 py-3.5 font-medium text-[#1C1917]">
                                        {{ $ord['product'] }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center font-mono text-[#1C1917]">
                                        {{ $ord['qty'] }} pcs
                                    </td>
                                    <td class="px-6 py-3.5 font-mono text-[#1C1917]">
                                        {{ $ord['total'] }}
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        @if ($ord['status'] === 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[9px] font-mono font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                ● COMPLETED
                                            </span>
                                        @elseif ($ord['status'] === 'in_production')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[9px] font-mono font-bold uppercase tracking-wider bg-indigo-50 text-indigo-800 border border-indigo-200">
                                                ● IN PRODUCTION
                                            </span>
                                        @elseif ($ord['status'] === 'confirmed')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[9px] font-mono font-bold uppercase tracking-wider bg-sky-50 text-sky-800 border border-sky-200">
                                                ● CONFIRMED
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[9px] font-mono font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                                ● PENDING
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.pesanan.show', $ord['id']) }}" class="text-xs font-mono font-medium text-[#B85331] hover:underline uppercase">
                                            View &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Shipping Destination Card -->
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-3">
                <h2 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    PRIMARY DELIVERY DESTINATION
                </h2>
                <p class="text-sm text-[#1C1917] leading-relaxed">
                    {{ $customer['address'] }}
                </p>
            </div>

        </div>

        <!-- RIGHT COLUMN (1/3): Summary & Contact Profile -->
        <div class="space-y-8">
            
            <!-- Summary Stats Card -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Customer Overview</h2>

                <div class="space-y-3 text-xs divide-y divide-[#EADACE]/60 font-mono">
                    <div class="flex justify-between py-2">
                        <span class="text-[#78716C]">Total Orders:</span>
                        <span class="font-bold text-[#1C1917]">{{ $customer['total_orders'] }} orders</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#78716C]">Total Spend:</span>
                        <span class="font-bold text-[#B85331]">{{ $customer['total_spent'] }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-[#78716C]">Last Order:</span>
                        <span class="text-[#1C1917]">{{ $customer['last_order_date'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Contact Coordinates</h2>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-0.5">PHONE NUMBER</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer['phone']) }}" target="_blank" class="font-mono font-semibold text-emerald-700 hover:underline">
                            {{ $customer['phone'] }}
                        </a>
                    </div>

                    <div class="pt-2 border-t border-[#EADACE]/60">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-0.5">EMAIL</span>
                        <span class="font-mono text-[#292524]">{{ $customer['email'] }}</span>
                    </div>

                    <div class="pt-2 border-t border-[#EADACE]/60">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-0.5">COMPANY / ENTITY</span>
                        <span class="text-[#292524]">{{ $customer['company'] }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
