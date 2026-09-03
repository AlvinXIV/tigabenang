@extends('layouts.admin')

@section('title', 'Tambah Pesanan Manual')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] inline-flex items-center gap-1.5 mb-2 transition-colors text-decoration-none font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Daftar Pesanan</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1C2430] tracking-tight">Tambah Pesanan Manual</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Catat pesanan garmen yang masuk secara offline atau kesepakatan langsung via WhatsApp.
            </p>
        </div>
    </div>

    <form
        action="{{ route('admin.pesanan.store') }}"
        method="POST"
        class="space-y-6"
        x-data="{ isSubmitting: false }"
        @submit="isSubmitting = true"
    >
        @csrf

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
                        name="nama"
                        value="{{ old('nama') }}"
                        required
                        placeholder="Contoh: Budi Pratama"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
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
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        required
                        placeholder="Contoh: 08123456789"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    @error('no_hp')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Alamat Pengiriman Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="2"
                        required
                        placeholder="Alamat jalan, kelurahan, kecamatan, kota/kabupaten"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: PRODUK & BAHAN -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">2. Pilihan Produk &amp; Bahan Kain</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="produk_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Pilih Produk <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="produk_id"
                        name="produk_id"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    >
                        <option value="" disabled {{ old('produk_id') ? '' : 'selected' }}>Pilih produk dari katalog...</option>
                        @foreach ($products as $prod)
                            <option value="{{ $prod->id_produk }}" {{ old('produk_id') == $prod->id_produk ? 'selected' : '' }}>
                                {{ $prod->nama_produk }} — Rp {{ number_format($prod->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('produk_id')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Pilihan Material Kain
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        @foreach ($materials as $mat)
                            <label class="flex items-center gap-2.5 p-2.5 border border-[#E2E5E9] rounded-lg hover:bg-[#F7F7F5] cursor-pointer transition-colors">
                                <input
                                    type="checkbox"
                                    name="bahan_ids[]"
                                    value="{{ $mat->id_bahan }}"
                                    class="rounded text-[#B8664A] focus:ring-[#B8664A]"
                                    {{ is_array(old('bahan_ids')) && in_array($mat->id_bahan, old('bahan_ids')) ? 'checked' : '' }}
                                />
                                <span class="text-xs text-[#1C2430] font-medium">{{ $mat->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: UKURAN & ESTIMASI HARGA -->
        <div class="admin-card p-5 sm:p-6 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3">
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">3. Rincian Ukuran &amp; Estimasi Harga</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Kuantitas Pakaian per Ukuran (Pcs)
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($sizes as $sz)
                            <div class="p-3 border border-[#E2E5E9] bg-[#F7F7F5] rounded-lg">
                                <span class="text-xs font-semibold text-[#1C2430] block">{{ $sz->nama_ukuran }}</span>
                                <input
                                    type="number"
                                    name="ukuran[{{ $sz->id_ukuran }}]"
                                    min="0"
                                    value="{{ old('ukuran.' . $sz->id_ukuran, 0) }}"
                                    class="w-full mt-1.5 px-2.5 py-1.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs font-semibold text-center rounded-md focus:outline-none"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="total_harga" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Estimasi Harga Disepakati (Opsional)
                    </label>
                    <div class="relative max-w-sm">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs font-semibold text-[#667085] pointer-events-none">Rp</span>
                        <input
                            type="number"
                            id="total_harga"
                            name="total_harga"
                            value="{{ old('total_harga') }}"
                            step="1000"
                            placeholder="Biarkan kosong jika belum disepakati"
                            class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                        />
                    </div>
                    <p class="text-[11px] text-[#667085] mt-1">Kosongkan kolom ini jika harga belum disepakati (status akan menjadi "Menunggu Penetapan Harga").</p>
                </div>

                <div>
                    <label for="notes" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Catatan Pesanan / Spesifikasi Tambahan
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="2"
                        placeholder="Catatan sablon, bordir logo, atau instruksi khusus pemesan"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D0D5DD] focus:border-[#B8664A] focus:ring-2 focus:ring-[#B8664A]/20 text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    >{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary px-4 py-2 text-xs sm:text-sm">
                Batal
            </a>
            <button
                type="submit"
                :disabled="isSubmitting"
                class="btn-primary px-5 py-2 text-xs sm:text-sm font-medium"
            >
                <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Pesanan'"></span>
            </button>
        </div>

    </form>

</div>
@endsection

