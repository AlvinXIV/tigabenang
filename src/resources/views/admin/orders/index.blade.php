@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div
    class="space-y-8"
    x-data="{
        searchQuery: '',
        activeTab: 'all',
        orders: {{ json_encode($orders) }},
        
        filteredOrders() {
            return this.orders.filter(o => {
                const matchesTab = (this.activeTab === 'all') || (o.status === this.activeTab);
                const query = this.searchQuery.toLowerCase();
                const matchesSearch = !query || 
                    o.order_code.toLowerCase().includes(query) || 
                    o.customer_name.toLowerCase().includes(query) || 
                    (o.company_or_institution && o.company_or_institution.toLowerCase().includes(query)) ||
                    o.product_name.toLowerCase().includes(query);
                return matchesTab && matchesSearch;
            });
        }
    }"
>

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & NEW ORDER ACTION TOOLBAR       -->
    <!-- ============================================== -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Orders</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Manage custom garment production orders and customer specifications.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-full sm:w-72">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-9 pr-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] transition-colors"
                />
                <svg class="w-4 h-4 text-[#A89A8E] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- New Order Button -->
            <a
                href="{{ route('admin.pesanan.create') }}"
                class="px-4 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-2 cursor-pointer whitespace-nowrap"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Order</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. STATUS FILTER TABS                          -->
    <!-- ============================================== -->
    <div class="flex items-center gap-6 border-b border-[#EADACE]/70 text-xs font-medium overflow-x-auto pb-px">
        <button
            type="button"
            @click="activeTab = 'all'"
            :class="activeTab === 'all' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer whitespace-nowrap"
        >
            All Orders ({{ count($orders) }})
        </button>

        <button
            type="button"
            @click="activeTab = 'pending'"
            :class="activeTab === 'pending' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer whitespace-nowrap"
        >
            Pending Review
        </button>

        <button
            type="button"
            @click="activeTab = 'confirmed'"
            :class="activeTab === 'confirmed' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer whitespace-nowrap"
        >
            Confirmed
        </button>

        <button
            type="button"
            @click="activeTab = 'in_production'"
            :class="activeTab === 'in_production' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer whitespace-nowrap"
        >
            In Production
        </button>

        <button
            type="button"
            @click="activeTab = 'completed'"
            :class="activeTab === 'completed' ? 'border-b-2 border-[#B85331] text-[#1C1917] font-semibold' : 'text-[#78716C] hover:text-[#1C1917] border-b-2 border-transparent'"
            class="pb-3 transition-colors cursor-pointer whitespace-nowrap"
        >
            Completed
        </button>
    </div>

    <!-- ============================================== -->
    <!-- 3. ORDERS TABLE MATRIX                         -->
    <!-- ============================================== -->
    <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">ORDER CODE</th>
                        <th class="px-6 py-3.5">CUSTOMER / INSTITUTION</th>
                        <th class="px-6 py-3.5">PRODUCT & FABRIC</th>
                        <th class="px-6 py-3.5 text-center">QTY</th>
                        <th class="px-6 py-3.5">DEAL PRICE</th>
                        <th class="px-6 py-3.5">STATUS</th>
                        <th class="px-6 py-3.5 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    <template x-for="ord in filteredOrders()" :key="ord.id">
                        <tr class="hover:bg-[#FAF7F2]/50 transition-colors group">
                            
                            <!-- Order Code & Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a :href="'/admin/pesanan/' + ord.id" class="font-mono font-bold text-[#B85331] hover:underline block" x-text="ord.order_code"></a>
                                <span class="text-[10px] text-[#9E9084] font-mono" x-text="ord.created_at"></span>
                            </td>

                            <!-- Customer Info & Phone -->
                            <td class="px-6 py-4">
                                <p class="font-medium text-[#1C1917] text-sm leading-snug" x-text="ord.customer_name"></p>
                                <p class="text-[11px] text-[#78716C]" x-text="ord.company_or_institution"></p>
                                <p class="text-[10px] font-mono text-[#9E9084] mt-0.5" x-text="ord.phone"></p>
                            </td>

                            <!-- Product & Material -->
                            <td class="px-6 py-4">
                                <p class="font-medium text-[#1C1917]" x-text="ord.product_name"></p>
                                <p class="text-[11px] text-[#78716C]" x-text="ord.material"></p>
                                <p class="text-[10px] font-mono text-[#9E9084] mt-0.5" x-text="ord.size_breakdown"></p>
                            </td>

                            <!-- Quantity -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="font-mono font-medium text-[#1C1917]" x-text="ord.quantity + ' pcs'"></span>
                            </td>

                            <!-- Deal Price -->
                            <td class="px-6 py-4 whitespace-nowrap font-mono font-medium text-[#1C1917]">
                                <span x-text="ord.total_price"></span>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <template x-if="ord.status === 'pending'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        PENDING
                                    </span>
                                </template>
                                <template x-if="ord.status === 'confirmed'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-sky-50 text-sky-800 border border-sky-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        CONFIRMED
                                    </span>
                                </template>
                                <template x-if="ord.status === 'in_production'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-indigo-50 text-indigo-800 border border-indigo-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                        IN PRODUCTION
                                    </span>
                                </template>
                                <template x-if="ord.status === 'completed'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        COMPLETED
                                    </span>
                                </template>
                                <template x-if="ord.status === 'cancelled'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold uppercase tracking-wider bg-rose-50 text-rose-800 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        CANCELLED
                                    </span>
                                </template>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-3 font-mono text-xs">
                                    <a
                                        :href="'/admin/pesanan/' + ord.id"
                                        class="text-[#B85331] hover:underline uppercase tracking-wider font-semibold"
                                    >
                                        Details
                                    </a>
                                    <span class="text-[#EADACE]">|</span>
                                    <a
                                        :href="'/admin/pesanan/' + ord.id + '/invoice'"
                                        class="text-[#78716C] hover:text-[#1C1917] hover:underline uppercase tracking-wider"
                                    >
                                        Invoice
                                    </a>
                                </div>
                            </td>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- No Orders Matching Query -->
        <div
            x-show="filteredOrders().length === 0"
            class="p-12 text-center text-xs text-[#78716C]"
            style="display: none;"
        >
            No orders found matching your criteria.
        </div>
    </div>

</div>
@endsection
