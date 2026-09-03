@extends('layouts.admin')

@section('title', 'Customers Directory')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-[#FAF8F5] rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Client Database
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Pelanggan &amp; Customer</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Direktori kontak dan riwayat akumulasi pemesanan pelanggan Clothiq Atelier.
            </p>
        </div>
    </div>

    <!-- CUSTOMERS TABLE -->
    <div class="admin-card-rich overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr style="background:#172A39;color:#FAF8F5;" class="text-[11px] font-black tracking-wider uppercase">
                        <th class="px-6 py-4">PELANGGAN</th>
                        <th class="px-6 py-4">NO TELEPON / WHATSAPP</th>
                        <th class="px-6 py-4">ALAMAT PENGIRIMAN</th>
                        <th class="px-6 py-4 text-center">TOTAL PESANAN</th>
                        <th class="px-6 py-4">TOTAL TRANSAKSI</th>
                        <th class="px-6 py-4 text-right">ACTION</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                    @forelse ($customers as $c)
                        <tr class="admin-table-row">
                            <td class="px-6 py-4 font-black text-sm text-[#172A39]">
                                <a href="{{ route('admin.customers.show', $c['id']) }}" class="hover:underline text-[#172A39] text-decoration-none">
                                    {{ $c['name'] }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-xs font-bold text-[#172A39]">
                                {{ $c['phone'] }}
                            </td>

                            <td class="px-6 py-4 text-xs text-[#555E68] truncate max-w-xs font-medium">
                                {{ $c['address'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-[#FAF8F5] border border-[#DCD6D0] rounded-full font-black text-[#172A39]">
                                    {{ $c['total_orders'] }} pesanan
                                </span>
                            </td>

                            <td class="px-6 py-4 font-black text-[#172A39] text-sm">
                                Rp {{ number_format($c['total_spent'], 0, ',', '.') }}
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

                                    <div
                                        x-show="menuOpen"
                                        @click.away="menuOpen = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-48 bg-white border-1.5 border-[#DCD6D0] rounded-2xl shadow-2xl py-2 z-30 text-left"
                                        style="display: none;"
                                    >
                                        <a
                                            href="{{ route('admin.customers.show', $c['id']) }}"
                                            class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-[#172A39] hover:bg-[#FAF8F5] transition-colors font-bold text-decoration-none"
                                        >
                                            <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>Detail Riwayat</span>
                                        </a>
                                        <a
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['phone']) }}"
                                            target="_blank"
                                            class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-emerald-700 hover:bg-emerald-50 transition-colors font-bold text-decoration-none"
                                        >
                                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                                            </svg>
                                            <span>Chat WhatsApp</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-[#6E7575] font-medium">
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
