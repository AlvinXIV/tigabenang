<div class="space-y-6">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#667085] hover:text-[#102A43] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Pesanan</span>
            </a>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl sm:text-[26px] font-semibold text-[#102A43] tracking-tight">
                    #ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                </h1>
                <span class="text-sm text-[#667085]">•</span>
                <span class="text-sm font-medium text-[#102A43]">{{ $order->nama }}</span>
                @if ($order->isSelesai())
                    <x-badge variant="success">
                        Pesanan Selesai
                    </x-badge>
                @endif
                @if ($order->isLunas())
                    <x-badge variant="success" dot>
                        Sudah Lunas
                    </x-badge>
                @elseif ($order->isSudahDp())
                    <x-badge variant="info" dot>
                        Sudah DP
                    </x-badge>
                @else
                    <x-badge variant="slate" dot>
                        Belum Bayar
                    </x-badge>
                @endif
            </div>
            <p class="text-xs text-[#667085] mt-1">Diterima pada: {{ $order->created_at ? $order->created_at->format('d M Y, H:i') . ' WIB' : '-' }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            @if ($order->isSelesai())
                <button
                    type="button"
                    wire:click="revertToActive"
                    wire:confirm="Kembalikan pesanan ini ke Pesanan Masuk?"
                    class="btn-secondary px-3.5 py-2 text-xs sm:text-sm gap-1.5"
                >
                    <svg class="w-4 h-4 text-[#667085]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    <span>Kembalikan ke Masuk</span>
                </button>
            @else
                @if ($order->isLunas())
                    <button
                        type="button"
                        wire:click="markAsCompleted"
                        wire:confirm="Tandai pesanan ini sebagai selesai?"
                        class="btn-secondary px-3.5 py-2 text-xs sm:text-sm gap-1.5 text-emerald-700 hover:text-emerald-800 hover:border-emerald-300"
                    >
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Tandai Selesai</span>
                    </button>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg border border-[#E2E5E9] bg-[#F7F7F5] text-xs sm:text-sm text-[#98A2B3] cursor-not-allowed select-none" title="Tandai pembayaran lunas terlebih dahulu">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Selesai (butuh lunas)</span>
                    </span>
                @endif
            @endif

            <a
                href="{{ route('admin.orders.invoice', $order->id_pemesanan) }}"
                target="_blank"
                class="btn-secondary px-3.5 py-2 text-xs sm:text-sm gap-1.5"
            >
                <svg class="w-4 h-4 text-[#667085]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak Faktur</span>
            </a>

            @if ($order->no_hp)
                <a
                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->no_hp) }}?text={{ rawurlencode('Halo ' . $order->nama . ', kami dari Tigabenang ingin mendiskusikan pesanan custom Anda #ORD-' . str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT)) }}"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-medium transition-colors text-decoration-none shadow-2xs"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                    </svg>
                    <span>Hubungi via WhatsApp</span>
                </a>
            @endif
        </div>
    </div>

    <!-- FLASH NOTIFICATION -->
    @if ($feedbackMessage)
        <div class="p-3.5 rounded-lg {{ $feedbackError ? 'bg-red-50 border border-red-200 text-red-800' : 'bg-emerald-50 border border-emerald-200 text-emerald-800' }} text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if ($feedbackError)
                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 003-2.6L16.94 4a2 2 0 00-3.88 0L3 16.4A2 2 0 005.07 19z"></path>
                    </svg>
                @else
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @endif
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="dismissFeedback" class="{{ $feedbackError ? 'text-red-600 hover:text-red-800' : 'text-emerald-600 hover:text-emerald-800' }} text-xs font-semibold">&times;</button>
        </div>
    @endif

    <!-- MAIN 2-COLUMN LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- LEFT 2 COLS: ORDER ITEMS, MATRIX & ARTWORK -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Rincian Produk & Spesifikasi -->
            <div class="admin-card p-5 space-y-4">
                <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                    <h2 class="text-sm sm:text-base font-semibold text-[#102A43]">Rincian Pesanan</h2>
                    <span class="text-xs text-[#667085]">Spesifikasi Busana</span>
                </div>

                <div class="space-y-4 text-xs sm:text-sm">
                    <!-- Produk & Kategori -->
                    <div class="flex items-center justify-between pb-3.5 border-b border-[#E2E5E9]">
                        <div>
                            <span class="text-[#667085] text-xs block">Kategori yang Dipesan:</span>
                            <span class="font-semibold text-sm sm:text-base text-[#102A43] mt-0.5 block">
                                {{ $order->categoryDisplayName() }}
                            </span>
                        </div>
                        @if ($order->produk && $order->produk->kategori)
                            <span class="text-xs bg-[#F7F7F5] border border-[#E2E5E9] px-2.5 py-1 rounded-md text-[#667085]">
                                {{ $order->categoryDisplayName() }}
                            </span>
                        @endif
                    </div>

                    <!-- Material Kain -->
                    <div class="pb-3.5 border-b border-[#E2E5E9]">
                        <span class="text-[#667085] text-xs block mb-1.5">Material Kain Terpilih:</span>
                        <div class="flex flex-wrap gap-2">
                            @forelse ($order->bahan as $b)
                                <span class="px-2.5 py-1 bg-[#F7F7F5] border border-[#E2E5E9] text-xs rounded-md text-[#102A43] font-medium inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#102A43]"></span>
                                    {{ $b->nama_bahan }}
                                </span>
                            @empty
                                <span class="text-[#98A2B3] italic text-xs">Belum ada spesifikasi bahan khusus.</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Breakdown Ukuran & Kuantitas -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[#667085] text-xs font-medium">Kuantitas per Ukuran:</span>
                            <span class="text-xs font-semibold text-[#102A43]">
                                Total: {{ $order->ukuran ? $order->ukuran->sum('pivot.kuantitas') : 0 }} pcs
                            </span>
                        </div>
                        <div class="border border-[#E2E5E9] rounded-lg overflow-hidden">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-[#F7F7F5] text-[11px] font-semibold text-[#667085] uppercase tracking-wider border-b border-[#E2E5E9]">
                                        <th class="p-2.5 sm:p-3">Ukuran</th>
                                        <th class="p-2.5 sm:p-3 text-right">Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                                    @forelse ($order->ukuran as $uk)
                                        <tr>
                                            <td class="p-2.5 sm:p-3 font-semibold text-[#102A43]">{{ $uk->nama_ukuran }}</td>
                                            <td class="p-2.5 sm:p-3 text-right font-medium text-[#102A43]">{{ $uk->pivot->kuantitas }} pcs</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="p-3 text-center text-[#667085]">Tidak ada rincian ukuran.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($order->notes)
                        <div class="pt-2">
                            <span class="text-[#667085] text-xs block mb-1">Catatan Pemesan:</span>
                            <p class="p-3 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg text-xs leading-relaxed text-[#102A43] italic">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Upload Design Artwork Card -->
            <div class="admin-card p-5 space-y-3">
                <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                    <h2 class="text-sm sm:text-base font-semibold text-[#102A43]">Desain / Artwork Terlampir</h2>
                    <span class="text-xs text-[#667085]">Lampiran</span>
                </div>

                @if ($order->upload_design)
                    @php
                        $fileExt = strtolower(pathinfo($order->upload_design, PATHINFO_EXTENSION));
                        $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                        $fileUrl = \App\Support\CustomerMedia::imageUrl($order->upload_design) ?? asset('storage/' . $order->upload_design);
                    @endphp

                    <div class="p-4 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            @if ($isImage)
                                <a href="{{ $fileUrl }}" target="_blank" class="block shrink-0">
                                    <img src="{{ $fileUrl }}" alt="Desain Pemesan" class="w-16 h-16 object-cover rounded-lg border border-[#E2E5E9] shadow-2xs hover:opacity-90 transition-opacity">
                                </a>
                            @else
                                <div class="w-14 h-14 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-semibold text-[#102A43] truncate">
                                    {{ basename($order->upload_design) }}
                                </p>
                                <p class="text-[11px] text-[#667085] mt-0.5 uppercase font-medium">Format: {{ $fileExt ?: 'Berkas' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-stretch sm:self-auto justify-end shrink-0">
                            <a
                                href="{{ $fileUrl }}"
                                target="_blank"
                                class="btn-secondary px-3 py-1.5 text-xs inline-flex items-center gap-1.5"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Buka Berkas</span>
                            </a>
                            <a
                                href="{{ $fileUrl }}"
                                download
                                class="btn-primary px-3 py-1.5 text-xs inline-flex items-center gap-1.5"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span>Unduh</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-[#F7F7F5] border border-dashed border-[#E2E5E9] rounded-lg text-center text-xs text-[#667085]">
                        Pemesan tidak mengunggah file desain (desain polos atau dikirim langsung melalui WhatsApp).
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT 1 COL: CUSTOMER DETAILS & ESTIMATED PRICING -->
        <div class="space-y-6">
            
            <!-- Customer Summary Card -->
            <div class="admin-card p-5 space-y-3.5">
                <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                    <h2 class="text-sm sm:text-base font-semibold text-[#102A43]">Informasi Pelanggan</h2>
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            wire:click="openEditCustomer"
                            class="text-xs text-[#102A43] hover:underline font-medium cursor-pointer"
                        >
                            Ubah
                        </button>
                        @if ($order->no_hp)
                            <span class="text-gray-300">•</span>
                            <a
                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->no_hp) }}"
                                target="_blank"
                                class="text-xs text-emerald-700 hover:underline font-medium inline-flex items-center gap-1 text-decoration-none"
                            >
                                Chat WA
                            </a>
                        @endif
                    </div>
                </div>

                <div class="space-y-3 text-xs sm:text-sm">
                    <div>
                        <span class="text-[#667085] text-xs block">Nama Pemesan:</span>
                        <span class="font-semibold text-[#102A43] mt-0.5 block">{{ $order->nama }}</span>
                    </div>

                    <div>
                        <span class="text-[#667085] text-xs block">Nomor WhatsApp:</span>
                        <span class="font-mono text-xs text-[#102A43] mt-0.5 block">{{ $order->no_hp ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="text-[#667085] text-xs block mb-1">Alamat Pengiriman:</span>
                        <p class="p-3 bg-[#F7F7F5] border border-[#E2E5E9] rounded-lg text-[#102A43] leading-relaxed text-xs">{{ $order->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Price Agreement Card -->
            <div class="admin-card p-5 space-y-4">
                <div class="border-b border-[#E2E5E9] pb-3">
                    <h2 class="text-sm sm:text-base font-semibold text-[#102A43]">Kesepakatan Harga</h2>
                </div>

                @php
                    $totalQty = $order->ukuran ? $order->ukuran->sum('pivot.kuantitas') : 0;
                    $estimasiAwal = (float) ($order->produk?->harga ?? 0) * $totalQty;
                @endphp

                <div class="bg-[#F7F7F5] p-3.5 rounded-lg border border-[#E2E5E9] space-y-2">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-[#667085]">Estimasi Awal Customer:</span>
                        <span class="font-semibold text-[#102A43] font-mono">Rp {{ number_format($estimasiAwal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs pt-2 border-t border-[#E2E5E9]">
                        <span class="text-[#667085]">{{ $order->total_harga ? 'Harga Disepakati (Final):' : 'Harga Disepakati:' }}</span>
                        <span class="font-semibold font-mono {{ $order->total_harga ? 'text-emerald-700 text-sm' : 'text-amber-700' }}">
                            {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Belum ditetapkan' }}
                        </span>
                    </div>
                    <div class="text-[11px] text-[#667085] pt-1">
                        Status: <strong class="{{ $order->total_harga ? 'text-emerald-700' : 'text-amber-700' }}">{{ $order->total_harga ? 'Harga Disepakati' : 'Menunggu Penetapan Harga' }}</strong>
                    </div>
                </div>

                <form wire:submit="updatePrice" class="space-y-3.5 pt-1">
                    <div>
                        <label for="total_harga" class="block text-xs font-semibold text-[#102A43] mb-1.5">
                            Harga Disepakati (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-semibold text-[#667085] pointer-events-none">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="total_harga"
                                wire:model="total_harga"
                                step="1000"
                                placeholder="Contoh: 350000"
                                class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] focus:ring-2 focus:ring-[#102A43]/20 text-xs sm:text-sm font-semibold text-[#102A43] rounded-lg focus:outline-none transition-colors"
                                required
                            />
                        </div>
                        @error('total_harga')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="btn-primary w-full py-2.5 text-xs sm:text-sm font-medium cursor-pointer shadow-2xs"
                    >
                        <span wire:loading.remove>{{ $order->total_harga ? 'Simpan Harga Disepakati' : 'Tetapkan Harga' }}</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </form>

                <!-- STATUS PEMBAYARAN -->
                <div class="pt-4 border-t border-[#E2E5E9] space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-semibold text-[#102A43]">Status Pembayaran:</span>
                        @if ($order->isLunas())
                            <x-badge variant="success" dot>Sudah Lunas</x-badge>
                        @elseif ($order->isSudahDp())
                            <x-badge variant="info" dot>Sudah DP</x-badge>
                        @else
                            <x-badge variant="slate" dot>Belum Bayar</x-badge>
                        @endif
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 pt-1">
                        <button
                            type="button"
                            wire:click="setPaymentStatus('belum_bayar')"
                            class="py-1.5 px-2 text-[11px] font-medium rounded-lg border transition-colors cursor-pointer {{ $order->isBelumBayar() ? 'bg-slate-700 text-white border-slate-700' : 'bg-white text-[#667085] border-[#E2E5E9] hover:bg-[#F7F7F5]' }}"
                        >
                            Belum Bayar
                        </button>
                        <button
                            type="button"
                            wire:click="setPaymentStatus('sudah_dp')"
                            class="py-1.5 px-2 text-[11px] font-medium rounded-lg border transition-colors cursor-pointer {{ $order->isSudahDp() ? 'bg-sky-600 text-white border-sky-600' : 'bg-white text-[#667085] border-[#E2E5E9] hover:bg-[#F7F7F5]' }}"
                        >
                            Sudah DP
                        </button>
                        <button
                            type="button"
                            wire:click="setPaymentStatus('lunas')"
                            class="py-1.5 px-2 text-[11px] font-medium rounded-lg border transition-colors cursor-pointer {{ $order->isLunas() ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-[#667085] border-[#E2E5E9] hover:bg-[#F7F7F5]' }}"
                        >
                            Sudah Lunas
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- EDIT CUSTOMER MODAL -->
    @if ($editCustomerOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-[#E2E5E9] pb-3">
                    <h3 class="font-semibold text-sm sm:text-base text-[#102A43]">Ubah Informasi Pelanggan</h3>
                    <button type="button" wire:click="$set('editCustomerOpen', false)" class="text-gray-400 hover:text-gray-600 text-sm font-bold">&times;</button>
                </div>

                <form wire:submit="saveCustomer" class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-[#102A43] mb-1">Nama Lengkap</label>
                        <input type="text" wire:model="edit_nama" required class="w-full px-3 py-2 text-xs border border-[#D0D5DD] rounded-lg" />
                        @error('edit_nama') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#102A43] mb-1">Nomor WhatsApp</label>
                        <input type="text" wire:model="edit_no_hp" required class="w-full px-3 py-2 text-xs border border-[#D0D5DD] rounded-lg font-mono" />
                        @error('edit_no_hp') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#102A43] mb-1">Alamat Pengiriman</label>
                        <textarea wire:model="edit_alamat" rows="2" required class="w-full px-3 py-2 text-xs border border-[#D0D5DD] rounded-lg"></textarea>
                        @error('edit_alamat') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#102A43] mb-1">Catatan</label>
                        <textarea wire:model="edit_notes" rows="2" class="w-full px-3 py-2 text-xs border border-[#D0D5DD] rounded-lg"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#E2E5E9]">
                        <button type="button" wire:click="$set('editCustomerOpen', false)" class="btn-secondary px-3 py-1.5 text-xs">Batal</button>
                        <button type="submit" class="btn-primary px-4 py-1.5 text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
