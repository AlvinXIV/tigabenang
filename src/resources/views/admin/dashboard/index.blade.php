@extends('layouts.admin')

@section('title', 'Ikhtisar Dashboard')

@section('content')
<div class="space-y-6">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTONS                 -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Ikhtisar Dashboard</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Pantau pesanan, penetapan harga, dan kesiapan katalog.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.analytics') }}"
                class="btn-secondary px-3.5 py-2 text-xs sm:text-sm gap-2"
            >
                <svg class="w-4 h-4 text-[#667085]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>Lihat Analisis</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. SUMMARY KPI CARDS (4 Compact Columns)       -->
    <!-- ============================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        
        <!-- Card 1: Pesanan Masuk -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <span class="text-xs font-medium text-[#667085]">Pesanan Masuk</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-semibold text-[#1C2430] tracking-tight">
                    {{ $summary['total_orders']['count'] }}
                </span>
                <span class="text-[11px] text-[#667085]">Total data</span>
            </div>
        </div>

        <!-- Card 2: Menunggu Penetapan Harga -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-[#667085]">Menunggu Penetapan Harga</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-semibold text-[#1C2430] tracking-tight">
                    {{ $summary['waiting_price']['count'] }}
                </span>
                <span class="text-[11px] text-amber-700 font-medium">Perlu tindakan</span>
            </div>
        </div>

        <!-- Card 3: Harga Disepakati -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-[#667085]">Harga Disepakati</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-semibold text-[#1C2430] tracking-tight">
                    {{ $summary['confirmed_orders']['count'] }}
                </span>
                <span class="text-[11px] text-emerald-700 font-medium">Tersimpan</span>
            </div>
        </div>

        <!-- Card 4: Produk Aktif -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <span class="text-xs font-medium text-[#667085]">Produk Aktif</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-semibold text-[#1C2430] tracking-tight">
                    {{ $productOverview['total_products'] }}
                </span>
                <span class="text-[11px] text-[#667085]">{{ $productOverview['models_3d_linked'] }} berkas 3D</span>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. SECTION UTAMA: PESANAN PERLU TINDAKAN       -->
    <!-- ============================================== -->
    <div class="admin-card overflow-hidden">
        <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Pesanan yang Perlu Ditindaklanjuti</h2>
            </div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#B8664A] hover:text-[#9A4E3A] font-medium text-decoration-none">
                Buka Pesanan Masuk &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-5 py-3 font-mono">ID Pesanan</th>
                        <th class="px-5 py-3">Pelanggan</th>
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3 font-mono">Estimasi Harga</th>
                        <th class="px-5 py-3">Status Harga</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($ordersNeedingAction as $order)
                        <tr class="admin-table-row">
                            <td class="px-5 py-3.5 font-mono text-xs font-medium text-[#1C2430] whitespace-nowrap">
                                #ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-3.5 font-medium text-[#1C2430] whitespace-nowrap">
                                {{ $order->nama }}
                            </td>
                            <td class="px-5 py-3.5 text-[#667085] whitespace-nowrap">
                                {{ $order->produk ? $order->produk->nama_produk : '-' }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap font-mono text-xs text-[#667085]">
                                Menunggu input
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <x-badge variant="warning">
                                    Menunggu Penetapan Harga
                                </x-badge>
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a
                                    href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}"
                                    class="btn-secondary px-3 py-1 text-xs"
                                >
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-xs text-[#667085]">
                                Tidak ada pesanan yang memerlukan tindakan saat ini. Semua pesanan telah ditinjau.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 4. SECTION KEDUA: PESANAN TERBARU              -->
    <!-- ============================================== -->
    <div class="admin-card overflow-hidden">
        <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#1C2430]"></span>
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Pesanan Terbaru</h2>
            </div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#B8664A] hover:text-[#9A4E3A] font-medium text-decoration-none">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3 font-mono">ID Pesanan</th>
                        <th class="px-5 py-3">Pelanggan</th>
                        <th class="px-5 py-3">Produk</th>
                        <th class="px-5 py-3 font-mono">Estimasi Harga</th>
                        <th class="px-5 py-3">Status Harga</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($recentOrders as $order)
                        <tr class="admin-table-row">
                            <td class="px-5 py-3.5 text-xs text-[#667085] whitespace-nowrap">
                                {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs font-medium text-[#1C2430] whitespace-nowrap">
                                #ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-3.5 font-medium text-[#1C2430] whitespace-nowrap">
                                {{ $order->nama }}
                            </td>
                            <td class="px-5 py-3.5 text-[#667085] whitespace-nowrap">
                                {{ $order->produk ? $order->produk->nama_produk : '-' }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap font-mono text-xs text-[#1C2430]">
                                {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if ($order->total_harga)
                                    <x-badge variant="success">
                                        Harga Disepakati
                                    </x-badge>
                                @else
                                    <x-badge variant="warning">
                                        Menunggu Penetapan Harga
                                    </x-badge>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a
                                    href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}"
                                    class="btn-secondary px-3 py-1 text-xs"
                                >
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-xs text-[#667085]">
                                Belum ada pesanan terbaru tercatat di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


