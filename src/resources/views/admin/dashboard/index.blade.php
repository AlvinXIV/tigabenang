@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page-title', 'Ringkasan & Statistik Vendor')

@section('content')
<div class="space-y-8">

    <!-- ============================================== -->
    <!-- 1. TOP METRIC STATS CARDS                      -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Metric 1: Total Produk -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Katalog Produk</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $metrics['total_products'] }}</h3>
                    <p class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1 mt-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>+4 produk bulan ini</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-600"></div>
        </div>

        <!-- Metric 2: Pesanan Masuk -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pesanan & Permintaan</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $metrics['total_orders'] }}</h3>
                    <p class="text-[11px] text-amber-600 font-semibold flex items-center gap-1 mt-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>{{ $metrics['pending_orders_count'] }} pesanan baru masuk</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
        </div>

        <!-- Metric 3: Model 3D Aktif -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Model 3D Fitting</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $metrics['active_models_3d'] }}</h3>
                    <p class="text-[11px] text-cyan-600 font-semibold flex items-center gap-1 mt-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Siap Virtual Fitting</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-cyan-500"></div>
        </div>

        <!-- Metric 4: Estimasi Omzet / Nilai Pesanan -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Estimasi Nilai Order</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $metrics['estimated_revenue'] }}</h3>
                    <p class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1 mt-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>+18.4% vs bulan lalu</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 2. ANALYTICS CHART & QUICK SHORTCUTS           -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Order Trends Chart (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Tren Pemesanan & Volume Produksi (2026)</h3>
                    <p class="text-xs text-slate-500">Statistik jumlah pesanan konveksi dan fitting simulasi per bulan</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-600 font-medium px-2.5 py-1 rounded-lg bg-slate-100">
                        <span class="w-2 h-2 rounded-full bg-indigo-600"></span> Pesanan Masuk
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-600 font-medium px-2.5 py-1 rounded-lg bg-slate-100">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span> Virtual Fitting (Pengguna)
                    </span>
                </div>
            </div>

            <!-- Canvas for Chart.js -->
            <div class="h-64 sm:h-72 w-full">
                <canvas id="ordersAnalyticsChart"></canvas>
            </div>
        </div>

        <!-- Quick Shortcuts & Popular Products (1 Column) -->
        <div class="space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
                <h3 class="text-base font-bold text-white mb-1">Aksi Cepat Admin</h3>
                <p class="text-xs text-slate-300 mb-5">Pintasan praktis untuk mengelola operasional konveksi</p>

                <div class="space-y-2.5 relative">
                    <a href="{{ route('admin.produk.create') }}" class="flex items-center justify-between px-3.5 py-2.5 bg-white/10 hover:bg-white/20 active:bg-white/25 rounded-xl text-xs font-semibold text-white transition-colors border border-white/10">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Produk Baru
                        </span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('admin.model-3d.index') }}" class="flex items-center justify-between px-3.5 py-2.5 bg-white/10 hover:bg-white/20 active:bg-white/25 rounded-xl text-xs font-semibold text-white transition-colors border border-white/10">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Unggah Model 3D (.glb)
                        </span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('admin.ukuran.index') }}" class="flex items-center justify-between px-3.5 py-2.5 bg-white/10 hover:bg-white/20 active:bg-white/25 rounded-xl text-xs font-semibold text-white transition-colors border border-white/10">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Update Matriks Ukuran (cm)
                        </span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Popular Products Summary -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Produk Terfavorit</h3>
                    <a href="{{ route('admin.produk.index') }}" class="text-xs text-indigo-600 font-semibold hover:underline">Semua</a>
                </div>
                <div class="space-y-3">
                    @foreach ($popularProducts as $item)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $item['name'] }}</p>
                                <span class="text-[11px] text-slate-500">{{ $item['category'] }} • {{ $item['orders'] }} pesanan</span>
                            </div>
                            @if ($item['3d_ready'])
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-cyan-100 text-cyan-800 border border-cyan-200">3D Ready</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. RECENT ORDERS TABLE                         -->
    <!-- ============================================== -->
    <x-card
        title="Daftar Permintaan & Pesanan Terbaru"
        subtitle="5 permintaan pesanan kustom terakhir yang masuk dari customer"
    >
        <x-slot:action>
            <x-button variant="outline" size="sm" href="{{ route('admin.pesanan.index') }}">
                Lihat Semua Pesanan ({{ $metrics['total_orders'] }})
            </x-button>
        </x-slot:action>

        <div class="overflow-x-auto -mx-6 -my-6">
            <x-table :headers="['Kode & Tanggal', 'Customer / Instansi', 'Produk & Spek', 'Qty', 'Total Harga', 'Status', 'Aksi']">
                @foreach ($recentOrders as $order)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold text-indigo-600 block">{{ $order['order_code'] }}</span>
                            <span class="text-[11px] text-slate-400">{{ $order['date'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $order['customer_name'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-slate-800">{{ $order['product_name'] }}</p>
                            <span class="text-[11px] text-slate-500">Ukuran: {{ $order['size'] }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold text-slate-800">{{ $order['quantity'] }} pcs</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">
                            {{ $order['total_price'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($order['status'] === 'pending')
                                <x-badge variant="amber" dot="true">Menunggu Review</x-badge>
                            @elseif ($order['status'] === 'confirmed')
                                <x-badge variant="sky">Dikonfirmasi</x-badge>
                            @elseif ($order['status'] === 'in_production')
                                <x-badge variant="indigo" dot="true">Diproses Produksi</x-badge>
                            @elseif ($order['status'] === 'completed')
                                <x-badge variant="emerald">Selesai</x-badge>
                            @else
                                <x-badge variant="rose">Dibatalkan</x-badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center gap-2">
                                <x-button variant="secondary" size="xs" href="{{ route('admin.pesanan.show', $order['id']) }}">
                                    Detail
                                </x-button>
                                <x-button variant="outline" size="xs" href="{{ route('admin.orders.invoice', $order['id']) }}">
                                    Invoice
                                </x-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </x-card>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('ordersAnalyticsChart');
    if (ctx && window.Chart) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu (Bulan Ini)'],
                datasets: [
                    {
                        label: 'Pesanan Masuk (pcs/batch)',
                        data: [12, 19, 15, 26, 22, 34, 38, 45],
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.08)',
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    },
                    {
                        label: 'Virtual Fitting Room Hits',
                        data: [25, 45, 60, 95, 120, 165, 210, 280],
                        borderColor: '#06b6d4',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        tension: 0.35,
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
