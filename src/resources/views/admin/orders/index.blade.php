@extends('layouts.admin')

@section('title', 'Daftar Pesanan Customer')
@section('page-title', 'Manajemen Permintaan & Pesanan')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pesanan & Permintaan Produksi Custom</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola permintaan pesanan pakaian kustom, verifikasi spesifikasi, perbarui status produksi, dan cetak invoice.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl text-xs font-bold border border-amber-200 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> 3 Pesanan Menunggu Review
            </span>
        </div>
    </div>

    <!-- Filter Pipeline Status Tabs -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <button class="px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 text-white">Semua Pesanan ({{ count($orders) }})</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Menunggu Review (1)</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Dikonfirmasi (1)</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Sedang Produksi (1)</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Selesai (2)</button>
        </div>

        <div class="relative w-full sm:w-64">
            <input
                type="text"
                placeholder="Cari kode pesanan / customer..."
                class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Orders Table -->
    <x-card padding="p-0">
        <x-table :headers="['Kode & Tanggal', 'Customer / Instansi', 'Kontak WhatsApp', 'Produk & Rincian Ukuran', 'Jumlah', 'Total Tagihan', 'Status Produksi', 'Aksi']">
            @foreach ($orders as $ord)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    
                    <!-- Kode Order -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-indigo-600 block">{{ $ord['order_code'] }}</span>
                        <span class="text-[10px] text-slate-400">{{ $ord['created_at'] }}</span>
                    </td>

                    <!-- Customer Info -->
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900 text-sm leading-snug">{{ $ord['customer_name'] }}</p>
                        <p class="text-[11px] text-slate-500 font-medium">{{ $ord['company_or_institution'] }}</p>
                    </td>

                    <!-- Kontak -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ord['phone']) }}"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100 transition-colors border border-emerald-200"
                        >
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"></path>
                            </svg>
                            <span>{{ $ord['phone'] }}</span>
                        </a>
                    </td>

                    <!-- Produk & Ukuran -->
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800 text-xs">{{ $ord['product_name'] }}</p>
                        <p class="text-[11px] text-slate-500 font-mono mt-0.5">{{ $ord['size_breakdown'] }}</p>
                    </td>

                    <!-- Qty -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-slate-800 text-sm">{{ $ord['quantity'] }} pcs</span>
                    </td>

                    <!-- Total Harga -->
                    <td class="px-6 py-4 whitespace-nowrap font-extrabold text-slate-900 text-sm">
                        {{ $ord['total_price'] }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($ord['status'] === 'pending')
                            <x-badge variant="amber" dot="true">Menunggu Review</x-badge>
                        @elseif ($ord['status'] === 'confirmed')
                            <x-badge variant="sky">Dikonfirmasi</x-badge>
                        @elseif ($ord['status'] === 'in_production')
                            <x-badge variant="indigo" dot="true">Sedang Produksi</x-badge>
                        @elseif ($ord['status'] === 'completed')
                            <x-badge variant="emerald">Selesai</x-badge>
                        @else
                            <x-badge variant="rose">Ditolak</x-badge>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-button variant="secondary" size="xs" href="{{ route('admin.pesanan.show', $ord['id']) }}">
                                Rincian
                            </x-button>
                            <x-button variant="outline" size="xs" href="{{ route('admin.orders.invoice', $ord['id']) }}">
                                Faktur
                            </x-button>
                        </div>
                    </td>

                </tr>
            @endforeach
        </x-table>
    </x-card>

</div>
@endsection
