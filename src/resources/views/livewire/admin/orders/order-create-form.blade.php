<div class="space-y-6 max-w-4xl mx-auto">

    <!-- TOP HEADER -->
    <div class="pb-5 border-b border-[#E2E5E9]">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Tambah Pesanan Manual</h1>
        <p class="text-xs sm:text-sm text-[#667085] mt-1">
            Catat pesanan garmen yang masuk secara offline atau kesepakatan langsung via WhatsApp.
        </p>
    </div>

    <form id="order-create-form" wire:submit="save" class="space-y-6">

        <!-- SECTION 1: PELANGGAN -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">1. Data Pelanggan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nama Pemesan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        wire:model="nama"
                        required
                        placeholder="Contoh: Budi Pratama"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                    />
                    @error('nama')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="no_hp"
                        wire:model="no_hp"
                        required
                        placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none font-mono"
                    />
                    @error('no_hp')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Alamat Pengiriman <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="alamat"
                        wire:model="alamat"
                        rows="2"
                        required
                        placeholder="Alamat lengkap tujuan pengiriman pesanan..."
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                    ></textarea>
                    @error('alamat')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: PRODUK & BAHAN -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">2. Produk &amp; Bahan Kain</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="produk_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Pilih Produk <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="produk_id"
                        wire:model="produk_id"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                    >
                        <option value="">Pilih Produk Busana...</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id_produk }}">
                                {{ $p->nama_produk }} (Rp {{ number_format($p->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('produk_id')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#1C2430] mb-2">
                        Pilih Material Kain Terkait
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        @foreach ($materials as $m)
                            <label class="flex items-center gap-2 p-2 border border-[#E2E5E9] rounded-lg hover:bg-[#F7F7F5] cursor-pointer text-xs">
                                <input
                                    type="checkbox"
                                    wire:model="bahan_ids"
                                    value="{{ $m->id_bahan }}"
                                    class="rounded text-[#102A43] focus:ring-[#102A43]"
                                />
                                <span class="truncate text-[#1C2430]">{{ $m->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#1C2430] mb-2">
                        Kuantitas Berdasarkan Ukuran (Pcs)
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($sizes as $s)
                            <div class="p-2.5 border border-[#E2E5E9] rounded-lg bg-[#F7F7F5] space-y-1">
                                <span class="text-xs font-bold text-[#1C2430] block">{{ $s->nama_ukuran }}</span>
                                <input
                                    type="number"
                                    min="0"
                                    wire:model="ukuran.{{ $s->id_ukuran }}"
                                    placeholder="0"
                                    class="w-full px-2 py-1 bg-white border border-[#D0D5DD] rounded text-xs text-center font-mono font-semibold"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: HARGA & CATATAN -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">3. Penetapan Harga &amp; Catatan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="total_harga" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Harga Disepakati (Rp)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-semibold text-[#667085] pointer-events-none">Rp</span>
                        <input
                            type="number"
                            id="total_harga"
                            wire:model="total_harga"
                            min="0"
                            placeholder="Kosongkan jika masih proses negosiasi"
                            class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                        />
                    </div>
                    <p class="text-[11px] text-[#667085] mt-1">Kosongkan jika harga masih dalam tahap negosiasi.</p>
                    @error('total_harga')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="notes" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Catatan Khusus Pesanan
                    </label>
                    <textarea
                        id="notes"
                        wire:model="notes"
                        rows="3"
                        placeholder="Contoh: Bordir logo di dada kiri, sablon plastisol di punggung..."
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none"
                    ></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary px-4 py-2.5 text-xs sm:text-sm">
                Batal
            </a>
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="btn-primary px-6 py-2.5 text-xs sm:text-sm font-medium cursor-pointer shadow-2xs"
            >
                <span wire:loading.remove>Simpan Pesanan</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>

    </form>

</div>
