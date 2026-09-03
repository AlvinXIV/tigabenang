@extends('layouts.admin')

@section('title', 'Katalog Produk')

@section('content')
<div class="space-y-5" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteProductName: '' }">

    <!-- TOP HEADER & ACTION BUTTON -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Katalog Produk</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Kelola produk yang tersedia untuk pelanggan.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.kategori.index') }}"
                class="btn-secondary px-3.5 py-2 text-xs sm:text-sm"
            >
                Kelola Kategori
            </a>

            <a
                href="{{ route('admin.produk.create') }}"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>+ Tambah Produk</span>
            </a>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('admin.produk.index') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-2.5">
            <!-- Search Input -->
            <div class="relative w-full sm:max-w-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama produk..."
                    class="w-full pl-9 pr-3.5 py-2 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <!-- Category Filter -->
            <div class="w-full sm:w-56">
                <select
                    name="category_id"
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id_kategori }}" {{ request('category_id') == $cat->id_kategori ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-secondary px-3.5 py-2 text-xs shrink-0 cursor-pointer">
                Filter
            </button>

            @if (request('search') || request('category_id'))
                <a href="{{ route('admin.produk.index') }}" class="text-xs text-[#667085] hover:text-[#B8664A] px-2 py-1 shrink-0 text-decoration-none">
                    Reset
                </a>
            @endif
        </form>

        <div class="text-xs text-[#667085] self-end sm:self-center shrink-0">
            Total: <strong class="text-[#1C2430]">{{ $products->count() }}</strong> produk
        </div>
    </div>

    <!-- PRODUCT CATALOG TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 font-mono">Harga Dasar</th>
                        <th class="px-4 py-3">Model 3D</th>
                        <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($products as $prod)
                        <tr class="admin-table-row">
                            <!-- Product Column (Thumbnail + Name) -->
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.produk.edit', $prod->id_produk) }}" class="flex items-center gap-3 group text-decoration-none">
                                    @if ($prod->gambar)
                                        <img
                                            src="{{ asset('storage/' . $prod->gambar) }}"
                                            alt="{{ $prod->nama_produk }}"
                                            class="w-10 h-10 object-cover rounded-lg border border-[#E2E5E9] shrink-0 group-hover:opacity-90 transition-opacity"
                                        />
                                    @else
                                        <div class="w-10 h-10 bg-[#F4E9E4] text-[#B8664A] border border-[#E2D5CF] rounded-lg flex items-center justify-center text-xs font-semibold shrink-0">
                                            TB
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-medium text-[#1C2430] text-xs sm:text-sm block group-hover:text-[#B8664A] transition-colors">
                                            {{ $prod->nama_produk }}
                                        </span>
                                        <span class="text-[11px] text-[#667085] line-clamp-1 max-w-xs mt-0.5">
                                            {{ $prod->deskripsi ?: 'Tidak ada deskripsi' }}
                                        </span>
                                    </div>
                                </a>
                            </td>

                            <!-- Category Column -->
                            <td class="px-4 py-3 text-[#667085] whitespace-nowrap text-xs">
                                <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded-md text-[#1C2430] font-medium">
                                    {{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}
                                </span>
                            </td>

                            <!-- Price Column -->
                            <td class="px-4 py-3 font-mono text-xs font-medium text-[#1C2430] whitespace-nowrap">
                                Rp {{ number_format($prod->harga, 0, ',', '.') }}
                            </td>

                            <!-- 3D Model Column -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($prod->file_model_3d)
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        3D Aktif
                                    </span>
                                @else
                                    <span class="text-xs text-[#98A2B3]">Belum ada 3D</span>
                                @endif
                            </td>

                            <!-- Actions Column -->
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi produk ' . $prod->nama_produk">
                                    <x-action-menu.item href="{{ route('admin.produk.edit', $prod->id_produk) }}">
                                        Ubah Produk
                                    </x-action-menu.item>

                                    @if ($prod->file_model_3d)
                                        <x-action-menu.item href="{{ route('admin.model-3d.preview', $prod->id_produk) }}">
                                            Lihat Model 3D
                                        </x-action-menu.item>
                                    @endif

                                    <x-action-menu.divider />

                                    <x-action-menu.item
                                        danger
                                        @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.produk.destroy', $prod->id_produk) }}'; deleteProductName = '{{ $prod->nama_produk }}'"
                                    >
                                        Hapus
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center">
                                <x-empty-state title="Produk Tidak Ditemukan" message="Belum ada produk yang terdaftar atau sesuai dengan kriteria filter pencarian.">
                                    <a href="{{ route('admin.produk.create') }}" class="btn-primary text-xs px-3 py-1.5 mt-3 inline-block">
                                        + Tambah Produk Pertama
                                    </a>
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
        <div class="fixed inset-0 bg-[#1C2430]/60 backdrop-blur-xs" @click="deleteModalOpen = false"></div>

        <div class="bg-white rounded-xl overflow-hidden shadow-xl transform transition-all w-full max-w-md z-10 border border-[#E2E5E9] p-6 text-center">
            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-[#1C2430]">Konfirmasi Hapus Produk</h3>
            <p class="text-xs text-[#667085] mt-1.5 leading-relaxed">
                Apakah Anda yakin ingin menghapus produk <strong class="text-[#1C2430]" x-text="deleteProductName"></strong>? Aset gambar dan relasi terkait akan dihapus.
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


