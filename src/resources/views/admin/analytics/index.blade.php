@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER                                  -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Analytics & Performance</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Garment production volume, sales revenue, and inventory utilization.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1 bg-white border border-[#D9CCC1] text-xs font-mono text-[#78716C]">
                Period: Last 6 Months (2026)
            </span>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. TOP KPI CARDS (4 COLUMNS)                   -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Revenue -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-2">
            <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">TOTAL REVENUE</span>
            <p class="text-xl sm:text-2xl font-bold text-[#1C1917] font-mono">{{ $kpis['total_revenue'] }}</p>
            <span class="text-[11px] text-emerald-700 font-mono flex items-center gap-1">
                <span>&uarr; +24%</span>
                <span class="text-[#9E9084]">vs previous month</span>
            </span>
        </div>

        <!-- Total Orders -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-2">
            <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">TOTAL ORDERS</span>
            <p class="text-xl sm:text-2xl font-bold text-[#1C1917] font-mono">{{ $kpis['total_orders'] }} <span class="text-xs font-normal text-[#78716C]">orders</span></p>
            <span class="text-[11px] text-[#78716C] font-mono">Custom apparel jobs</span>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-2">
            <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">AVG ORDER VALUE</span>
            <p class="text-xl sm:text-2xl font-bold text-[#1C1917] font-mono">{{ $kpis['avg_order_value'] }}</p>
            <span class="text-[11px] text-[#78716C] font-mono">Per custom production batch</span>
        </div>

        <!-- Active Products -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-2">
            <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">ACTIVE CATALOG</span>
            <p class="text-xl sm:text-2xl font-bold text-[#1C1917] font-mono">{{ $kpis['active_products'] }} <span class="text-xs font-normal text-[#78716C]">products</span></p>
            <span class="text-[11px] text-[#78716C] font-mono">Configured apparel items</span>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. MONTHLY REVENUE & ORDER TREND BARS          -->
    <!-- ============================================== -->
    <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-[#EADACE]/70">
            <div>
                <h2 class="text-base font-medium text-[#1C1917]">Monthly Revenue Growth</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Production volume and total deal value per month.</p>
            </div>
            <span class="text-xs font-mono text-[#78716C]">Values in IDR (Rupiah)</span>
        </div>

        <!-- Visual Bar Chart -->
        <div class="pt-4">
            <div class="grid grid-cols-6 gap-3 sm:gap-6 items-end h-56 border-b border-[#EADACE]/70 pb-2">
                @php $maxRevenue = 40000000; @endphp
                @foreach ($monthlyTrend as $t)
                    @php $heightPercent = min(100, max(15, ($t['revenue'] / $maxRevenue) * 100)); @endphp
                    <div class="flex flex-col items-center gap-2 h-full justify-end group">
                        <span class="text-[10px] font-mono text-[#78716C] group-hover:text-[#B85331] transition-colors whitespace-nowrap hidden sm:block">
                            {{ $t['formatted_revenue'] }}
                        </span>
                        <div
                            class="w-full bg-[#FAF7F2] border border-[#D9CCC1] group-hover:bg-[#B85331] group-hover:border-[#B85331] transition-all relative"
                            style="height: {{ $heightPercent }}%;"
                        ></div>
                        <span class="text-xs font-mono font-medium text-[#292524] mt-1">{{ $t['month'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 4. TOP PRODUCTS & MATERIAL USAGE               -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Top Ordered Products Table (2 Cols) -->
        <div class="lg:col-span-2 bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
            <div class="p-6 border-b border-[#EADACE]/70">
                <h2 class="text-base font-medium text-[#1C1917]">Top Ordered Garments</h2>
                <p class="text-xs text-[#78716C] mt-0.5">Highest demand apparel catalog items.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                            <th class="px-6 py-3">PRODUCT</th>
                            <th class="px-6 py-3 text-center">ORDERS</th>
                            <th class="px-6 py-3 text-center">UNITS</th>
                            <th class="px-6 py-3 text-right">TOTAL SALES</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADACE]/60">
                        @foreach ($topProducts as $prod)
                            <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                                <td class="px-6 py-3.5">
                                    <p class="font-medium text-[#1C1917]">{{ $prod['name'] }}</p>
                                    <span class="text-[10px] text-[#78716C]">{{ $prod['category'] }}</span>
                                </td>
                                <td class="px-6 py-3.5 text-center font-mono text-[#1C1917]">
                                    {{ $prod['orders_count'] }}
                                </td>
                                <td class="px-6 py-3.5 text-center font-mono font-medium text-[#1C1917]">
                                    {{ $prod['total_units'] }} pcs
                                </td>
                                <td class="px-6 py-3.5 text-right font-mono font-medium text-[#B85331]">
                                    {{ $prod['revenue'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fabric Utilization & Status Distribution (1 Col) -->
        <div class="space-y-8">
            
            <!-- Fabric Utilization -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Fabric Material Usage</h2>

                <div class="space-y-3.5 text-xs">
                    @foreach ($topMaterials as $mat)
                        <div class="space-y-1">
                            <div class="flex justify-between">
                                <span class="font-medium text-[#1C1917]">{{ $mat['name'] }}</span>
                                <span class="font-mono text-[#78716C]">{{ $mat['usage_percentage'] }}%</span>
                            </div>
                            <div class="w-full h-2 bg-[#FAF7F2] border border-[#EADACE]">
                                <div class="h-full bg-[#B85331]" style="width: {{ $mat['usage_percentage'] }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Pipeline Distribution -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Production Status Distribution</h2>

                <div class="space-y-2.5 text-xs font-mono">
                    @foreach ($statusDistribution as $sd)
                        <div class="flex items-center justify-between py-1 border-b border-[#EADACE]/50">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $sd['color'] }}"></span>
                                <span class="text-[#292524]">{{ $sd['status'] }}</span>
                            </div>
                            <span class="text-[#78716C]">{{ $sd['count'] }} jobs ({{ $sd['percentage'] }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
