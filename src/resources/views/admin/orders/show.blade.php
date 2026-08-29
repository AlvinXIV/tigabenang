@extends('layouts.admin')

@section('title', 'Order Detail #ORD-' . $order->id_pemesanan)

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#172A39] hover:underline font-black inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider text-decoration-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>&larr; Kembali ke Daftar Orders</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Order #ORD-{{ str_pad($order->id_pemesanan, 4, '0', STR_PAD_LEFT) }}</h1>
                @if ($order->total_harga)
                    <span class="px-3.5 py-1 text-[10px] font-black tracking-wider uppercase bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-full">
                        HARGA DISEPAKATI
                    </span>
                @else
                    <span class="px-3.5 py-1 text-[10px] font-black tracking-wider uppercase bg-amber-100 text-amber-900 border border-amber-300 rounded-full">
                        WAITING PRICE
                    </span>
                @endif
            </div>
            <p class="text-xs text-[#555E68] font-bold mt-1">Dibuat pada: {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.orders.invoice', $order->id_pemesanan) }}"
                class="btn-cream-pill px-6 py-2.5 text-xs uppercase tracking-wider"
            >
                Cetak Invoice
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- LEFT 2 COLS: CUSTOMER & ORDER DETAILS -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Customer Card -->
            <div class="admin-card-rich p-6 space-y-4">
                <h2 class="text-base font-black text-[#172A39]">Informasi Pelanggan</h2>
                <div class="space-y-2 text-xs text-[#172A39]">
                    <div class="flex justify-between border-b border-[#DCD6D0] py-2">
                        <span class="text-[#6E7575] font-bold">Nama Pemesan:</span>
                        <span class="font-black text-sm">{{ $order->nama }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#DCD6D0] py-2">
                        <span class="text-[#6E7575] font-bold">No WhatsApp:</span>
                        <span class="font-black text-sm">{{ $order->no_hp }}</span>
                    </div>
                    <div class="py-2">
                        <span class="text-[#6E7575] font-bold block mb-1">Alamat Pengiriman:</span>
                        <p class="p-3 bg-[#FAF8F5] border border-[#DCD6D0] rounded-xl font-bold leading-relaxed text-[#172A39]">{{ $order->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Product & Quantity Details -->
            <div class="admin-card-rich p-6 space-y-4">
                <h2 class="text-base font-black text-[#172A39]">Rincian Pesanan</h2>
                <div class="space-y-3 text-xs text-[#172A39]">
                    <div class="flex justify-between border-b border-[#DCD6D0] py-2">
                        <span class="text-[#6E7575] font-bold">Produk Pilihan:</span>
                        <span class="font-black text-sm text-[#172A39]">{{ $order->produk ? $order->produk->nama_produk : '-' }}</span>
                    </div>
                    <div class="border-b border-[#DCD6D0] py-2">
                        <span class="text-[#6E7575] font-bold block mb-1.5">Bahan / Material Kain Terpilih:</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @forelse ($order->bahan as $b)
                                <span class="px-3 py-1 bg-[#FAF8F5] border border-[#DCD6D0] font-black text-[11px] rounded-full text-[#172A39]">
                                    🧵 {{ $b->nama_bahan }}
                                </span>
                            @empty
                                <span class="text-[#8D9494] italic">-</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="py-2">
                        <span class="text-[#6E7575] font-bold block mb-2">Rincian Ukuran &amp; Kuantitas:</span>
                        <div class="border border-[#DCD6D0] rounded-xl overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr style="background:#172A39;color:#FAF8F5;" class="text-[10px] font-black uppercase tracking-wider">
                                        <th class="p-3">UKURAN</th>
                                        <th class="p-3">KUANTITAS (PCS)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                                    @forelse ($order->ukuran as $uk)
                                        <tr class="admin-table-row">
                                            <td class="p-3 font-black text-[#172A39]">{{ $uk->nama_ukuran }}</td>
                                            <td class="p-3 font-black text-[#172A39]">{{ $uk->pivot->kuantitas }} pcs</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="p-3 text-[#6E7575]">Tidak ada data ukuran.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($order->notes)
                        <div class="pt-2">
                            <span class="text-[#6E7575] font-bold block mb-1">Catatan Tambahan:</span>
                            <p class="p-3 bg-[#FAF8F5] border border-[#DCD6D0] rounded-xl italic font-medium text-[#555E68]">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- RIGHT 1 COL: ADMIN PRICE NEGOTIATION FORM -->
        <div class="space-y-8">
            
            <div class="admin-card-rich p-6 space-y-5">
                <h2 class="text-base font-black text-[#172A39]">Penetapan Harga Final</h2>
                <p class="text-xs text-[#6E7575] leading-relaxed font-medium">Setelah kesepakatan dengan pelanggan, masukkan total harga resmi antrean produksi.</p>

                <form action="{{ route('admin.pesanan.update', $order->id_pemesanan) }}" method="POST" class="space-y-4 pt-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="total_harga" class="block text-[11px] font-black tracking-widest text-[#6E7575] uppercase mb-1.5">
                            TOTAL HARGA KESEPAKATAN (RP)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-black text-[#6E7575] pointer-events-none">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="total_harga"
                                name="total_harga"
                                value="{{ old('total_harga', $order->total_harga) }}"
                                step="1000"
                                placeholder="0"
                                class="w-full pl-10 pr-3.5 py-2.5 bg-[#FAF8F5] border border-[#DCD6D0] focus:border-[#172A39] focus:bg-white text-xs sm:text-sm font-black text-[#172A39] rounded-xl focus:outline-none transition-colors"
                            />
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="btn-navy-pill w-full py-3 text-xs uppercase tracking-wider cursor-pointer border-0 shadow-md"
                    >
                        Simpan Harga Kesepakatan
                    </button>
                </form>
            </div>

            <!-- WhatsApp Action Button -->
            <div class="admin-card-rich p-6 text-xs text-[#6E7575] space-y-3">
                <h3 class="text-xs font-black text-[#172A39] uppercase tracking-wider">Komunikasi Pelanggan</h3>
                <p class="leading-relaxed font-medium">Hubungi {{ $order->nama }} via WhatsApp untuk koordinasi pengerjaan &amp; pengiriman:</p>
                <a
                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->no_hp) }}"
                    target="_blank"
                    class="btn-navy-pill w-full py-3 text-xs uppercase tracking-wider gap-2"
                    style="background: linear-gradient(135deg, #059669 0%, #047857 100%) !important; border-color: #047857 !important;"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                    </svg>
                    <span>Chat via WhatsApp</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
