@extends('layouts.admin')

@section('title', 'Analytics & Reports')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-[#FAF8F5] rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Business Intelligence
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Analytics &amp; Reports</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Laporan performa omzet penjualan, konversi pesanan, dan tren penggunaan material atelier.
            </p>
        </div>
    </div>

    <!-- 4 KPI SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    TOTAL REVENUE
                </span>
                <div class="w-10 h-10 rounded-xl bg-[#172A39] text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">
                    {{ $kpis['total_revenue'] }}
                </h3>
            </div>
        </div>

        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    TOTAL PESANAN
                </span>
                <div class="w-10 h-10 rounded-xl bg-[#172A39] text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">
                    {{ $kpis['total_orders'] }}
                </h3>
            </div>
        </div>

        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    RATA-RATA PESANAN
                </span>
                <div class="w-10 h-10 rounded-xl bg-[#172A39] text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">
                    {{ $kpis['avg_order_value'] }}
                </h3>
            </div>
        </div>

        <div class="admin-card-rich p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase">
                    PRODUK AKTIF
                </span>
                <div class="w-10 h-10 rounded-xl bg-[#172A39] text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">
                    {{ $kpis['active_products'] }}
                </h3>
            </div>
        </div>
    </div>

    <!-- TOP PERFORMING TABLES -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- TOP PRODUCTS -->
        <div class="admin-card-rich overflow-hidden">
            <div class="p-5 border-b border-[#DCD6D0] bg-[#FAF8F5]">
                <h2 class="text-xs font-black uppercase tracking-wider text-[#172A39]">Top Produk Paling Sering Dipesan</h2>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black uppercase tracking-wider">
                        <th class="px-6 py-3.5">PRODUK</th>
                        <th class="px-6 py-3.5">KATEGORI</th>
                        <th class="px-6 py-3.5 text-right">JUMLAH PESANAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                    @forelse ($topProducts as $prod)
                        <tr class="admin-table-row">
                            <td class="px-6 py-3.5 font-black text-[#172A39]">{{ $prod->nama_produk }}</td>
                            <td class="px-6 py-3.5 text-[#555E68] font-bold">{{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}</td>
                            <td class="px-6 py-3.5 text-right font-black text-[#172A39]">{{ $prod->pemesanan_count }} x</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-[#6E7575] font-medium">Belum ada data pesanan produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TOP MATERIALS -->
        <div class="admin-card-rich overflow-hidden">
            <div class="p-5 border-b border-[#DCD6D0] bg-[#FAF8F5]">
                <h2 class="text-xs font-black uppercase tracking-wider text-[#172A39]">Material Kain Paling Populer</h2>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black uppercase tracking-wider">
                        <th class="px-6 py-3.5">MATERIAL KAIN</th>
                        <th class="px-6 py-3.5 text-right">FREKUENSI PESANAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                    @forelse ($topMaterials as $mat)
                        <tr class="admin-table-row">
                            <td class="px-6 py-3.5 font-black text-[#172A39]">🧵 {{ $mat->nama_bahan }}</td>
                            <td class="px-6 py-3.5 text-right font-black text-[#172A39]">{{ $mat->pemesanan_count }} x</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-[#6E7575] font-medium">Belum ada data material terpilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
