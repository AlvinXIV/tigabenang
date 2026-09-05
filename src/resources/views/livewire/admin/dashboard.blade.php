<div class="space-y-6">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH / REFRESH               -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Ikhtisar Dashboard</h1>
                <span wire:loading class="inline-flex items-center gap-1.5 text-xs text-[#B8664A] font-medium bg-[#B8664A]/10 px-2 py-0.5 rounded-full">
                    <svg class="animate-spin w-3 h-3 text-[#B8664A]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Sinkronisasi...
                </span>
            </div>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Pantau pesanan, penetapan harga, dan kesiapan katalog secara langsung.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.analytics') }}"
                class="btn-secondary px-3.5 py-1.5 text-xs sm:text-sm gap-2"
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
                @if(!empty($search))
                    <span class="text-xs text-[#667085] bg-[#F7F7F5] px-2 py-0.5 rounded border border-[#E2E5E9]">Filter: "{{ $search }}"</span>
                @endif
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
                        <th class="px-5 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
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
                                <x-action-menu :label="'Menu aksi pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT)">
                                    <x-action-menu.item href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}">
                                        Lihat Detail
                                    </x-action-menu.item>

                                    <x-action-menu.item href="{{ route('admin.orders.invoice', $order->id_pemesanan) }}" target="_blank">
                                        Lihat Faktur
                                    </x-action-menu.item>

                                    @if ($order->no_hp)
                                        @php
                                            $cleanWa = preg_replace('/[^0-9]/', '', $order->no_hp);
                                            if (str_starts_with($cleanWa, '0')) {
                                                $cleanWa = '62' . substr($cleanWa, 1);
                                            }
                                        @endphp
                                        <x-action-menu.item href="https://wa.me/{{ $cleanWa }}?text=Halo%20{{ urlencode($order->nama) }}%2C%20terkait%20pesanan%20Tigabenang%20%23ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}" target="_blank">
                                            Hubungi WhatsApp
                                        </x-action-menu.item>
                                    @endif
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-xs text-[#667085]">
                                @if(!empty($search))
                                    Tidak ada pesanan perlu tindakan yang cocok dengan pencarian "{{ $search }}".
                                @else
                                    Tidak ada pesanan yang memerlukan tindakan saat ini. Semua pesanan telah ditinjau.
                                @endif
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
                        <th class="px-5 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
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
                                <x-action-menu :label="'Menu aksi pesanan #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT)">
                                    <x-action-menu.item href="{{ route('admin.pesanan.show', $order->id_pemesanan) }}">
                                        Lihat Detail
                                    </x-action-menu.item>

                                    <x-action-menu.item href="{{ route('admin.orders.invoice', $order->id_pemesanan) }}" target="_blank">
                                        Lihat Faktur
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-xs text-[#667085]">
                                @if(!empty($search))
                                    Tidak ada pesanan cocok dengan pencarian "{{ $search }}".
                                @else
                                    Belum ada pesanan terbaru tercatat di sistem.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
