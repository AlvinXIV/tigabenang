@extends('layouts.admin')

@section('title', 'Analisis Bisnis')

@section('content')
@php
    // Eager-load real dataset from PostgreSQL without modifying backend controllers or routes
    $rawOrders = \App\Models\Pemesanan::with(['produk.kategori', 'bahan'])->orderBy('created_at', 'asc')->get();

    $analyticsOrders = $rawOrders->map(function ($order) {
        return [
            'id' => $order->id_pemesanan,
            'date' => $order->created_at ? $order->created_at->format('Y-m-d') : null,
            'display_date' => $order->created_at ? $order->created_at->translatedFormat('d M Y') : '-',
            'short_date' => $order->created_at ? $order->created_at->format('d M') : '-',
            'timestamp' => $order->created_at ? $order->created_at->timestamp : 0,
            'total_harga' => $order->total_harga !== null ? (float) $order->total_harga : null,
            'product_id' => $order->produk_id,
            'product_name' => $order->produk ? $order->produk->nama_produk : 'Produk Dihapus',
            'category_name' => ($order->produk && $order->produk->kategori) ? $order->produk->kategori->nama_kategori : 'Katalog Standar',
            'materials' => $order->bahan->pluck('nama_bahan')->toArray(),
        ];
    });

    $allCategories = \App\Models\Kategori::withCount('produk')->get()->map(function ($cat) {
        return [
            'id' => $cat->id_kategori,
            'name' => $cat->nama_kategori,
            'products_count' => $cat->produk_count,
        ];
    });

    $totalCatalogProducts = \App\Models\Produk::count();
    $productsWithout3DCount = \App\Models\Produk::whereNull('file_model_3d')->orWhere('file_model_3d', '')->count();
    $categoriesWithoutProductsCount = \App\Models\Kategori::doesntHave('produk')->count();
@endphp

<div
    class="space-y-6"
    x-data="analyticsDashboard(window.__ANALYTICS_CONFIG__)"
