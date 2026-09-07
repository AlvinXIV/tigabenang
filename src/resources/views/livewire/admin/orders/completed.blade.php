<div class="space-y-5">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#102A43] tracking-tight">Pesanan Selesai</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Daftar arsip pesanan yang telah rampung dan selesai diproses.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.pesanan.index') }}"
                class="btn-secondary px-3.5 py-2 text-xs sm:text-sm gap-1.5"
            >
                <svg class="w-4 h-4 text-[#667085]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Lihat Pesanan Masuk</span>
            </a>
        </div>
    </div>

    <!-- FLASH FEEDBACK NOTIFICATION -->
    @if ($feedbackMessage)
        <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="dismissFeedback" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold">&times;</button>
        </div>
    @endif

    <!-- SEGMENTED STATUS TABS -->
    <div class="flex items-center border-b border-[#E2E5E9] gap-6 text-xs sm:text-sm overflow-x-auto whitespace-nowrap pb-px">
        <button
            type="button"
            wire:click="filterPayment('all')"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer {{ $paymentFilter === 'all' ? 'border-[#102A43] text-[#102A43] font-semibold' : 'border-transparent text-[#667085] hover:text-[#102A43]' }}"
        >
            <span>Semua Pesanan</span>
            <span class="px-2 py-0.5 rounded-[6px] text-xs font-semibold {{ $paymentFilter === 'all' ? 'bg-[#102A43] text-white' : 'bg-[#EBF1F8] text-[#102A43]' }}">
                {{ $counts['all'] }}
            </span>
        </button>

        <button
            type="button"
            wire:click="filterPayment('belum_bayar')"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer {{ $paymentFilter === 'belum_bayar' ? 'border-[#102A43] text-[#102A43] font-semibold' : 'border-transparent text-[#667085] hover:text-[#102A43]' }}"
        >
            <span>Belum Bayar</span>
            <span class="px-2 py-0.5 rounded-[6px] text-xs font-semibold {{ $paymentFilter === 'belum_bayar' ? 'bg-[#102A43] text-white' : 'bg-[#EBF1F8] text-[#102A43]' }}">
                {{ $counts['belum_bayar'] }}
            </span>
        </button>

        <button
            type="button"
            wire:click="filterPayment('sudah_dp')"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer {{ $paymentFilter === 'sudah_dp' ? 'border-[#102A43] text-[#102A43] font-semibold' : 'border-transparent text-[#667085] hover:text-[#102A43]' }}"
        >
            <span>Sudah DP</span>
            <span class="px-2 py-0.5 rounded-[6px] text-xs font-semibold {{ $paymentFilter === 'sudah_dp' ? 'bg-[#102A43] text-white' : 'bg-[#EBF1F8] text-[#102A43]' }}">
                {{ $counts['sudah_dp'] }}
            </span>
        </button>

        <button
            type="button"
            wire:click="filterPayment('lunas')"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer {{ $paymentFilter === 'lunas' ? 'border-[#102A43] text-[#102A43] font-semibold' : 'border-transparent text-[#667085] hover:text-[#102A43]' }}"
        >
            <span>Sudah Lunas</span>
            <span class="px-2 py-0.5 rounded-[6px] text-xs font-semibold {{ $paymentFilter === 'lunas' ? 'bg-[#102A43] text-white' : 'bg-[#EBF1F8] text-[#102A43]' }}">
                {{ $counts['lunas'] }}
            </span>
        </button>
    </div>

    <!-- TOOLBAR: SEARCH & TOTAL -->
    <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2.5 w-full sm:max-w-lg">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari ID pesanan, pelanggan, atau nomor HP..."
                    class="w-full h-10 pl-9 pr-3.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm text-[#102A43] rounded-lg focus:outline-none transition-colors"
                />
            </div>
            @if (!empty($search) || $paymentFilter !== 'all')
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="h-10 px-3 inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#102A43] hover:bg-[#F7F7F5] border border-transparent hover:border-[#E2E5E9] rounded-lg transition-colors font-medium cursor-pointer shrink-0 whitespace-nowrap"
                >
                    <svg class="w-3.5 h-3.5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Reset Filter</span>
                </button>
            @endif
        </div>

        <div class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
            Total: <strong class="text-[#102A43]">{{ $orders->count() }}</strong> pesanan selesai
        </div>
    </div>

    <!-- FULL-WIDTH MANAGEMENT TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 font-mono whitespace-nowrap">ID Pesanan</th>
                        <th class="px-4 py-3 whitespace-nowrap">Pelanggan</th>
                        <th class="px-4 py-3 whitespace-nowrap">WhatsApp</th>
                        <th class="px-4 py-3 whitespace-nowrap">Produk</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Total Qty</th>
                        <th class="px-4 py-3 font-mono whitespace-nowrap">Harga</th>
                        <th class="px-4 py-3 whitespace-nowrap">Status Pembayaran</th>
                        <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($orders as $ord)
                        @php
                            $totalQty = $ord->ukuran ? $ord->ukuran->sum('pivot.kuantitas') : 0;
                        @endphp
                        <tr class="admin-table-row">
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap text-xs">
                                {{ $ord->created_at ? $ord->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs font-medium text-[#102A43] whitespace-nowrap">
                                #ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-[#102A43] whitespace-nowrap">
                                {{ $ord->nama }}
                            </td>
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap font-mono text-xs">
                                @if ($ord->no_hp)
                                    <a
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ord->no_hp) }}?text={{ rawurlencode('Halo ' . $ord->nama . ', kami dari Tigabenang mengonfirmasi pesanan #ORD-' . str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT)) }}"
                                        target="_blank"
                                        class="text-emerald-700 hover:underline inline-flex items-center gap-1 text-decoration-none"
                                    >
                                        <span>{{ $ord->no_hp }}</span>
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-[#98A2B3]">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-[#102A43] whitespace-nowrap font-medium">
                                {{ $ord->categoryDisplayName() }}
                            </td>
                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs font-semibold text-[#102A43]">
                                    {{ $totalQty }} pcs
                                </span>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap font-mono text-xs">
                                @if ($ord->total_harga)
                                    <span class="font-medium text-[#102A43]">
                                        Rp {{ number_format($ord->total_harga, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-[#98A2B3]">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($ord->isLunas())
                                    <x-badge variant="success" dot>
                                        Sudah Lunas
                                    </x-badge>
                                @elseif ($ord->isSudahDp())
                                    <x-badge variant="info" dot>
                                        Sudah DP
                                    </x-badge>
                                @else
                                    <x-badge variant="slate" dot>
                                        Belum Bayar
                                    </x-badge>
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

                                    <x-action-menu.divider />

                                    @if (!$ord->isSudahDp())
                                        <x-action-menu.item wire:click="setPaymentStatus({{ $ord->id_pemesanan }}, 'sudah_dp')">
                                            Tandai Sudah DP
                                        </x-action-menu.item>
                                    @endif

                                    @if (!$ord->isLunas())
                                        <x-action-menu.item wire:click="setPaymentStatus({{ $ord->id_pemesanan }}, 'lunas')">
                                            Tandai Sudah Lunas
                                        </x-action-menu.item>
                                    @endif

                                    @if (!$ord->isBelumBayar())
                                        <x-action-menu.item wire:click="setPaymentStatus({{ $ord->id_pemesanan }}, 'belum_bayar')">
                                            Tandai Belum Bayar
                                        </x-action-menu.item>
                                    @endif

                                    <x-action-menu.divider />

                                    <x-action-menu.item
                                        wire:click="markAsActive({{ $ord->id_pemesanan }})"
                                        wire:confirm="Kembalikan pesanan #ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }} ke Pesanan Masuk?"
                                    >
                                        Kembalikan ke Pesanan Masuk
                                    </x-action-menu.item>

                                    <x-action-menu.divider />

                                    <x-action-menu.item
                                        danger
                                        wire:click="deleteOrder({{ $ord->id_pemesanan }})"
                                        wire:confirm="Yakin ingin menghapus pesanan #ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }}?"
                                    >
                                        Hapus
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center text-[#667085] text-xs sm:text-sm">
                                @if (!empty($search))
                                    <p class="font-medium text-[#102A43]">Tidak ada pesanan selesai yang sesuai dengan filter pencarian "{{ $search }}".</p>
                                @else
                                    <p class="font-medium text-[#102A43]">Belum ada data pesanan selesai.</p>
                                    <p class="mt-1">Pesanan yang telah ditandai selesai akan tersimpan dan tampil di sini.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
