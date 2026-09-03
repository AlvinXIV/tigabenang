@extends('layouts.admin')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="space-y-5" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteOrderLabel: '' }">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Pesanan Masuk</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Kelola pesanan dan koordinasikan penetapan estimasi harga.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.pesanan.create') }}"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Buat Pesanan Manual</span>
            </a>
        </div>
    </div>

    <!-- TOOLBAR: SEARCH & TOTAL -->
    <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('admin.pesanan.index') }}" method="GET" class="w-full sm:max-w-lg flex items-center gap-2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari ID pesanan, pelanggan, WhatsApp, atau produk..."
                    class="w-full pl-9 pr-3.5 py-2 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>
            <button type="submit" class="btn-secondary px-3.5 py-2 text-xs shrink-0 cursor-pointer">
                Cari
            </button>
            @if (request('search'))
                <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] px-2 py-1 shrink-0 text-decoration-none">
                    Reset
                </a>
            @endif
        </form>

        <div class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
            Total: <strong class="text-[#1C2430]">{{ $orders->count() }}</strong> pesanan
        </div>
    </div>

    <!-- FULL-WIDTH MANAGEMENT TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 font-mono whitespace-nowrap">ID Pesanan</th>
                        <th class="px-4 py-3 whitespace-nowrap">Pelanggan</th>
                        <th class="px-4 py-3 whitespace-nowrap">WhatsApp</th>
                        <th class="px-4 py-3 whitespace-nowrap">Produk</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Total Qty</th>
                        <th class="px-4 py-3 font-mono whitespace-nowrap">Estimasi Harga</th>
                        <th class="px-4 py-3 whitespace-nowrap">Status Harga</th>
                        <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($orders as $ord)
                        @php
                            $totalQty = $ord->ukuran ? $ord->ukuran->sum('pivot.kuantitas') : 0;
                        @endphp
                        <tr class="admin-table-row">
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap text-xs">
                                {{ $ord->created_at ? $ord->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs font-medium text-[#1C2430] whitespace-nowrap">
                                #ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-[#1C2430] whitespace-nowrap">
                                {{ $ord->nama }}
                            </td>
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap font-mono text-xs">
                                @if ($ord->no_hp)
                                    <a
                                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ord->no_hp) }}?text={{ rawurlencode('Halo ' . $ord->nama . ', kami dari Tigabenang mengonfirmasi pesanan #ORD-' . str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT)) }}"
                                        target="_blank"
                                        class="text-emerald-700 hover:underline inline-flex items-center gap-1 text-decoration-none"
                                    >
                                        <span>{{ $ord->no_hp }}</span>
                                    </a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap">
                                {{ $ord->produk ? $ord->produk->nama_produk : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-center font-medium text-[#1C2430] whitespace-nowrap text-xs">
                                {{ $totalQty > 0 ? $totalQty . ' pcs' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap font-mono text-xs text-[#1C2430]">
                                {{ $ord->total_harga ? 'Rp ' . number_format($ord->total_harga, 0, ',', '.') : 'Belum ada estimasi' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($ord->total_harga)
                                    <x-badge variant="success">
                                        Harga Disepakati
                                    </x-badge>
                                @else
                                    <x-badge variant="warning">
                                        Menunggu Penetapan Harga
                                    </x-badge>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi pesanan #ORD-' . str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT)">
                                    <x-action-menu.item href="{{ route('admin.pesanan.show', $ord->id_pemesanan) }}">
                                        Lihat Detail
                                    </x-action-menu.item>

                                    <x-action-menu.item href="{{ route('admin.orders.invoice', $ord->id_pemesanan) }}" target="_blank">
                                        Lihat Faktur
                                    </x-action-menu.item>

                                    <x-action-menu.divider />

                                    <x-action-menu.item
                                        danger
                                        @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.pesanan.destroy', $ord->id_pemesanan) }}'; deleteOrderLabel = '#ORD-{{ str_pad($ord->id_pemesanan, 4, '0', STR_PAD_LEFT) }}'"
                                    >
                                        Hapus
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center">
                                <x-empty-state title="Belum Ada Pesanan" message="Tidak ditemukan data pesanan yang sesuai dengan kriteria pencarian Anda.">
                                    @if (request('search'))
                                        <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary text-xs px-3 py-1.5 mt-3 inline-block">
                                            Bersihkan Pencarian
                                        </a>
                                    @endif
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div
        x-show="deleteModalOpen"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 flex items-center justify-center"
        style="display: none;"
    >
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-[#1C2430]/60 backdrop-blur-xs" @click="deleteModalOpen = false"></div>

        <!-- Modal Dialog -->
        <div class="bg-white rounded-xl overflow-hidden shadow-xl transform transition-all w-full max-w-md z-10 border border-[#E2E5E9] p-6 text-center">
            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-[#1C2430]">Konfirmasi Hapus Pesanan</h3>
            <p class="text-xs text-[#667085] mt-1.5 leading-relaxed">
                Apakah Anda yakin ingin menghapus data pesanan <strong class="text-[#1C2430]" x-text="deleteOrderLabel"></strong>? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex items-center justify-center gap-3 mt-6">
                <button
                    type="button"
                    @click="deleteModalOpen = false"
                    class="btn-secondary px-4 py-2 text-xs"
                >
                    Batal
                </button>
                <form :action="deleteActionUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium transition-colors cursor-pointer border-0"
                    >
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection


