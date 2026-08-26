@extends('layouts.admin')

@section('title', 'Analytics & Reports')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Analytics & Reports</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Laporan performa penjualan dan penggunaan material berdasarkan data transaksi riil.
            </p>
        </div>
    </div>

    <!-- 4 KPI SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                TOTAL REVENUE
            </span>
            <h3 class="text-2xl font-normal text-[#1C1917] tracking-tight mt-3">
                {{ $kpis['total_revenue'] }}
            </h3>
        </div>

        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                TOTAL PESANAN
            </span>
            <h3 class="text-2xl font-normal text-[#1C1917] tracking-tight mt-3 font-mono">
                {{ $kpis['total_orders'] }}
            </h3>
        </div>

        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                RATA-RATA PESANAN
            </span>
            <h3 class="text-2xl font-normal text-[#1C1917] tracking-tight mt-3">
                {{ $kpis['avg_order_value'] }}
            </h3>
        </div>

        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                PRODUK AKTIF
            </span>
            <h3 class="text-2xl font-normal text-[#1C1917] tracking-tight mt-3 font-mono">
                {{ $kpis['active_products'] }}
            </h3>
        </div>
    </div>

    <!-- TOP PERFORMING TABLES -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- TOP PRODUCTS -->
        <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
            <div class="p-5 border-b border-[#EADACE]/70 bg-[#FAF7F2]/50">
                <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-[#786C62]">Top Produk Paling Sering Dipesan</h2>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/30 text-[10px] font-mono text-[#786C62] uppercase">
                        <th class="px-6 py-3">PRODUK</th>
                        <th class="px-6 py-3">KATEGORI</th>
                        <th class="px-6 py-3 text-right">JUMLAH PESANAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @forelse ($topProducts as $prod)
                        <tr class="hover:bg-[#FAF7F2]/60">
                            <td class="px-6 py-3.5 font-medium text-[#1C1917]">{{ $prod->nama_produk }}</td>
                            <td class="px-6 py-3.5 text-[#574E46]">{{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}</td>
                            <td class="px-6 py-3.5 text-right font-mono font-bold text-[#B85331]">{{ $prod->pemesanan_count }} x</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-[#78716C]">Belum ada data pesanan produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TOP MATERIALS -->
        <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
            <div class="p-5 border-b border-[#EADACE]/70 bg-[#FAF7F2]/50">
                <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-[#786C62]">Material Kain Paling Populer</h2>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/30 text-[10px] font-mono text-[#786C62] uppercase">
                        <th class="px-6 py-3">MATERIAL KAIN</th>
                        <th class="px-6 py-3 text-right">FREKUENSI PESANAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @forelse ($topMaterials as $mat)
                        <tr class="hover:bg-[#FAF7F2]/60">
                            <td class="px-6 py-3.5 font-medium text-[#1C1917]">{{ $mat->nama_bahan }}</td>
                            <td class="px-6 py-3.5 text-right font-mono font-bold text-[#B85331]">{{ $mat->pemesanan_count }} x</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-6 text-center text-[#78716C]">Belum ada data material terpilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
