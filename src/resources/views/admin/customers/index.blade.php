@extends('layouts.admin')

@section('title', 'Customers Directory')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Pelanggan</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-0.5">
                Direktori data pelanggan berdasarkan riwayat transaksi pesanan di database.
            </p>
        </div>
    </div>

    <!-- CUSTOMERS TABLE -->
    <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">PELANGGAN</th>
                        <th class="px-6 py-3.5">NO TELEPON</th>
                        <th class="px-6 py-3.5">ALAMAT</th>
                        <th class="px-6 py-3.5 text-center">TOTAL PESANAN</th>
                        <th class="px-6 py-3.5">TOTAL TRANSAKSI</th>
                        <th class="px-6 py-3.5 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @forelse ($customers as $c)
                        <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-sm text-[#1C1917]">
                                <a href="{{ route('admin.customers.show', $c['id']) }}" class="hover:text-[#B85331]">
                                    {{ $c['name'] }}
                                </a>
                            </td>

                            <td class="px-6 py-4 font-mono text-xs text-[#292524]">
                                {{ $c['phone'] }}
                            </td>

                            <td class="px-6 py-4 text-xs text-[#78716C] truncate max-w-xs">
                                {{ $c['address'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-0.5 bg-[#FAF7F2] border border-[#EADACE] font-mono font-medium text-[#1C1917]">
                                    {{ $c['total_orders'] }} pesanan
                                </span>
                            </td>

                            <td class="px-6 py-4 font-mono font-medium text-[#1C1917]">
                                Rp {{ number_format($c['total_spent'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
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
                                        class="absolute right-0 mt-1 w-40 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                        style="display: none;"
                                    >
                                        <div class="py-0.5">
                                            <a
                                                href="{{ route('admin.customers.show', $c['id']) }}"
                                                class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                            >
                                                <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span>Detail Pelanggan</span>
                                            </a>
                                            <a
                                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['phone']) }}"
                                                target="_blank"
                                                class="flex items-center gap-2 px-3.5 py-2 text-xs text-emerald-800 hover:bg-emerald-50 transition-colors font-medium"
                                            >
                                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                                <span>Chat WhatsApp</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-[#78716C]">
                                Belum ada data pelanggan di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
