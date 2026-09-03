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
                        <th class="px-4 py-3 text-right">Aksi</th>
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
                                    <span class="text-[#98A2B3]">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-[#667085] text-xs truncate max-w-sm">
                                {{ $c['address'] ?? '-' }}
                            </td>

                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-md font-medium text-xs text-[#1C2430]">
                                    {{ $c['total_orders'] }} pesanan
                                </span>
                            </td>

                            <td class="px-4 py-3.5 font-mono text-xs font-medium text-[#1C2430] whitespace-nowrap">
                                {{ $c['total_spent'] ? 'Rp ' . number_format($c['total_spent'], 0, ',', '.') : 'Rp 0' }}
                            </td>

                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a
                                        href="{{ route('admin.customers.show', $c['id']) }}"
                                        class="btn-secondary px-2.5 py-1 text-xs"
                                        title="Detail Riwayat Pelanggan"
                                    >
                                        Detail Riwayat
                                    </a>

                                    @if ($c['phone'])
                                        <a
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['phone']) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="p-1 text-emerald-700 hover:text-emerald-800 hover:bg-emerald-50 rounded transition-colors"
                                            title="Chat WhatsApp"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41A10.1 10.1 0 0 0 12.04 21.66h.01c5.46 0 9.89-4.4 9.89-9.84C21.94 6.4 17.5 2 12.04 2Z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
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


