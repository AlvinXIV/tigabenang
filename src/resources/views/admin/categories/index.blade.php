@extends('layouts.admin')

@section('title', 'Kategori Produk')
@section('page-title', 'Kelola Kategori Pakaian')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, currentCategory: {} }">

    <!-- Header Actions -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Kategori Pakaian</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelompokkan jenis pakaian yang dapat diproduksi oleh vendor Tigabenang.</p>
        </div>
        <button
            @click="$dispatch('open-modal', 'add-category-modal')"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Tambah Kategori Baru</span>
        </button>
    </div>

    <!-- Table of Categories -->
    <x-card padding="p-0">
        <x-table :headers="['Nama Kategori', 'Slug URL', 'Deskripsi Jenis Produk', 'Jumlah Produk', 'Status', 'Aksi']">
            @foreach ($categories as $cat)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-slate-900 text-sm block">{{ $cat['name'] }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-xs px-2 py-1 bg-slate-100 text-slate-600 rounded-md">{{ $cat['slug'] }}</code>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-600 max-w-xs">
                        {{ $cat['description'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-700">
                        {{ $cat['products_count'] }} produk
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-badge variant="emerald" dot="true">Aktif</x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button
                                @click="$dispatch('open-modal', 'add-category-modal')"
                                class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition-colors text-xs font-semibold"
                            >
                                Edit
                            </button>
                            <form action="{{ route('admin.kategori.destroy', $cat['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </x-card>

    <!-- Modal Tambah Kategori -->
    <x-modal name="add-category-modal" title="Tambah Kategori Pakaian Baru">
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-input label="Nama Kategori" name="name" placeholder="Contoh: Jaket & Outerwear" required />
            <x-input label="Slug URL (Otomatis)" name="slug" placeholder="jaket-outerwear" hint="Huruf kecil dan tanda hubung (-)" />
            <x-input type="textarea" label="Deskripsi Kategori" name="description" rows="3" placeholder="Jelaskan jenis variasi pakaian dalam kategori ini..." required />
            
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" @click="$dispatch('close-modal', 'add-category-modal')" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                    Batal
                </button>
                <x-button type="submit" variant="primary" size="md">
                    Simpan Kategori
                </x-button>
            </div>
        </form>
    </x-modal>

</div>
@endsection
