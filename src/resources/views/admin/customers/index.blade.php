@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
<div
    class="space-y-8"
    x-data="{
        searchQuery: '',
        customers: {{ json_encode($customers) }},
        
        filteredCustomers() {
            const query = this.searchQuery.toLowerCase();
            if (!query) return this.customers;
            return this.customers.filter(c => 
                c.name.toLowerCase().includes(query) || 
                (c.company && c.company.toLowerCase().includes(query)) ||
                (c.phone && c.phone.includes(query)) ||
                (c.email && c.email.toLowerCase().includes(query))
            );
        }
    }"
>

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH TOOLBAR                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Customers</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Client directory, contact coordinates, and order history records.
            </p>
        </div>

        <div class="relative w-full sm:w-80">
            <input
                type="text"
                x-model="searchQuery"
                placeholder="Search customer, company, phone..."
                class="w-full pl-9 pr-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] transition-colors"
            />
            <svg class="w-4 h-4 text-[#A89A8E] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. CUSTOMERS TABLE                             -->
    <!-- ============================================== -->
    <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">CUSTOMER / INSTITUTION</th>
                        <th class="px-6 py-3.5">CONTACT</th>
                        <th class="px-6 py-3.5 text-center">TOTAL ORDERS</th>
                        <th class="px-6 py-3.5">TOTAL SPEND</th>
                        <th class="px-6 py-3.5">LAST ORDER</th>
                        <th class="px-6 py-3.5 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    <template x-for="c in filteredCustomers()" :key="c.id">
                        <tr class="hover:bg-[#FAF7F2]/50 transition-colors group">
                            
                            <!-- Customer Info -->
                            <td class="px-6 py-4">
                                <a :href="'/admin/pelanggan/' + c.id" class="font-medium text-sm text-[#1C1917] group-hover:text-[#B85331] transition-colors block" x-text="c.name"></a>
                                <p class="text-[11px] text-[#78716C]" x-text="c.company"></p>
                            </td>

                            <!-- Contact -->
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">
                                <p class="text-[#292524]" x-text="c.phone"></p>
                                <p class="text-[#9E9084] text-[11px]" x-text="c.email"></p>
                            </td>

                            <!-- Total Orders -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-0.5 bg-[#FAF7F2] border border-[#EADACE] font-mono font-medium text-[#1C1917]" x-text="c.total_orders + ' orders'"></span>
                            </td>

                            <!-- Total Spend -->
                            <td class="px-6 py-4 whitespace-nowrap font-mono font-medium text-[#1C1917]" x-text="c.total_spent"></td>

                            <!-- Last Order Date -->
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-[#78716C]" x-text="c.last_order_date"></td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a
                                    :href="'/admin/pelanggan/' + c.id"
                                    class="text-xs font-mono font-medium tracking-wider text-[#B85331] hover:underline uppercase transition-colors"
                                >
                                    View Detail &rarr;
                                </a>
                            </td>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div
            x-show="filteredCustomers().length === 0"
            class="p-12 text-center text-xs text-[#78716C]"
            style="display: none;"
        >
            No customers found matching your search.
        </div>
    </div>

</div>
@endsection
