<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Direktori Pelanggan</span>
            </a>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">{{ $customer['name'] }}</h1>
                @if ($customer['phone'])
                    <span class="text-sm text-[#667085]">•</span>
                    <span class="text-sm font-mono text-[#667085]">{{ $customer['phone'] }}</span>
                @endif
            </div>
        </div>

        @if ($customer['phone'])
            <div>
                <a
                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer['phone']) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors inline-flex items-center gap-2 text-decoration-none shadow-2xs"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                    </svg>
                    <span>Chat via WhatsApp</span>
                </a>
            </div>
        @endif
    </div>

    <!-- ROW 1: 2-COLUMN PROFILE & SUMMARY -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- LEFT (2/3): PROFIL PEMESAN -->
        <div class="lg:col-span-2 admin-card p-5 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Profil Pemesan</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div>
                    <span class="text-[#667085] block text-xs">Nama Pelanggan:</span>
                    <p class="font-semibold text-[#1C2430] mt-0.5">{{ $customer['name'] }}</p>
                </div>
                <div>
                    <span class="text-[#667085] block text-xs">Nomor WhatsApp:</span>
                    <p class="font-mono text-xs text-[#1C2430] mt-0.5">{{ $customer['phone'] ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-[#667085] block text-xs mb-1">Alamat Pengiriman:</span>
                    <p class="p-3 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg leading-relaxed text-xs text-[#1C2430]">
                        {{ $customer['address'] ?? 'Alamat pengiriman belum dicantumkan.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT (1/3): SUMMARY TRANSAKSI -->
        <div class="admin-card p-5 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Ringkasan Pelanggan</h2>
            </div>

            <div class="space-y-3">
                <div class="p-3.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg flex items-center justify-between">
                    <span class="text-xs text-[#667085]">Total Pesanan</span>
                    <span class="text-lg font-semibold text-[#1C2430]">{{ $customer['total_orders'] }}</span>
                </div>

                <div class="p-3.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg flex items-center justify-between">
                    <span class="text-xs text-[#667085]">Total Estimasi</span>
                    <span class="text-lg font-semibold text-[#1C2430] font-mono">
                        {{ $customer['total_spent'] ? 'Rp ' . number_format($customer['total_spent'], 0, ',', '.') : 'Rp 0' }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- ROW 2: FULL-WIDTH ORDER HISTORY TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="px-5 py-3.5 border-b border-[#E2E5E9] bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm sm:text-base font-semibold text-[#1C2430]">Riwayat Pesanan Pelanggan</h3>
                <span class="text-xs text-[#667085]">{{ count($customer['orders']) }} pesanan tercatat</span>
            </div>

            <div class="relative w-full sm:max-w-xs">
                <input
                    type="text"
                    wire:model.live.debounce.250ms="orderSearch"
                    placeholder="Filter ID pesanan / produk..."
                    class="w-full px-3 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] text-xs text-[#1C2430] rounded-lg focus:outline-none"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3 font-mono">ID Pesanan</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3 text-center">Total Kuantitas</th>
                        <th class="px-4 py-3 font-mono">Estimasi Harga</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right w-20 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($orders as $ord)
                        @php
                            $totalQty = $ord->ukuran ? $ord->ukuran->sum('pivot.kuantitas') : 0;
                        @endphp
                        <tr class="admin-table-row">
                            <td class="px-4 py-3.5 font-mono text-xs font-semibold text-[#1C2430] whitespace-nowrap">
                                #ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap text-xs">
                                {{ $ord->created_at ? $ord->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-[#1C2430] whitespace-nowrap">
                                {{ $ord->produk ? $ord->produk->nama_produk : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-center whitespace-nowrap font-medium text-[#1C2430]">
                                <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs font-semibold">
                                    {{ $totalQty }} pcs
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs whitespace-nowrap">
                                @if ($ord->total_harga)
                                    <span class="font-medium text-[#1C2430]">Rp {{ number_format($ord->total_harga, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[#667085] italic">Belum Ada Estimasi</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($ord->total_harga)
                                    <x-badge variant="success">Harga Disepakati</x-badge>
                                @else
                                    <x-badge variant="warning">Menunggu Penetapan</x-badge>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi pesanan #ORD-' . str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT)">
                                    <x-action-menu.item href="{{ route('admin.pesanan.show', $ord->id_pemesanan) }}">
                                        Lihat Detail
                                    </x-action-menu.item>

                                    <x-action-menu.item href="{{ route('admin.orders.invoice', $ord->id_pemesanan) }}" target="_blank">
                                        Lihat Faktur
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-xs text-[#667085]">
                                Tidak ada data pesanan yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
