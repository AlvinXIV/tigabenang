@extends('layouts.admin')

@section('title', 'Order ' . $order['order_code'])

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase font-mono tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Orders</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Order {{ $order['order_code'] }}</h1>
                @if ($order['status'] === 'pending')
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                        ● PENDING REVIEW
                    </span>
                @elseif ($order['status'] === 'confirmed')
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-sky-50 text-sky-800 border border-sky-200">
                        ● CONFIRMED
                    </span>
                @elseif ($order['status'] === 'in_production')
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-50 text-indigo-800 border border-indigo-200">
                        ● IN PRODUCTION
                    </span>
                @elseif ($order['status'] === 'completed')
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                        ● COMPLETED
                    </span>
                @else
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-rose-50 text-rose-800 border border-rose-200">
                        ● CANCELLED
                    </span>
                @endif
            </div>
            <p class="text-xs font-mono text-[#78716C] mt-1">
                Placed on {{ $order['created_at'] }}
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a
                href="{{ route('admin.pesanan.index') }}"
                class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors"
            >
                Back
            </a>
            <a
                href="{{ route('admin.orders.invoice', $order['id']) }}"
                class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-2"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>View Invoice</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. ORDER DETAILS & SIDEBAR                     -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- LEFT COLUMN (2/3): Garment Specs & Notes -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Garment Specs Card -->
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                <div class="flex items-start justify-between pb-4 border-b border-[#EADACE]/70">
                    <div>
                        <h2 class="text-lg font-medium text-[#1C1917]">{{ $order['product_name'] }}</h2>
                        <p class="text-xs text-[#78716C] mt-0.5">
                            Category: {{ $order['category'] }} • Color: <span class="text-[#1C1917] font-medium">{{ $order['color'] }}</span>
                        </p>
                    </div>
                    <span class="px-3 py-1 bg-[#FAF7F2] border border-[#EADACE] font-mono text-xs font-semibold text-[#1C1917]">
                        {{ $order['quantity'] }} pcs
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 bg-[#FAF7F2]/60 border border-[#EADACE] space-y-1">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">FABRIC MATERIAL</span>
                        <span class="font-medium text-[#1C1917]">{{ $order['material'] }}</span>
                    </div>
                    <div class="p-4 bg-[#FAF7F2]/60 border border-[#EADACE] space-y-1">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">UNIT PRICE (DEAL)</span>
                        <span class="font-medium font-mono text-[#1C1917]">Rp {{ number_format($order['unit_price'], 0, ',', '.') }} / pcs</span>
                    </div>
                </div>

                <!-- Size Breakdown Matrix -->
                <div class="space-y-3 pt-2">
                    <h3 class="text-xs font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        SIZE BREAKDOWN
                    </h3>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 font-mono">
                        @foreach ($order['size_breakdown'] as $sb)
                            <div class="p-3 bg-[#FAF7F2]/60 border border-[#EADACE] flex items-center justify-between">
                                <span class="px-2 py-0.5 bg-[#B85331] text-white text-xs font-bold">
                                    {{ $sb['size'] }}
                                </span>
                                <span class="text-sm font-semibold text-[#1C1917]">{{ $sb['qty'] }} pcs</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Notes & Design Mockup File Card -->
            <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
                <div>
                    <h2 class="text-base font-medium text-[#1C1917]">Mockup Artwork & Notes</h2>
                    <p class="text-xs text-[#78716C] mt-0.5">Instructions and attached print/embroidery design files.</p>
                </div>

                <div class="p-4 bg-[#FAF7F2] border border-[#EADACE] text-xs text-[#292524] leading-relaxed">
                    <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-1">CLIENT NOTES:</span>
                    "{{ $order['custom_notes'] }}"
                </div>

                <div class="p-4 bg-white border border-[#EADACE] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#FAF7F2] border border-[#D9CCC1] flex items-center justify-center font-mono font-bold text-xs text-[#B85331] shrink-0">
                            PDF
                        </div>
                        <div>
                            <p class="text-xs font-medium text-[#1C1917] font-mono">{{ $order['design_file_name'] }}</p>
                            <span class="text-[10px] text-[#78716C]">Design attachment for screenprint / embroidery (2.4 MB)</span>
                        </div>
                    </div>
                    <a
                        href="{{ $order['design_file'] }}"
                        target="_blank"
                        class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors shrink-0 text-center"
                    >
                        Download File
                    </a>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (1/3): Status Updater & Customer Coordinates -->
        <div class="space-y-8">
            
            <!-- Update Status & Deal Price Form -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Update Order Status</h2>
                
                <form action="{{ route('admin.pesanan.update', $order['id']) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            PRODUCTION STATUS
                        </label>
                        <select
                            name="status"
                            id="status"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs text-[#292524] rounded-none focus:outline-none transition-colors"
                        >
                            <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="confirmed" {{ $order['status'] == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="in_production" {{ $order['status'] == 'in_production' ? 'selected' : '' }}>In Production</option>
                            <option value="completed" {{ $order['status'] == 'completed' ? 'selected' : '' }}>Completed / Shipped</option>
                            <option value="cancelled" {{ $order['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="unit_price" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            UNIT DEAL PRICE (RP)
                        </label>
                        <input
                            type="number"
                            name="unit_price"
                            id="unit_price"
                            value="{{ $order['unit_price'] }}"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs cursor-pointer"
                    >
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Customer Details Card -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Customer Coordinates</h2>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">NAME & INSTITUTION</span>
                        <p class="font-medium text-[#1C1917] text-sm">{{ $order['customer_name'] }}</p>
                        <p class="text-[#78716C]">{{ $order['company_or_institution'] }}</p>
                    </div>

                    <div class="pt-2 border-t border-[#EADACE]/60">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-1">WHATSAPP / PHONE</span>
                        <a
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order['phone']) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 text-emerald-700 font-mono font-semibold hover:underline"
                        >
                            <span>{{ $order['phone'] }}</span>
                            <span class="text-[10px]">&rarr;</span>
                        </a>
                    </div>

                    <div class="pt-2 border-t border-[#EADACE]/60">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">EMAIL ADDRESS</span>
                        <span class="text-[#292524]">{{ $order['email'] }}</span>
                    </div>

                    <div class="pt-2 border-t border-[#EADACE]/60">
                        <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block mb-0.5">SHIPPING DESTINATION</span>
                        <p class="text-[#78716C] leading-relaxed">{{ $order['shipping_address'] }}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
