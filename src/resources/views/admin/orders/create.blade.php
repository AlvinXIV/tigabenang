@extends('layouts.admin')

@section('title', 'Create New Order')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Orders</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Create New Order</h1>
        </div>
    </div>

    <form action="{{ route('admin.pesanan.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- SECTION 1: PELANGGAN -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
            <h2 class="text-base font-medium text-[#1C1917]">Data Pelanggan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        NAMA PELANGGAN <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        required
                        placeholder="Nama lengkap"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                    />
                </div>

                <div>
                    <label for="no_hp" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        NO TELEPON / WHATSAPP <span class="text-[#B85331]">*</span>
                    </label>
                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        required
                        placeholder="08123456789"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        ALAMAT PENGIRIMAN <span class="text-[#B85331]">*</span>
                    </label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        required
                        placeholder="Alamat lengkap pengiriman pesanan"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: PRODUK & BAHAN -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
            <h2 class="text-base font-medium text-[#1C1917]">Produk & Bahan</h2>

            <div class="space-y-4">
                <div>
                    <label for="produk_id" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PRODUK <span class="text-[#B85331]">*</span>
                    </label>
                    <select
                        id="produk_id"
                        name="produk_id"
                        required
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none focus:border-[#B85331]"
                    >
                        <option value="" disabled selected>Pilih Produk</option>
                        @foreach ($products as $prod)
                            <option value="{{ $prod->id_produk }}">{{ $prod->nama_produk }} (Rp {{ number_format($prod->harga, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        PILIHAN BAHAN KAIN
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($materials as $mat)
                            <label class="flex items-center gap-2 p-2.5 border border-[#EADACE] hover:bg-[#FAF7F2] cursor-pointer">
                                <input type="checkbox" name="bahan_ids[]" value="{{ $mat->id_bahan }}" class="rounded-none text-[#B85331]" />
                                <span class="text-xs font-medium text-[#292524]">{{ $mat->nama_bahan }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: UKURAN & TOTAL HARGA -->
        <div class="bg-white border border-[#EADACE] p-6 sm:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
            <h2 class="text-base font-medium text-[#1C1917]">Kuantitas Ukuran & Kesepakatan Harga</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        JUMLAH PER UKURAN
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($sizes as $sz)
                            <div class="p-2.5 border border-[#EADACE] bg-[#FAF7F2]">
                                <span class="text-xs font-mono font-bold text-[#1C1917] block">{{ $sz->nama_ukuran }}</span>
                                <input
                                    type="number"
                                    name="ukuran[{{ $sz->id_ukuran }}]"
                                    min="0"
                                    value="0"
                                    class="w-full mt-1 px-2 py-1 bg-white border border-[#D9CCC1] text-xs font-mono text-center focus:outline-none"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="total_harga" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        TOTAL HARGA DISEPAKATI (OPSIONAL)
                    </label>
                    <div class="relative max-w-md">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-mono text-[#786C62]">Rp</span>
                        <input
                            type="number"
                            id="total_harga"
                            name="total_harga"
                            step="1000"
                            placeholder="Biarkan kosong jika belum disepakati (Waiting Price)"
                            class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-[#D9CCC1] font-mono text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none"
                        />
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        CATATAN PESANAN
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="2"
                        placeholder="Catatan sablon, bordir, atau instruksi khusus"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none"
                    ></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#EADACE]">
            <a href="{{ route('admin.pesanan.index') }}" class="px-5 py-2.5 bg-white border border-[#D9CCC1] text-xs font-mono font-medium uppercase">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#B85331] text-white text-xs font-mono font-medium uppercase hover:bg-[#A34524] cursor-pointer">
                Create Order
            </button>
        </div>

    </form>

</div>
@endsection
