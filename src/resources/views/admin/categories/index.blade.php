@extends('layouts.admin')

@section('title', 'Kategori & Material Kain')

@section('content')
<div
    class="space-y-5"
    x-data="{
        activeTab: window.location.hash === '#material' ? 'material' : 'kategori',
        searchKategori: '',
        searchMaterial: '',
        addKategoriOpen: false,
        addMaterialOpen: false,
        deleteModalOpen: false,
        deleteActionUrl: '',
        deleteItemName: ''
    }"
    x-init="
        window.addEventListener('hashchange', () => {
            activeTab = window.location.hash === '#material' ? 'material' : 'kategori';
        });
    "
>

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight" x-text="activeTab === 'kategori' ? 'Kategori Produk' : 'Material Kain'">
                Kategori Produk
            </h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1" x-text="activeTab === 'kategori' ? 'Kelola klasifikasi produk busana seperti Jaket, Kemeja, Polo, dll.' : 'Kelola kurasi jenis bahan kain garmen untuk pesanan custom.'">
                Kelola klasifikasi produk busana.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <!-- Contextual Action Button for Kategori -->
            <button
                type="button"
                x-show="activeTab === 'kategori'"
                @click="addKategoriOpen = !addKategoriOpen"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>+ Tambah Kategori</span>
            </button>

            <!-- Contextual Action Button for Material -->
            <button
                type="button"
                x-show="activeTab === 'material'"
                @click="addMaterialOpen = !addMaterialOpen"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>+ Tambah Material</span>
            </button>
        </div>
    </div>

    <!-- TAB SEGMENTED NAVIGATION -->
    <div class="flex items-center border-b border-[#E2E5E9] gap-6 text-xs sm:text-sm">
        <button
            type="button"
            @click="activeTab = 'kategori'; window.location.hash = 'kategori'"
            :class="activeTab === 'kategori' ? 'border-[#B8664A] text-[#B8664A] font-semibold' : 'border-transparent text-[#667085] hover:text-[#1C2430]'"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer"
        >
            <span>Kategori Produk</span>
            <span class="px-2 py-0.5 rounded-full text-xs" :class="activeTab === 'kategori' ? 'bg-[#F4E9E4] text-[#B8664A]' : 'bg-[#F7F7F5] text-[#667085]'">
                {{ $summary['total_categories'] }}
            </span>
        </button>

        <button
            type="button"
            @click="activeTab = 'material'; window.location.hash = 'material'"
            :class="activeTab === 'material' ? 'border-[#B8664A] text-[#B8664A] font-semibold' : 'border-transparent text-[#667085] hover:text-[#1C2430]'"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer"
        >
            <span>Material Kain</span>
            <span class="px-2 py-0.5 rounded-full text-xs" :class="activeTab === 'material' ? 'bg-[#F4E9E4] text-[#B8664A]' : 'bg-[#F7F7F5] text-[#667085]'">
                {{ $summary['total_materials'] }}
            </span>
        </button>
    </div>

    <!-- ============================================== -->
    <!-- TAB 1: KATEGORI PRODUK                         -->
    <!-- ============================================== -->
    <div x-show="activeTab === 'kategori'" class="space-y-4">
        
        <!-- Collapsible Add Category Panel -->
        <div x-show="addKategoriOpen" x-transition class="admin-card p-4 bg-white border-[#B8664A]/30">
            <h3 class="text-sm font-semibold text-[#1C2430] mb-2">Tambah Kategori Baru</h3>
            <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex flex-col sm:flex-row gap-2.5 max-w-xl">
                @csrf
                <input
                    type="text"
                    name="nama_kategori"
                    required
                    placeholder="Nama kategori, contoh: Jaket Varsity, Kemeja PDH"
                    class="flex-1 px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary px-4 py-2 text-xs sm:text-sm cursor-pointer">
                        Simpan
                    </button>
                    <button type="button" @click="addKategoriOpen = false" class="btn-secondary px-3 py-2 text-xs cursor-pointer">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Bar Toolbar -->
        <div class="admin-card p-3 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative w-full sm:max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="searchKategori"
                    placeholder="Cari nama kategori..."
                    class="w-full pl-9 pr-3.5 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>
            <span class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
                Total: <strong class="text-[#1C2430]">{{ $categories->count() }}</strong> kategori
            </span>
        </div>

        <!-- Full-Width Category Table -->
        <div class="admin-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                            <th class="px-4 py-3 font-mono">ID Kategori</th>
                            <th class="px-4 py-3">Nama Kategori</th>
                            <th class="px-4 py-3">Jumlah Produk</th>
                            <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E5E9] bg-white">
                        @forelse ($categories as $cat)
                            <tr
                                class="admin-table-row"
                                x-show="!searchKategori || '{{ strtolower(addslashes($cat->nama_kategori)) }}'.includes(searchKategori.toLowerCase())"
                            >
                                <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                    #{{ $cat->id_kategori }}
                                </td>
                                <td class="px-4 py-3.5 font-medium text-[#1C2430]">
                                    {{ $cat->nama_kategori }}
                                </td>
                                <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs text-[#1C2430] font-medium">
                                        {{ $cat->produk_count }} produk
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <x-action-menu :label="'Menu aksi kategori ' . $cat->nama_kategori">
                                        <x-action-menu.item href="{{ route('admin.kategori.edit', $cat->id_kategori) }}">
                                            Ubah Kategori
                                        </x-action-menu.item>

                                        <x-action-menu.divider />

                                        <x-action-menu.item
                                            danger
                                            @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.kategori.destroy', $cat->id_kategori) }}'; deleteItemName = 'kategori {{ $cat->nama_kategori }}'"
                                        >
                                            Hapus
                                        </x-action-menu.item>
                                    </x-action-menu>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-xs text-[#667085]">
                                    Belum ada kategori terdaftar di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- TAB 2: MATERIAL KAIN                           -->
    <!-- ============================================== -->
    <div x-show="activeTab === 'material'" class="space-y-4" style="display: none;">
        
        <!-- Collapsible Add Material Panel -->
        <div x-show="addMaterialOpen" x-transition class="admin-card p-4 bg-white border-[#B8664A]/30">
            <h3 class="text-sm font-semibold text-[#1C2430] mb-2">Tambah Material Kain Baru</h3>
            <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex flex-col sm:flex-row gap-2.5 max-w-xl">
                @csrf
                <input type="hidden" name="type" value="bahan" />
                <input
                    type="text"
                    name="nama_bahan"
                    required
                    placeholder="Nama material, contoh: Cotton Combed 24s, Fleece Tebal"
                    class="flex-1 px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary px-4 py-2 text-xs sm:text-sm cursor-pointer">
                        Simpan
                    </button>
                    <button type="button" @click="addMaterialOpen = false" class="btn-secondary px-3 py-2 text-xs cursor-pointer">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Bar Toolbar -->
        <div class="admin-card p-3 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative w-full sm:max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="searchMaterial"
                    placeholder="Cari nama material kain..."
                    class="w-full pl-9 pr-3.5 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>
            <span class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
                Total: <strong class="text-[#1C2430]">{{ $materials->count() }}</strong> material
            </span>
        </div>

        <!-- Full-Width Material Table -->
        <div class="admin-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                            <th class="px-4 py-3 font-mono">ID Material</th>
                            <th class="px-4 py-3">Nama Material Kain</th>
                            <th class="px-4 py-3 text-right w-12 whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E5E9] bg-white">
                        @forelse ($materials as $mat)
                            <tr
                                class="admin-table-row"
                                x-show="!searchMaterial || '{{ strtolower(addslashes($mat->nama_bahan)) }}'.includes(searchMaterial.toLowerCase())"
                            >
                                <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                    #{{ $mat->id_bahan }}
                                </td>
                                <td class="px-4 py-3.5 font-medium text-[#1C2430]">
                                    {{ $mat->nama_bahan }}
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <x-action-menu :label="'Menu aksi material ' . $mat->nama_bahan">
                                        <x-action-menu.item
                                            danger
                                            @click="deleteModalOpen = true; deleteActionUrl = '{{ route('admin.kategori.destroy', ['kategori' => $mat->id_bahan, 'type' => 'bahan']) }}'; deleteItemName = 'material {{ $mat->nama_bahan }}'"
                                        >
                                            Hapus
                                        </x-action-menu.item>
                                    </x-action-menu>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-xs text-[#667085]">
                                    Belum ada material kain terdaftar di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
            <h3 class="text-base font-semibold text-[#1C2430]">Konfirmasi Hapus Data</h3>
            <p class="text-xs text-[#667085] mt-1.5 leading-relaxed">
                Apakah Anda yakin ingin menghapus data <strong class="text-[#1C2430]" x-text="deleteItemName"></strong>? Produk yang menggunakan data ini dapat terpengaruh.
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


