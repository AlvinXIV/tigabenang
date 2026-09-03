@extends('layouts.admin')

@section('title', 'Analisis Bisnis')

@section('content')
<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Analisis Bisnis</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Ringkasan performa pesanan dan popularitas material garmen Tigabenang.
            </p>
        </div>
    </div>

    <!-- 4 COMPACT KPI SUMMARY CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- Card 1: Total Estimasi -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <span class="text-xs font-medium text-[#667085]">Total Estimasi</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-xl sm:text-2xl font-semibold text-[#1C2430] font-mono tracking-tight">
                    {{ $kpis['total_revenue'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1">Akumulasi estimasi harga</span>
        </div>

        <!-- Card 2: Total Pesanan -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <span class="text-xs font-medium text-[#667085]">Total Pesanan</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-semibold text-[#1C2430] tracking-tight">
                    {{ $kpis['total_orders'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1">Seluruh order masuk</span>
        </div>

        <!-- Card 3: Rata-Rata Order -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <span class="text-xs font-medium text-[#667085]">Rata-Rata Order</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-xl sm:text-2xl font-semibold text-[#1C2430] font-mono tracking-tight">
                    {{ $kpis['avg_order_value'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1">Estimasi per transaksi</span>
        </div>

        <!-- Card 4: Produk Aktif -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <span class="text-xs font-medium text-[#667085]">Produk Aktif</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-semibold text-[#1C2430] tracking-tight">
                    {{ $kpis['active_products'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1">Koleksi busana terdaftar</span>
        </div>
    </div>

    <!-- TOP PERFORMING TABLES -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- TOP PRODUCTS -->
        <div class="admin-card overflow-hidden">
            <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex items-center justify-between">
                <h2 class="text-sm font-semibold text-[#1C2430]">Top Produk Paling Sering Dipesan</h2>
                <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#B8664A] hover:underline font-medium text-decoration-none">Katalog &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3 text-right">Frekuensi Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E5E9] bg-white">
                        @forelse ($topProducts as $prod)
                            <tr class="admin-table-row">
                                <td class="px-4 py-3.5 font-medium text-[#1C2430]">{{ $prod->nama_produk }}</td>
                                <td class="px-4 py-3.5 text-[#667085] text-xs">
                                    <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded">
                                        {{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-right font-semibold text-[#1C2430]">{{ $prod->pemesanan_count }} pesanan</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-xs text-[#667085]">Belum ada data pesanan produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TOP MATERIALS -->
        <div class="admin-card overflow-hidden">
            <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex items-center justify-between">
                <h2 class="text-sm font-semibold text-[#1C2430]">Material Kain Paling Populer</h2>
                <a href="{{ route('admin.kategori.index') }}?tab=material#material" class="text-xs text-[#B8664A] hover:underline font-medium text-decoration-none">Material &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                            <th class="px-4 py-3">Material Kain</th>
                            <th class="px-4 py-3 text-right">Frekuensi Pemilihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E5E9] bg-white">
                        @forelse ($topMaterials as $mat)
                            <tr class="admin-table-row">
                                <td class="px-4 py-3.5 font-medium text-[#1C2430] flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#B8664A]"></span>
                                    {{ $mat->nama_bahan }}
                                </td>
                                <td class="px-4 py-3.5 text-right font-semibold text-[#1C2430]">{{ $mat->pemesanan_count }} kali</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-8 text-center text-xs text-[#667085]">Belum ada data material terpilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection


