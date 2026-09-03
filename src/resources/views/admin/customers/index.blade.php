@extends('layouts.admin')

@section('title', 'Direktori Pelanggan')

@section('content')
<div class="space-y-5" x-data="{ search: '' }">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Direktori Pelanggan</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Pelanggan yang pernah melakukan pemesanan.
            </p>
        </div>
    </div>

    <!-- TOOLBAR: SEARCH & COUNT -->
    <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="w-full sm:max-w-md relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input
                type="text"
                x-model="search"
                placeholder="Cari nama pelanggan atau nomor WhatsApp..."
                class="w-full pl-9 pr-3.5 py-2 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
            />
        </div>

        <div class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
            Total: <strong class="text-[#1C2430]">{{ count($customers) }}</strong> pelanggan terdata
        </div>
    </div>

    <!-- CUSTOMERS FULL-WIDTH TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3 font-mono">WhatsApp</th>
                        <th class="px-4 py-3">Alamat Pengiriman</th>
                        <th class="px-4 py-3 text-center">Jumlah Pesanan</th>
                        <th class="px-4 py-3 font-mono">Total Estimasi</th>
                        <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($customers as $c)
                        <tr
                            class="admin-table-row"
                            x-show="!search || '{{ strtolower(addslashes($c['name'])) }}'.includes(search.toLowerCase()) || '{{ addslashes($c['phone']) }}'.includes(search)"
                        >
                            <td class="px-4 py-3.5 font-medium text-[#1C2430] whitespace-nowrap">
                                <a href="{{ route('admin.customers.show', $c['id']) }}" class="hover:text-[#B8664A] text-[#1C2430] text-decoration-none font-medium">
                                    {{ $c['name'] }}
                                </a>
                            </td>

                            <td class="px-4 py-3.5 text-[#1C2430] font-mono text-xs whitespace-nowrap">
                                @if ($c['phone'])
                                    <a
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['phone']) }}"
                                        target="_blank"
                                        class="text-emerald-700 hover:underline text-decoration-none"
                                    >
                                        {{ $c['phone'] }}
                                    </a>
                                @else
                                    <span class="text-[#667085]">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-[#667085] text-xs max-w-xs truncate">
                                {{ $c['address'] ?: 'Belum ada alamat' }}
                            </td>

                            <td class="px-4 py-3.5 text-center whitespace-nowrap font-medium text-[#1C2430]">
                                <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs">
                                    {{ $c['orders_count'] }} order
                                </span>
                            </td>

                            <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                {{ $c['total_spent'] ? 'Rp ' . number_format($c['total_spent'], 0, ',', '.') : 'Rp 0' }}
                            </td>

                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi pelanggan ' . $c['name']">
                                    <x-action-menu.item href="{{ route('admin.customers.show', $c['id']) }}">
                                        Lihat Profil &amp; Riwayat
                                    </x-action-menu.item>

                                    @if ($c['phone'])
                                        @php
                                            $cleanWa = preg_replace('/[^0-9]/', '', $c['phone']);
                                            if (str_starts_with($cleanWa, '0')) {
                                                $cleanWa = '62' . substr($cleanWa, 1);
                                            }
                                        @endphp
                                        <x-action-menu.item href="https://wa.me/{{ $cleanWa }}?text=Halo%20{{ urlencode($c['name']) }}%2C%20dari%20Tigabenang%20Apparel" target="_blank">
                                            Hubungi WhatsApp
                                        </x-action-menu.item>
                                    @endif
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center">
                                <x-empty-state title="Belum Ada Data Pelanggan" message="Pelanggan akan otomatis tercatat saat membuat pesanan baru." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


