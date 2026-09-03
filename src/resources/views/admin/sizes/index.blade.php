@extends('layouts.admin')

@section('title', 'Dimensi Ukuran')

@section('content')
<div
    class="space-y-5"
    x-data="{
        addFormOpen: {{ $errors->any() ? 'true' : 'false' }},
        searchQuery: '',
        categoryFilter: '',
        deleteModalOpen: false,
        deleteActionUrl: '',
        deleteSizeName: ''
    }"
>

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Dimensi Ukuran</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Matriks spesifikasi dimensi pola pakaian per kategori.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <button
                type="button"
                @click="addFormOpen = !addFormOpen"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Ukuran</span>
            </button>
        </div>
    </div>

    <!-- COLLAPSIBLE ADD SIZE FORM -->
    <div x-show="addFormOpen" x-transition class="admin-card p-5 bg-white border-[#B8664A]/30 space-y-4">
        <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
            <div>
                <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Tambah Spesifikasi Ukuran Baru</h2>
                <p class="text-xs text-[#667085] mt-0.5">Dimensi ukuran menggunakan satuan centimeter (cm).</p>
            </div>
            <button type="button" @click="addFormOpen = false" class="text-[#667085] hover:text-[#1C2430] text-xs cursor-pointer">
                Tutup
            </button>
        </div>

        <form
            action="{{ route('admin.ukuran.store') }}"
            method="POST"
            class="space-y-4"
            x-data="{ isSubmitting: false }"
            @submit="isSubmitting = true"
        >
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3.5">
                <!-- Kategori Produk -->
                <div class="lg:col-span-2">
                    <label for="kategori_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Kategori Produk <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="kategori_id"
                        name="kategori_id"
                        required
                        class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    >
                        <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>Pilih Kategori...</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id_kategori }}" {{ old('kategori_id') == $cat->id_kategori ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Label Ukuran -->
                <div class="lg:col-span-1">
                    <label for="nama_ukuran" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Ukuran <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_ukuran"
                        id="nama_ukuran"
                        value="{{ old('nama_ukuran') }}"
                        required
                        placeholder="S, M, L..."
                        class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                    @error('nama_ukuran')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lebar Dada -->
                <div class="lg:col-span-1">
                    <label for="lebar_dada" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Lebar Dada (cm)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="lebar_dada"
                        id="lebar_dada"
                        value="{{ old('lebar_dada') }}"
                        placeholder="52.0"
                        class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>

                <!-- Panjang Badan -->
                <div class="lg:col-span-1">
                    <label for="panjang" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Panjang (cm)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="panjang"
                        id="panjang"
                        value="{{ old('panjang') }}"
                        placeholder="70.0"
                        class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>

                <!-- Lebar Bahu -->
                <div class="lg:col-span-1">
                    <label for="lebar_bahu" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                        Bahu (cm)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="lebar_bahu"
                        id="lebar_bahu"
                        value="{{ old('lebar_bahu') }}"
                        placeholder="46.0"
                        class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>
            </div>

            <div class="flex items-center justify-between pt-1 border-t border-[#E2E5E9]">
                <!-- Panjang Lengan -->
                <div class="w-full max-w-xs">
                    <label for="panjang_lengan" class="block text-xs font-semibold text-[#1C2430] mb-1">
                        Panjang Lengan (cm)
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        name="panjang_lengan"
                        id="panjang_lengan"
                        value="{{ old('panjang_lengan') }}"
                        placeholder="60.0"
                        class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] font-mono text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                    />
                </div>

                <div class="flex items-center gap-2 self-end">
                    <button type="button" @click="addFormOpen = false" class="btn-secondary px-3.5 py-2 text-xs sm:text-sm cursor-pointer">
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="btn-primary px-4 py-2 text-xs sm:text-sm font-medium cursor-pointer"
                    >
                        <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Ukuran'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TOOLBAR: SEARCH & CATEGORY FILTER -->
    <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="w-full flex flex-col sm:flex-row items-center gap-2.5 sm:max-w-xl">
            <div class="relative w-full sm:max-w-xs">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Cari label ukuran..."
                    class="w-full pl-9 pr-3.5 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <div class="w-full sm:w-52">
                <select
                    x-model="categoryFilter"
                    class="w-full px-3 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
            Total: <strong class="text-[#1C2430]">{{ $sizes->count() }}</strong> standar ukuran
        </div>
    </div>

    <!-- FULL-WIDTH SIZE MANAGEMENT TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Ukuran</th>
                        <th class="px-4 py-3 font-mono">Lebar Dada</th>
                        <th class="px-4 py-3 font-mono">Panjang Badan</th>
                        <th class="px-4 py-3 font-mono">Lebar Bahu</th>
                        <th class="px-4 py-3 font-mono">Panjang Lengan</th>
                        <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($sizes as $size)
                        @php
                            $catName = $size->kategori ? $size->kategori->nama_kategori : '';
                        @endphp
                        <tr
                            class="admin-table-row"
                            x-show="(!searchQuery || '{{ strtolower($size->nama_ukuran) }}'.includes(searchQuery.toLowerCase())) && (!categoryFilter || '{{ $catName }}' === categoryFilter)"
                        >
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap text-xs">
                                <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-[#1C2430] font-medium">
                                    {{ $catName ?: '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap font-medium text-[#1C2430]">
                                {{ $size->nama_ukuran }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                {{ $size->lebar_dada ? $size->lebar_dada . ' cm' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                {{ $size->panjang ? $size->panjang . ' cm' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                {{ $size->lebar_bahu ? $size->lebar_bahu . ' cm' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                {{ $size->panjang_lengan ? $size->panjang_lengan . ' cm' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi ukuran ' . $size->nama_ukuran">
                                    <x-action-menu.item href="{{ route('admin.ukuran.edit', $size->id_ukuran) }}">
                                        Ubah Ukuran
                                    </x-action-menu.item>

                                    <x-action-menu.divider />

                                    <x-action-menu.item
                                        danger
                                        @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.ukuran.destroy', $size->id_ukuran) }}'; deleteSizeName = '{{ $size->nama_ukuran }} ({{ $catName ?: '-' }})'"
                                    >
                                        Hapus
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center">
                                <x-empty-state title="Belum Ada Standar Ukuran" message="Tambahkan ukuran pola garmen pertama melalui tombol di atas." />
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
            <h3 class="text-base font-semibold text-[#1C2430]">Konfirmasi Hapus Ukuran</h3>
            <p class="text-xs text-[#667085] mt-1.5 leading-relaxed">
                Apakah Anda yakin ingin menghapus data ukuran <strong class="text-[#1C2430]" x-text="deleteSizeName"></strong>? Tindakan ini dapat memengaruhi produk terkait.
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