>

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Analisis Bisnis</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Pantau tren pesanan, produk, material, dan estimasi nilai penjualan.
            </p>
        </div>

        <!-- Period Filter Dropdown -->
        <div class="relative inline-block text-left" @click.outside="dropdownOpen = false">
            <button
                type="button"
                @click="dropdownOpen = !dropdownOpen"
                class="btn-secondary px-3.5 py-2 text-xs sm:text-sm gap-2 font-medium cursor-pointer"
            >
                <svg class="w-4 h-4 text-[#667085]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span x-text="periodLabel">Semua Waktu</span>
                <svg class="w-3.5 h-3.5 text-[#667085] transition-transform duration-150" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
                x-show="dropdownOpen"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-1.5 w-44 rounded-lg bg-white shadow-lg border border-[#E2E5E9] py-1 z-30 focus:outline-none text-xs"
                style="display: none;"
            >
                <button
                    type="button"
                    @click="setPeriod('all', 'Semua Waktu')"
                    class="w-full text-left px-3.5 py-2 text-[#1C2430] hover:bg-[#F7F7F5] flex items-center justify-between"
                    :class="period === 'all' ? 'font-semibold text-[#B8664A] bg-[#FDF8F6]' : ''"
                >
                    <span>Semua Waktu</span>
                    <span x-show="period === 'all'" class="text-[#B8664A]">&check;</span>
                </button>
                <button
                    type="button"
                    @click="setPeriod('7d', '7 Hari Terakhir')"
                    class="w-full text-left px-3.5 py-2 text-[#1C2430] hover:bg-[#F7F7F5] flex items-center justify-between"
                    :class="period === '7d' ? 'font-semibold text-[#B8664A] bg-[#FDF8F6]' : ''"
                >
                    <span>7 Hari Terakhir</span>
                    <span x-show="period === '7d'" class="text-[#B8664A]">&check;</span>
                </button>
                <button
                    type="button"
                    @click="setPeriod('30d', '30 Hari Terakhir')"
                    class="w-full text-left px-3.5 py-2 text-[#1C2430] hover:bg-[#F7F7F5] flex items-center justify-between"
                    :class="period === '30d' ? 'font-semibold text-[#B8664A] bg-[#FDF8F6]' : ''"
                >
                    <span>30 Hari Terakhir</span>
                    <span x-show="period === '30d'" class="text-[#B8664A]">&check;</span>
                </button>
                <button
                    type="button"
                    @click="setPeriod('90d', '3 Bulan Terakhir')"
                    class="w-full text-left px-3.5 py-2 text-[#1C2430] hover:bg-[#F7F7F5] flex items-center justify-between"
                    :class="period === '90d' ? 'font-semibold text-[#B8664A] bg-[#FDF8F6]' : ''"
                >
                    <span>3 Bulan Terakhir</span>
                    <span x-show="period === '90d'" class="text-[#B8664A]">&check;</span>
                </button>
                <button
                    type="button"
                    @click="setPeriod('year', 'Tahun Ini')"
                    class="w-full text-left px-3.5 py-2 text-[#1C2430] hover:bg-[#F7F7F5] flex items-center justify-between"
                    :class="period === 'year' ? 'font-semibold text-[#B8664A] bg-[#FDF8F6]' : ''"
                >
                    <span>Tahun Ini</span>
                    <span x-show="period === 'year'" class="text-[#B8664A]">&check;</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 4 COMPACT PRIMARY KPIS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- KPI 1: Total Pesanan -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-[#667085]">Total Pesanan</span>
                <span class="p-1.5 bg-[#F7F7F5] rounded-md text-[#667085]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline justify-between">
                <span class="text-2xl sm:text-[28px] font-semibold text-[#1C2430] tracking-tight" x-text="kpiTotalOrders">
                    {{ $kpis['total_orders'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1.5">Seluruh pesanan masuk</span>
        </div>

        <!-- KPI 2: Total Estimasi -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-[#667085]">Total Estimasi</span>
                <span class="p-1.5 bg-[#FDF8F6] rounded-md text-[#B8664A]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline justify-between">
                <span class="text-xl sm:text-2xl font-semibold text-[#1C2430] tracking-tight" x-text="formatRupiah(kpiTotalRevenue)">
                    {{ $kpis['total_revenue'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1.5">Akumulasi estimasi harga</span>
        </div>

        <!-- KPI 3: Rata-Rata Pesanan -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-[#667085]">Rata-Rata Pesanan</span>
                <span class="p-1.5 bg-[#F7F7F5] rounded-md text-[#667085]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline justify-between">
                <span class="text-xl sm:text-2xl font-semibold text-[#1C2430] tracking-tight" x-text="formatRupiah(kpiAvgOrderValue)">
                    {{ $kpis['avg_order_value'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1.5">Rata-rata nilai bertarif</span>
        </div>

        <!-- KPI 4: Produk Aktif -->
        <div class="admin-card p-4 sm:p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-[#667085]">Produk Aktif</span>
                <span class="p-1.5 bg-[#F7F7F5] rounded-md text-[#667085]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </span>
            </div>
            <div class="mt-2.5 flex items-baseline justify-between">
                <span class="text-2xl sm:text-[28px] font-semibold text-[#1C2430] tracking-tight" x-text="totalProductsCatalog">
                    {{ $kpis['active_products'] }}
                </span>
            </div>
            <span class="text-[11px] text-[#667085] mt-1.5">Produk dalam katalog</span>
        </div>
    </div>

    <!-- SUB-METRIC: ANALISIS HARGA PESANAN -->
    <div class="admin-card p-4 bg-[#FAF9F7] border-[#E2E5E9] flex flex-wrap items-center justify-between gap-4 text-xs">
        <div class="flex items-center gap-2">
            <span class="font-semibold text-[#1C2430]">Spesifikasi Harga Periode:</span>
        </div>
        <div class="flex flex-wrap items-center gap-6 text-[#667085]">
            <div>
                Harga Tertinggi: <span class="font-semibold text-[#1C2430]" x-text="kpiHighestOrder > 0 ? formatRupiah(kpiHighestOrder) : '-'">-</span>
            </div>
            <div>
                Harga Terendah: <span class="font-semibold text-[#1C2430]" x-text="kpiLowestOrder > 0 ? formatRupiah(kpiLowestOrder) : '-'">-</span>
            </div>
            <div>
                Belum Ada Estimasi Harga: 
                <span
                    class="font-semibold px-2 py-0.5 rounded-full"
                    :class="kpiOrdersWithoutPrice > 0 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'"
                    x-text="kpiOrdersWithoutPrice + ' pesanan'"
                >
                    0 pesanan
                </span>
            </div>
        </div>
    </div>

    <!-- SECTION: TREN PESANAN & ESTIMASI NILAI -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- CHART 1: TREN PESANAN -->
        <div class="admin-card p-5 space-y-3">
            <div class="flex items-center justify-between border-b border-[#E2E5E9] pb-3">
                <div>
                    <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Tren Pesanan</h2>
                    <p class="text-xs text-[#667085] mt-0.5">Jumlah transaksi pesanan masuk berdasarkan tanggal.</p>
                </div>
                <span class="text-[11px] font-medium text-[#667085] bg-[#F7F7F5] px-2.5 py-1 rounded border border-[#E2E5E9]" x-text="periodLabel">
                    Semua Waktu
                </span>
            </div>

            <!-- Fixed Height Container for Chart.js -->
            <div class="relative w-full" style="height: 300px; min-height: 300px;">
                <!-- Loading State -->
                <div x-show="isLoading" class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-xs text-[#667085] bg-white/80 z-10">
                    <div class="w-5 h-5 border-2 border-[#B8664A] border-t-transparent rounded-full animate-spin"></div>
                    <span>Memuat visualisasi tren...</span>
                </div>

                <!-- Empty State -->
                <div x-show="!isLoading && kpiTotalOrders === 0" class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 space-y-1 bg-white" style="display: none;">
                    <p class="text-xs font-semibold text-[#1C2430]">Belum ada cukup data untuk melihat tren.</p>
                    <p class="text-[11px] text-[#667085]">Tidak ada transaksi pesanan yang tercatat pada rentang waktu ini.</p>
                </div>

                <!-- Canvas Chart -->
                <canvas id="analyticsOrdersChart" data-chart class="w-full h-full block"></canvas>
            </div>
        </div>

        <!-- CHART 2: TREN ESTIMASI NILAI PESANAN -->
        <div class="admin-card p-5 space-y-3">
            <div class="flex items-center justify-between border-b border-[#E2E5E9] pb-3">
                <div>
                    <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Tren Estimasi Nilai Pesanan</h2>
                    <p class="text-xs text-[#667085] mt-0.5">Akumulasi estimasi harga garmen berdasarkan tanggal transaksi.</p>
                </div>
                <span class="text-[11px] font-medium text-[#667085] bg-[#F7F7F5] px-2.5 py-1 rounded border border-[#E2E5E9]" x-text="periodLabel">
                    Semua Waktu
                </span>
            </div>

            <!-- Fixed Height Container for Chart.js -->
            <div class="relative w-full" style="height: 300px; min-height: 300px;">
                <!-- Loading State -->
                <div x-show="isLoading" class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-xs text-[#667085] bg-white/80 z-10">
                    <div class="w-5 h-5 border-2 border-[#1C2430] border-t-transparent rounded-full animate-spin"></div>
                    <span>Memuat visualisasi tren...</span>
                </div>

                <!-- Empty State -->
                <div x-show="!isLoading && kpiTotalOrders === 0" class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 space-y-1 bg-white" style="display: none;">
                    <p class="text-xs font-semibold text-[#1C2430]">Belum ada cukup data untuk melihat tren.</p>
                    <p class="text-[11px] text-[#667085]">Tidak ada nilai pesanan yang tercatat pada rentang waktu ini.</p>
                </div>

                <!-- Canvas Chart -->
                <canvas id="analyticsRevenueChart" data-chart class="w-full h-full block"></canvas>
            </div>
        </div>

    </div>

    <!-- SECTION: RANKINGS (PRODUK TERPOPULER & MATERIAL TERPOPULER) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- CARD 1: PRODUK PALING SERING DIPESAN -->
        <div class="admin-card overflow-hidden">
            <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-[#1C2430]">Produk Paling Sering Dipesan</h2>
                    <p class="text-[11px] text-[#667085] mt-0.5">Peringkat produk berdasarkan frekuensi pesanan aktual.</p>
                </div>
                <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#B8664A] hover:underline font-medium text-decoration-none">Katalog &rarr;</a>
            </div>

            <div class="divide-y divide-[#E2E5E9] bg-white">
                <template x-for="(prod, idx) in topProductsList" :key="prod.name">
                    <div class="p-4 flex items-center justify-between gap-4 hover:bg-[#FAF9F7] transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <span
                                class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold shrink-0"
                                :class="idx === 0 ? 'bg-[#B8664A] text-white' : 'bg-[#F7F7F5] text-[#667085] border border-[#E2E5E9]'"
                                x-text="idx + 1"
                            ></span>
                            <div class="min-w-0">
                                <h3 class="text-xs sm:text-sm font-semibold text-[#1C2430] truncate" x-text="prod.name"></h3>
                                <span class="text-[11px] text-[#667085]" x-text="prod.category"></span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-xs sm:text-sm font-semibold text-[#1C2430]" x-text="prod.count + ' pesanan'"></span>
                            <div class="w-24 h-1.5 bg-[#F7F7F5] rounded-full overflow-hidden mt-1.5 border border-[#E2E5E9]">
                                <div
                                    class="h-full bg-[#B8664A] rounded-full transition-all duration-300"
                                    :style="'width: ' + (kpiTotalOrders > 0 ? (prod.count / kpiTotalOrders * 100) : 0) + '%'"
                                ></div>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="topProductsList.length === 0" class="p-8 text-center text-xs text-[#667085]">
                    Belum ada data transaksi produk pada periode ini.
                </div>
            </div>
        </div>

        <!-- CARD 2: MATERIAL PALING BANYAK DIPILIH -->
        <div class="admin-card overflow-hidden">
            <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-[#1C2430]">Material Paling Banyak Dipilih</h2>
                    <p class="text-[11px] text-[#667085] mt-0.5">Preferensi kain garmen yang dipilih pemesan.</p>
                </div>
                <a href="{{ route('admin.kategori.index') }}?tab=material#material" class="text-xs text-[#B8664A] hover:underline font-medium text-decoration-none">Material &rarr;</a>
            </div>

            <div class="divide-y divide-[#E2E5E9] bg-white">
                <template x-for="(mat, idx) in topMaterialsList" :key="mat.name">
                    <div class="p-4 flex items-center justify-between gap-4 hover:bg-[#FAF9F7] transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <span
                                class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold shrink-0"
                                :class="idx === 0 ? 'bg-[#1C2430] text-white' : 'bg-[#F7F7F5] text-[#667085] border border-[#E2E5E9]'"
                                x-text="idx + 1"
                            ></span>
                            <div class="min-w-0">
                                <h3 class="text-xs sm:text-sm font-semibold text-[#1C2430] truncate" x-text="mat.name"></h3>
                                <span class="text-[11px] text-[#667085]">Material Tekstil</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-xs sm:text-sm font-semibold text-[#1C2430]" x-text="mat.count + ' kali'"></span>
                            <div class="w-24 h-1.5 bg-[#F7F7F5] rounded-full overflow-hidden mt-1.5 border border-[#E2E5E9]">
                                <div
                                    class="h-full bg-[#1C2430] rounded-full transition-all duration-300"
                                    :style="'width: ' + (kpiTotalOrders > 0 ? (mat.count / kpiTotalOrders * 100) : 0) + '%'"
                                ></div>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="topMaterialsList.length === 0" class="p-8 text-center text-xs text-[#667085]">
                    Belum ada material kain yang dipilih pada periode ini.
                </div>
            </div>
        </div>

    </div>

    <!-- SECTION: PERFORMA KATEGORI PRODUK -->
    <div class="admin-card p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-[#E2E5E9] pb-3">
            <div>
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Performa Kategori Produk</h2>
                <p class="text-xs text-[#667085] mt-0.5">Distribusi pesanan garmen di seluruh klasifikasi busana terdaftar.</p>
            </div>
            <a href="{{ route('admin.kategori.index') }}" class="text-xs text-[#B8664A] hover:underline font-medium text-decoration-none">Kelola Kategori &rarr;</a>
        </div>

        <div class="space-y-3.5 pt-1">
            <template x-for="cat in categoryPerformance" :key="cat.name">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-[#1C2430]" x-text="cat.name"></span>
                        <span class="font-semibold text-[#1C2430]" x-text="cat.ordersCount + ' pesanan'"></span>
                    </div>
                    <div class="w-full h-2.5 bg-[#F7F7F5] rounded-full overflow-hidden border border-[#E2E5E9]">
                        <div
                            class="h-full rounded-full transition-all duration-300"
                            :class="cat.ordersCount > 0 ? 'bg-[#B8664A]' : 'bg-transparent'"
                            :style="'width: ' + (kpiTotalOrders > 0 ? Math.max(5, (cat.ordersCount / kpiTotalOrders * 100)) : 0) + '%'"
                        ></div>
                    </div>
                </div>
            </template>

            <div x-show="categoryPerformance.length === 0" class="text-center py-6 text-xs text-[#667085]">
                Belum ada kategori yang terdaftar dalam sistem.
            </div>
        </div>
    </div>

    <!-- SECTION: INSIGHT BISNIS & PERLU PERHATIAN -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- CARD 1: INSIGHT BISNIS -->
        <div class="admin-card p-5 space-y-3.5">
            <div class="flex items-center gap-2.5 border-b border-[#E2E5E9] pb-3">
                <div class="w-7 h-7 rounded-lg bg-[#FDF8F6] text-[#B8664A] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-[#1C2430]">Insight Bisnis Otomatis</h2>
                    <p class="text-[11px] text-[#667085]">Ringkasan kondisi bisnis berbasis komputasi transaksi aktual.</p>
                </div>
            </div>

            <div class="space-y-2.5 pt-1">
                <template x-for="(text, idx) in insights" :key="idx">
                    <div class="p-3 bg-[#FAF9F7] rounded-lg border border-[#E2E5E9] flex items-start gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#B8664A] mt-1.5 shrink-0"></span>
                        <p class="text-xs text-[#1C2430] leading-relaxed" x-text="text"></p>
                    </div>
                </template>
            </div>
        </div>

        <!-- CARD 2: PERLU PERHATIAN -->
        <div class="admin-card p-5 space-y-3.5">
            <div class="flex items-center gap-2.5 border-b border-[#E2E5E9] pb-3">
                <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-[#1C2430]">Perlu Perhatian</h2>
                    <p class="text-[11px] text-[#667085]">Indikator operasional yang membutuhkan tindak lanjut admin.</p>
                </div>
            </div>

            <div class="space-y-2.5 pt-1">
                <!-- Alert 1: Pesanan Menunggu Penetapan Harga -->
                <div class="p-3.5 rounded-lg border flex items-center justify-between gap-3" :class="kpiOrdersWithoutPrice > 0 ? 'bg-amber-50/60 border-amber-200' : 'bg-[#FAF9F7] border-[#E2E5E9]'">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-[#1C2430]">Pesanan Tanpa Estimasi Harga</span>
                            <span
                                class="text-[10px] font-semibold px-2 py-0.5 rounded-full"
                                :class="kpiOrdersWithoutPrice > 0 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'"
                                x-text="kpiOrdersWithoutPrice"
                            ></span>
                        </div>
                        <p class="text-[11px] text-[#667085]">
                            <span x-show="kpiOrdersWithoutPrice > 0">Pesanan belum difinalisasi harga kesepakatannya.</span>
                            <span x-show="kpiOrdersWithoutPrice === 0">Semua pesanan periode ini telah memiliki harga.</span>
                        </p>
                    </div>
                    <a
                        href="{{ route('admin.pesanan.index') }}"
                        class="text-xs font-medium text-[#B8664A] hover:underline whitespace-nowrap shrink-0 text-decoration-none"
                    >
                        Tinjau &rarr;
                    </a>
                </div>

                <!-- Alert 2: Model 3D Belum Terhubung -->
                <div class="p-3.5 rounded-lg border flex items-center justify-between gap-3" :class="productsWithout3D > 0 ? 'bg-blue-50/50 border-blue-200' : 'bg-[#FAF9F7] border-[#E2E5E9]'">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-[#1C2430]">Koleksi Belum Memiliki Model 3D</span>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-800" x-text="productsWithout3D"></span>
                        </div>
                        <p class="text-[11px] text-[#667085]">Produk katalog belum dihubungkan dengan file .glb/.gltf.</p>
                    </div>
                    <a
                        href="{{ route('admin.model-3d.create') }}"
                        class="text-xs font-medium text-[#B8664A] hover:underline whitespace-nowrap shrink-0 text-decoration-none"
                    >
                        Hubungkan &rarr;
                    </a>
                </div>

                <!-- Alert 3: Kategori Tanpa Produk -->
                <div class="p-3.5 rounded-lg border flex items-center justify-between gap-3" :class="categoriesWithoutProducts > 0 ? 'bg-rose-50/50 border-rose-200' : 'bg-[#FAF9F7] border-[#E2E5E9]'">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-[#1C2430]">Kategori Tanpa Produk</span>
                            <span
                                class="text-[10px] font-semibold px-2 py-0.5 rounded-full"
                                :class="categoriesWithoutProducts > 0 ? 'bg-rose-100 text-rose-800' : 'bg-emerald-100 text-emerald-800'"
                                x-text="categoriesWithoutProducts"
                            ></span>
                        </div>
                        <p class="text-[11px] text-[#667085]">
                            <span x-show="categoriesWithoutProducts > 0">Kategori busana belum diisi item katalog.</span>
                            <span x-show="categoriesWithoutProducts === 0">Seluruh kategori telah memiliki produk terdaftar.</span>
                        </p>
                    </div>
                    <a
                        href="{{ route('admin.kategori.index') }}"
                        class="text-xs font-medium text-[#B8664A] hover:underline whitespace-nowrap shrink-0 text-decoration-none"
                    >
                        Kelola &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- DATA CONFIG & ALPINE FACTORY FUNCTION (ISOLATED SAFELY IN SCRIPT TAG) -->
<script>
    window.__ANALYTICS_CONFIG__ = {
        orders: @json($analyticsOrders),
        categories: @json($allCategories),
        totalProductsCatalog: {{ $totalCatalogProducts }},
        productsWithout3D: {{ $productsWithout3DCount }},
        categoriesWithoutProducts: {{ $categoriesWithoutProductsCount }}
    };

    function analyticsDashboard(config) {
        const rawAllOrders = (config && config.orders) ? config.orders : [];
        const rawAllCategories = (config && config.categories) ? config.categories : [];

        // Synchronous initial calculations for zero-delay initial render
        const computeInitialMetrics = (orders) => {
            const totalOrders = orders.length;
            const totalRevenue = orders.reduce((sum, o) => sum + (o.total_harga || 0), 0);
            const priced = orders.filter(o => o.total_harga !== null && o.total_harga !== undefined);
            const avgOrderValue = priced.length > 0 ? (priced.reduce((sum, o) => sum + o.total_harga, 0) / priced.length) : 0;
            const highestOrder = priced.length > 0 ? Math.max(...priced.map(o => o.total_harga)) : 0;
            const lowestOrder = priced.length > 0 ? Math.min(...priced.map(o => o.total_harga)) : 0;
            const ordersWithoutPrice = orders.filter(o => o.total_harga === null || o.total_harga === undefined).length;
            return { totalOrders, totalRevenue, avgOrderValue, highestOrder, lowestOrder, ordersWithoutPrice };
        };

        const computeInitialRankings = (orders, categories) => {
            const prodMap = {};
            orders.forEach(o => {
                const key = o.product_name;
                if (!prodMap[key]) prodMap[key] = { name: o.product_name, category: o.category_name, count: 0 };
                prodMap[key].count += 1;
            });
            const topProducts = Object.values(prodMap).sort((a, b) => b.count - a.count).slice(0, 5);

            const matMap = {};
            orders.forEach(o => {
                if (Array.isArray(o.materials)) {
                    o.materials.forEach(m => {
                        if (!matMap[m]) matMap[m] = { name: m, count: 0 };
                        matMap[m].count += 1;
                    });
                }
            });
            const topMaterials = Object.values(matMap).sort((a, b) => b.count - a.count).slice(0, 5);

            const catMap = {};
            orders.forEach(o => {
                catMap[o.category_name] = (catMap[o.category_name] || 0) + 1;
            });
            const catPerf = categories.map(c => ({ name: c.name, ordersCount: catMap[c.name] || 0 }));
            Object.keys(catMap).forEach(cName => {
                if (!catPerf.some(cp => cp.name === cName)) catPerf.push({ name: cName, ordersCount: catMap[cName] });
            });
            catPerf.sort((a, b) => b.ordersCount - a.ordersCount);

            return { topProducts, topMaterials, catPerf };
        };

        const initMetrics = computeInitialMetrics(rawAllOrders);
        const initRankings = computeInitialRankings(rawAllOrders, rawAllCategories);

        return {
            period: 'all',
            periodLabel: 'Semua Waktu',
            dropdownOpen: false,
            allOrders: rawAllOrders,
            allCategories: rawAllCategories,
            totalProductsCatalog: (config && config.totalProductsCatalog) ? config.totalProductsCatalog : 0,
            productsWithout3D: (config && config.productsWithout3D) ? config.productsWithout3D : 0,
            categoriesWithoutProducts: (config && config.categoriesWithoutProducts) ? config.categoriesWithoutProducts : 0,

            // Immediately populated on mount
            filteredOrders: [...rawAllOrders],
            kpiTotalOrders: initMetrics.totalOrders,
            kpiTotalRevenue: initMetrics.totalRevenue,
            kpiAvgOrderValue: initMetrics.avgOrderValue,
            kpiHighestOrder: initMetrics.highestOrder,
            kpiLowestOrder: initMetrics.lowestOrder,
            kpiOrdersWithoutPrice: initMetrics.ordersWithoutPrice,

            topProductsList: initRankings.topProducts,
            topMaterialsList: initRankings.topMaterials,
            categoryPerformance: initRankings.catPerf,
            insights: [],

            ordersChartInstance: null,
            revenueChartInstance: null,
            chartsReady: false,
            isLoading: true,

            init() {
                this.generateInsights();
                this.loadAndInitCharts();

                // Listen for custom chartjs-loaded event from app.js as well
                window.addEventListener('chartjs-loaded', (e) => {
                    if (!this.chartsReady) {
                        this.chartsReady = true;
                        this.isLoading = false;
                        this.renderCharts();
                    }
                });
            },

            setPeriod(val, label) {
                this.period = val;
                this.periodLabel = label;
                this.dropdownOpen = false;
                this.applyFilter();
            },

            applyFilter() {
                const now = Math.floor(Date.now() / 1000);
                let cutoff = 0;

                if (this.period === '7d') {
                    cutoff = now - (7 * 86400);
                } else if (this.period === '30d') {
                    cutoff = now - (30 * 86400);
                } else if (this.period === '90d') {
                    cutoff = now - (90 * 86400);
                } else if (this.period === 'year') {
                    const currentYearStart = new Date(new Date().getFullYear(), 0, 1).getTime() / 1000;
                    cutoff = currentYearStart;
                }

                if (this.period === 'all') {
                    this.filteredOrders = [...this.allOrders];
                } else {
                    this.filteredOrders = this.allOrders.filter(o => o.timestamp >= cutoff);
                }

                this.calculateMetrics();
                this.calculateRankings();
                this.generateInsights();
                if (this.chartsReady) {
                    this.$nextTick(() => {
                        this.renderCharts();
                    });
                }
            },

            calculateMetrics() {
                this.kpiTotalOrders = this.filteredOrders.length;
                this.kpiTotalRevenue = this.filteredOrders.reduce((sum, o) => sum + (o.total_harga || 0), 0);

                const pricedOrders = this.filteredOrders.filter(o => o.total_harga !== null && o.total_harga !== undefined);
                if (pricedOrders.length > 0) {
                    this.kpiAvgOrderValue = pricedOrders.reduce((sum, o) => sum + o.total_harga, 0) / pricedOrders.length;
                    this.kpiHighestOrder = Math.max(...pricedOrders.map(o => o.total_harga));
                    this.kpiLowestOrder = Math.min(...pricedOrders.map(o => o.total_harga));
                } else {
                    this.kpiAvgOrderValue = 0;
                    this.kpiHighestOrder = 0;
                    this.kpiLowestOrder = 0;
                }

                this.kpiOrdersWithoutPrice = this.filteredOrders.filter(o => o.total_harga === null || o.total_harga === undefined).length;
            },

            calculateRankings() {
                // 1. Top Products
                const prodMap = {};
                this.filteredOrders.forEach(o => {
                    const key = o.product_name;
                    if (!prodMap[key]) {
                        prodMap[key] = {
                            name: o.product_name,
                            category: o.category_name,
                            count: 0
                        };
                    }
                    prodMap[key].count += 1;
                });
                this.topProductsList = Object.values(prodMap).sort((a, b) => b.count - a.count).slice(0, 5);

                // 2. Top Materials
                const matMap = {};
                this.filteredOrders.forEach(o => {
                    if (Array.isArray(o.materials)) {
                        o.materials.forEach(m => {
                            if (!matMap[m]) {
                                matMap[m] = { name: m, count: 0 };
                            }
                            matMap[m].count += 1;
                        });
                    }
                });
                this.topMaterialsList = Object.values(matMap).sort((a, b) => b.count - a.count).slice(0, 5);

                // 3. Category Performance
                const catCountMap = {};
                this.filteredOrders.forEach(o => {
                    const c = o.category_name;
                    catCountMap[c] = (catCountMap[c] || 0) + 1;
                });

                const mergedCategories = this.allCategories.map(cat => ({
                    name: cat.name,
                    ordersCount: catCountMap[cat.name] || 0
                }));

                Object.keys(catCountMap).forEach(cName => {
                    if (!mergedCategories.some(mc => mc.name === cName)) {
                        mergedCategories.push({ name: cName, ordersCount: catCountMap[cName] });
                    }
                });

                this.categoryPerformance = mergedCategories.sort((a, b) => b.ordersCount - a.ordersCount);
            },

            generateInsights() {
                const list = [];
                if (this.kpiTotalOrders === 0) {
                    list.push('Tidak ada transaksi pesanan yang tercatat pada rentang periode yang dipilih.');
                    this.insights = list;
                    return;
                }

                list.push(`${this.kpiTotalOrders} pesanan masuk tercatat pada periode ini dengan akumulasi estimasi nilai ${this.formatRupiah(this.kpiTotalRevenue)}.`);

                if (this.topProductsList.length > 0 && this.topProductsList[0].count > 0) {
                    list.push(`Produk dengan pesanan terbanyak adalah "${this.topProductsList[0].name}" (${this.topProductsList[0].count} pesanan).`);
                }

                if (this.topMaterialsList.length > 0 && this.topMaterialsList[0].count > 0) {
                    list.push(`Material kain yang paling sering dipilih pemesan adalah ${this.topMaterialsList[0].name} (${this.topMaterialsList[0].count} kali pemilihan).`);
                }

                if (this.kpiOrdersWithoutPrice > 0) {
                    list.push(`${this.kpiOrdersWithoutPrice} pesanan belum memiliki estimasi harga dan menunggu penetapan harga/kesepakatan spesifikasi.`);
                } else {
                    list.push('Seluruh pesanan pada periode ini telah memiliki estimasi harga yang disepakati.');
                }

                if (this.kpiAvgOrderValue > 0) {
                    list.push(`Rata-rata estimasi nilai pesanan bertarif adalah ${this.formatRupiah(this.kpiAvgOrderValue)}.`);
                }

                this.insights = list;
            },

            async loadAndInitCharts() {
                try {
                    let ChartConstructor = window.Chart;
                    if (!ChartConstructor && typeof window.loadChart === 'function') {
                        ChartConstructor = await window.loadChart();
                    }
                    if (ChartConstructor) {
                        this.chartsReady = true;
                        this.isLoading = false;
                        setTimeout(() => {
                            this.renderCharts();
                        }, 50);
                    } else {
                        this.isLoading = false;
                    }
                } catch (err) {
                    console.error('Failed to load Chart.js:', err);
                    this.isLoading = false;
                }
            },

            renderCharts() {
                const ChartConstructor = window.Chart;
                if (!ChartConstructor) return;

                // Group dates
                const dateMap = {};
                this.filteredOrders.forEach(o => {
                    if (o.date) {
                        if (!dateMap[o.date]) {
                            dateMap[o.date] = {
                                label: o.short_date || o.date,
                                fullDate: o.display_date,
                                ordersCount: 0,
                                revenue: 0
                            };
                        }
                        dateMap[o.date].ordersCount += 1;
                        dateMap[o.date].revenue += (o.total_harga || 0);
                    }
                });

                const sortedDates = Object.keys(dateMap).sort();
                const labels = sortedDates.map(d => dateMap[d].label);
                const fullDates = sortedDates.map(d => dateMap[d].fullDate);
                const ordersCounts = sortedDates.map(d => dateMap[d].ordersCount);
                const revenues = sortedDates.map(d => dateMap[d].revenue);

                // 1. Orders Chart
                const ordersCanvas = document.getElementById('analyticsOrdersChart');
                if (ordersCanvas) {
                    if (this.ordersChartInstance) {
                        this.ordersChartInstance.destroy();
                        this.ordersChartInstance = null;
                    }

                    if (sortedDates.length > 0) {
                        this.ordersChartInstance = new ChartConstructor(ordersCanvas, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Pesanan',
                                    data: ordersCounts,
                                    borderColor: '#B8664A',
                                    backgroundColor: 'rgba(184, 102, 74, 0.08)',
                                    fill: true,
                                    tension: 0.3,
                                    borderWidth: 2,
                                    pointBackgroundColor: '#B8664A',
                                    pointBorderColor: '#FFFFFF',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1C2430',
                                        titleFont: { size: 12, weight: '600' },
                                        bodyFont: { size: 12 },
                                        padding: 10,
                                        cornerRadius: 6,
                                        callbacks: {
                                            title: function(items) {
                                                return fullDates[items[0].dataIndex] || items[0].label;
                                            },
                                            label: function(item) {
                                                return item.raw + ' pesanan masuk';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { size: 11 }, color: '#667085' }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: '#E2E5E9', borderDash: [3, 3] },
                                        ticks: {
                                            precision: 0,
                                            font: { size: 11 },
                                            color: '#667085',
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });
                    }
                }

                // 2. Revenue Chart
                const revenueCanvas = document.getElementById('analyticsRevenueChart');
                if (revenueCanvas) {
                    if (this.revenueChartInstance) {
                        this.revenueChartInstance.destroy();
                        this.revenueChartInstance = null;
                    }

                    if (sortedDates.length > 0) {
                        const self = this;
                        this.revenueChartInstance = new ChartConstructor(revenueCanvas, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Estimasi Nilai Pesanan',
                                    data: revenues,
                                    borderColor: '#1C2430',
                                    backgroundColor: 'rgba(28, 36, 48, 0.05)',
                                    fill: true,
                                    tension: 0.3,
                                    borderWidth: 2,
                                    pointBackgroundColor: '#1C2430',
                                    pointBorderColor: '#FFFFFF',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1C2430',
                                        titleFont: { size: 12, weight: '600' },
                                        bodyFont: { size: 12 },
                                        padding: 10,
                                        cornerRadius: 6,
                                        callbacks: {
                                            title: function(items) {
                                                return fullDates[items[0].dataIndex] || items[0].label;
                                            },
                                            label: function(item) {
                                                return 'Estimasi: ' + self.formatRupiah(item.raw);
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { size: 11 }, color: '#667085' }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: '#E2E5E9', borderDash: [3, 3] },
                                        ticks: {
                                            font: { size: 11 },
                                            color: '#667085',
                                            callback: function(value) {
                                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                                if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
                                                return 'Rp ' + value;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            },

            formatRupiah(val) {
                if (val === null || val === undefined || isNaN(val)) return 'Rp 0';
                return 'Rp ' + Math.round(val).toLocaleString('id-ID');
            }
        };
    }
</script>
@endsection
