@extends('layouts.admin')

@section('title', 'Order Detail #ORD-' . $order->id_pemesanan)

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Orders</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Order #ORD-{{ $order->id_pemesanan }}</h1>
                @if ($order->total_harga)
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                        HARGA DISEPAKATI
                    </span>
                @else
                    <span class="px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-[#F7DDD2] text-[#B85331] border border-[#F7DDD2]">
                        WAITING PRICE
                    </span>
                @endif
            </div>
            <p class="text-xs font-mono text-[#78716C] mt-1">Dibuat pada: {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.orders.invoice', $order->id_pemesanan) }}"
                class="px-4 py-2.5 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium uppercase tracking-wider transition-colors"
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
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Informasi Pelanggan</h2>
                <div class="space-y-2 text-xs text-[#292524]">
                    <div class="flex justify-between border-b border-[#EADACE]/50 py-1.5">
                        <span class="text-[#78716C]">Nama:</span>
                        <span class="font-semibold">{{ $order->nama }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#EADACE]/50 py-1.5">
                        <span class="text-[#78716C]">No HP:</span>
                        <span class="font-mono font-medium">{{ $order->no_hp }}</span>
                    </div>
                    <div class="py-1.5">
                        <span class="text-[#78716C] block mb-1">Alamat Pengiriman:</span>
                        <p class="p-3 bg-[#FAF7F2] border border-[#EADACE] font-medium leading-relaxed">{{ $order->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Product & Quantity Details -->
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
                <h2 class="text-base font-medium text-[#1C1917]">Rincian Pesanan</h2>
                <div class="space-y-3 text-xs text-[#292524]">
                    <div class="flex justify-between border-b border-[#EADACE]/50 py-1.5">
                        <span class="text-[#78716C]">Produk:</span>
                        <span class="font-semibold text-[#B85331]">{{ $order->produk ? $order->produk->nama_produk : '-' }}</span>
                    </div>
                    <div class="border-b border-[#EADACE]/50 py-1.5">
                        <span class="text-[#78716C] block mb-1">Bahan Terpilih:</span>
                        <div class="flex flex-wrap gap-1.5 mt-1">
                            @forelse ($order->bahan as $b)
                                <span class="px-2 py-0.5 bg-[#FAF7F2] border border-[#EADACE] font-medium text-[11px]">{{ $b->nama_bahan }}</span>
                            @empty
                                <span class="text-[#78716C] italic">-</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="py-1.5">
                        <span class="text-[#78716C] block mb-1">Rincian Ukuran & Kuantitas:</span>
                        <table class="w-full text-left border-collapse mt-2">
                            <thead>
                                <tr class="bg-[#FAF7F2]/60 border-b border-[#EADACE] text-[10px] font-mono text-[#786C62] uppercase">
                                    <th class="p-2.5">UKURAN</th>
                                    <th class="p-2.5">KUANTITAS (PCS)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EADACE]/50">
                                @forelse ($order->ukuran as $uk)
                                    <tr>
                                        <td class="p-2.5 font-mono font-bold">{{ $uk->nama_ukuran }}</td>
                                        <td class="p-2.5 font-mono">{{ $uk->pivot->kuantitas }} pcs</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="p-2.5 text-[#78716C]">Tidak ada data ukuran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($order->notes)
                        <div class="pt-2">
                            <span class="text-[#78716C] block mb-1">Catatan Tambahan:</span>
                            <p class="p-3 bg-[#FAF7F2] border border-[#EADACE] italic text-[#574E46]">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- RIGHT 1 COL: ADMIN PRICE NEGOTIATION FORM -->
        <div class="space-y-8">
            
            <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-5">
                <h2 class="text-base font-medium text-[#1C1917]">Penetapan Harga Final</h2>
                <p class="text-xs text-[#78716C]">Setelah negosiasi WhatsApp dengan pelanggan, masukkan total harga yang disepakati.</p>

                <form action="{{ route('admin.pesanan.update', $order->id_pemesanan) }}" method="POST" class="space-y-4 pt-2">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="total_harga" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            TOTAL HARGA KESEPAKATAN (RP)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-mono text-[#786C62] pointer-events-none">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="total_harga"
                                name="total_harga"
                                value="{{ old('total_harga', $order->total_harga) }}"
                                step="1000"
                                placeholder="0"
                                class="w-full pl-10 pr-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                            />
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium uppercase tracking-wider transition-all shadow-xs cursor-pointer"
                    >
                        Simpan Harga Kesepakatan
                    </button>
                </form>
            </div>

            <!-- WhatsApp Action Button -->
            <div class="bg-[#FAF7F2] border border-[#EADACE] p-6 text-xs text-[#78716C] space-y-3">
                <h3 class="font-mono text-[11px] font-bold text-[#1C1917] uppercase tracking-wider">Komunikasi Pelanggan</h3>
                <p>Hubungi {{ $order->nama }} via WhatsApp untuk negosiasi spesifikasi & harga:</p>
                <a
                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->no_hp) }}"
                    target="_blank"
                    class="block w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-mono text-center text-xs font-medium uppercase transition-colors"
                >
                    Chat via WhatsApp
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
