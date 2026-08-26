@extends('layouts.admin')

@section('title', 'Customer Detail - ' . $customer['name'])

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="text-xs text-[#78716C] hover:text-[#B85331] font-mono font-medium inline-flex items-center gap-1.5 mb-2 transition-colors uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Customers</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">{{ $customer['name'] }}</h1>
            <p class="text-xs font-mono text-[#78716C] mt-1">{{ $customer['phone'] }}</p>
        </div>

        <div>
            <a
                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer['phone']) }}"
                target="_blank"
                class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-mono text-xs font-medium uppercase transition-colors inline-flex items-center gap-2"
            >
                <span>Chat via WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- LEFT: CUSTOMER INFO -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] space-y-4">
            <h2 class="text-base font-medium text-[#1C1917]">Profil Pelanggan</h2>
            <div class="space-y-3 text-xs text-[#292524]">
                <div>
                    <span class="text-[#78716C] block mb-0.5 text-[10px] font-mono uppercase">NAMA:</span>
                    <p class="font-semibold text-sm text-[#1C1917]">{{ $customer['name'] }}</p>
                </div>
                <div>
                    <span class="text-[#78716C] block mb-0.5 text-[10px] font-mono uppercase">NO TELEPON:</span>
                    <p class="font-mono">{{ $customer['phone'] }}</p>
                </div>
                <div>
                    <span class="text-[#78716C] block mb-0.5 text-[10px] font-mono uppercase">ALAMAT:</span>
                    <p class="p-3 bg-[#FAF7F2] border border-[#EADACE] leading-relaxed">{{ $customer['address'] }}</p>
                </div>
                <div class="pt-2 border-t border-[#EADACE]/70 flex justify-between">
                    <span class="text-[#78716C]">Total Pesanan:</span>
                    <span class="font-bold font-mono">{{ $customer['total_orders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#78716C]">Total Belanja:</span>
                    <span class="font-bold font-mono text-[#B85331]">Rp {{ number_format($customer['total_spent'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- RIGHT: ORDER HISTORY -->
        <div class="lg:col-span-2 bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
            <div class="p-4 border-b border-[#EADACE]/70 bg-[#FAF7F2]/60">
                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-[#786C62]">Riwayat Pesanan Pelanggan</h3>
            </div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">ORDER ID</th>
                        <th class="px-6 py-3.5">PRODUK</th>
                        <th class="px-6 py-3.5">TOTAL</th>
                        <th class="px-6 py-3.5 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @foreach ($customer['orders'] as $ord)
                        <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                            <td class="px-6 py-3.5 font-mono font-bold text-[#1C1917]">#ORD-{{ $ord->id_pemesanan }}</td>
                            <td class="px-6 py-3.5 text-[#292524]">{{ $ord->produk ? $ord->produk->nama_produk : '-' }}</td>
                            <td class="px-6 py-3.5 font-mono text-[#1C1917]">
                                {{ $ord->total_harga ? 'Rp ' . number_format($ord->total_harga, 0, ',', '.') : 'Waiting Price' }}
                            </td>
                            <td class="px-6 py-3.5 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                <div class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="menuOpen = !menuOpen"
                                        class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] border border-transparent hover:border-[#EADACE] transition-colors focus:outline-none cursor-pointer"
                                        title="Actions"
                                    >
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="19" r="2"></circle>
                                        </svg>
                                    </button>

                                    <div
                                        x-show="menuOpen"
                                        @click.away="menuOpen = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-1 w-36 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                        style="display: none;"
                                    >
                                        <div class="py-0.5">
                                            <a
                                                href="{{ route('admin.pesanan.show', $ord->id_pemesanan) }}"
                                                class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                            >
                                                <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span>Detail Pesanan</span>
                                            </a>
                                            <a
                                                href="{{ route('admin.orders.invoice', $ord->id_pemesanan) }}"
                                                class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                            >
                                                <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span>Cetak Invoice</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
