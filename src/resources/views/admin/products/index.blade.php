@extends('layouts.admin')

@section('title', 'Katalog Pakaian')
@section('page-title', 'Kelola Katalog Produk')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Filters -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Katalog Pakaian Vendor</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola informasi produk pakaian, bahan kain, varian warna, estimasi harga, dan status 3D fitting.</p>
        </div>
        <div class="flex items-center gap-3">
            <x-button variant="primary" href="{{ route('admin.produk.create') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Produk Pakaian</span>
            </x-button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <button class="px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 text-white">Semua ({{ count($products) }})</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Jaket (2)</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Kaos (1)</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">Hoodie (1)</button>
            <button class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600">3D Ready Saja</button>
        </div>
        <div class="relative w-full sm:w-64">
            <input
                type="text"
                placeholder="Cari nama produk / bahan..."
                class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Table of Products -->
    <x-card padding="p-0">
        <x-table :headers="['Produk & Foto', 'Kategori', 'Bahan Kain', 'Varian Warna', 'Estimasi Harga', 'Fitting 3D', 'Aksi']">
            @foreach ($products as $prod)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <!-- Foto & Nama -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ $prod['thumbnail'] }}"
                                alt="{{ $prod['name'] }}"
                                class="w-12 h-12 rounded-xl object-cover border border-slate-200 shrink-0 shadow-xs"
                            />
                            <div>
                                <span class="font-bold text-slate-900 text-sm block leading-snug">{{ $prod['name'] }}</span>
                                <span class="text-[11px] text-slate-400">Min. Order: {{ $prod['min_order'] }}</span>
                            </div>
                        </div>
                    </td>

                    <!-- Kategori -->
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-700">
                        {{ $prod['category'] }}
                    </td>

                    <!-- Bahan -->
                    <td class="px-6 py-4 text-xs text-slate-600 max-w-xs">
                        {{ $prod['material'] }}
                    </td>

                    <!-- Warna -->
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach ($prod['colors'] as $c)
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-[10px] font-medium">{{ $c }}</span>
                            @endforeach
                        </div>
                    </td>

                    <!-- Harga -->
                    <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900 text-xs">
                        {{ $prod['estimated_price'] }} <span class="text-[10px] text-slate-400 font-normal">/ pcs</span>
                    </td>

                    <!-- 3D Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($prod['has_3d_model'])
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-cyan-50 text-cyan-700 border border-cyan-200">
                                <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
                                3D Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                Belum ada 3D
                            </span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <x-button variant="secondary" size="xs" href="{{ route('admin.produk.edit', $prod['id']) }}">
                                Edit
                            </x-button>
                            <form action="{{ route('admin.produk.destroy', $prod['id']) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari katalog?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </x-card>

</div>
@endsection
