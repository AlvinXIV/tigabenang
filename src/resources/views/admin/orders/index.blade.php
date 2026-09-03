@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-[#FAF8F5] rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Order Pipelines
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Order Management</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Kelola pesanan custom pelanggan, verifikasi bahan/material, dan negosiasi harga antrean.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.pesanan.create') }}"
                class="btn-navy-pill px-6 py-2.5 text-xs tracking-wide uppercase gap-2 cursor-pointer shadow-md"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Order</span>
            </a>
        </div>
    </div>

    <!-- ORDERS TABLE -->
    <div class="admin-card-rich overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr style="background:#172A39;color:#FAF8F5;" class="text-[11px] font-black tracking-wider uppercase">
                        <th class="px-6 py-4">ORDER ID</th>
                        <th class="px-6 py-4">PELANGGAN</th>
                        <th class="px-6 py-4">NO HP</th>
                        <th class="px-6 py-4">PRODUK</th>
                        <th class="px-6 py-4">TOTAL HARGA</th>
                        <th class="px-6 py-4">STATUS HARGA</th>
                        <th class="px-6 py-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                    @forelse ($orders as $ord)
                        <tr class="admin-table-row">
                            <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap">
                                #ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap">
                                {{ $ord->nama }}
                            </td>
                            <td class="px-6 py-4 text-[#555E68] whitespace-nowrap font-bold">
                                {{ $ord->no_hp }}
                            </td>
                            <td class="px-6 py-4 text-[#555E68] whitespace-nowrap font-bold">
                                {{ $ord->produk ? $ord->produk->nama_produk : '-' }}
                            </td>
                            <td class="px-6 py-4 font-black text-[#172A39] whitespace-nowrap text-sm">
                                {{ $ord->total_harga ? 'Rp ' . number_format($ord->total_harga, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($ord->total_harga)
                                    <span class="px-3 py-1 text-[10px] font-black tracking-wider uppercase bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-full">
                                        HARGA DISEPAKATI
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-[10px] font-black tracking-wider uppercase bg-amber-100 text-amber-900 border border-amber-300 rounded-full">
                                        WAITING PRICE
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                <div class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="menuOpen = !menuOpen"
                                        class="p-2 text-[#172A39] hover:bg-[#FAF8F5] rounded-xl border border-[#DCD6D0] hover:border-[#172A39] transition-all focus:outline-none cursor-pointer shadow-2xs"
                                        title="Actions"
                                    >
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="19" r="2"></circle>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div
                                        x-show="menuOpen"
                                        @click.away="menuOpen = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-52 bg-white border-1.5 border-[#DCD6D0] rounded-2xl shadow-2xl py-2 z-30 text-left"
                                        style="display: none;"
                                    >
                                        <a
                                            href="{{ route('admin.pesanan.show', $ord->id_pemesanan) }}"
                                            class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-[#172A39] hover:bg-[#FAF8F5] transition-colors font-bold text-decoration-none"
                                        >
                                            <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>Detail / Set Price</span>
                                        </a>

                                        <a
                                            href="{{ route('admin.orders.invoice', $ord->id_pemesanan) }}"
                                            class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-[#172A39] hover:bg-[#FAF8F5] transition-colors font-bold text-decoration-none"
                                        >
                                            <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Cetak Invoice</span>
                                        </a>

                                        <a
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ord->no_hp) }}"
                                            target="_blank"
                                            class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-emerald-700 hover:bg-emerald-50 transition-colors font-bold text-decoration-none"
                                        >
                                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                                            </svg>
                                            <span>WhatsApp Chat</span>
                                        </a>

                                        <div class="border-t border-[#DCD6D0] my-1.5"></div>

                                        <form action="{{ route('admin.pesanan.destroy', $ord->id_pemesanan) }}" method="POST" onsubmit="return confirm('Hapus pesanan #ORD-{{ $ord->id_pemesanan }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-700 hover:bg-rose-50 transition-colors font-bold cursor-pointer border-0 bg-transparent"
                                            >
                                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Hapus Pesanan</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-[#6E7575] font-medium">
                                Belum ada pesanan masuk di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
