<div
    x-data
    x-init="
        const syncHashTab = () => {
            const params = new URLSearchParams(window.location.search);
            if (window.location.hash === '#material' || params.get('tab') === 'material') {
                if ($wire.activeTab !== 'material') {
                    $wire.switchTab('material');
                }
            } else if (window.location.hash === '#kategori' || (!params.get('tab') && !window.location.hash)) {
                if ($wire.activeTab !== 'kategori') {
                    $wire.switchTab('kategori');
                }
            }
        };
        syncHashTab();
        window.addEventListener('hashchange', syncHashTab);
    "
    class="space-y-5"
>

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">
                {{ $activeTab === 'kategori' ? 'Kategori Produk' : 'Material Kain' }}
            </h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                {{ $activeTab === 'kategori' ? 'Kelola klasifikasi produk busana seperti Jaket, Kemeja, Polo, dll.' : 'Kelola kurasi jenis bahan kain garmen untuk pesanan custom.' }}
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            @if ($activeTab === 'kategori')
                <button
                    type="button"
                    wire:click="$toggle('addKategoriOpen')"
                    class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Kategori</span>
                </button>
            @else
                <button
                    type="button"
                    wire:click="$toggle('addMaterialOpen')"
                    class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Material</span>
                </button>
            @endif
        </div>
    </div>

    <!-- FLASH FEEDBACK NOTIFICATION -->
    @if ($feedbackMessage)
        <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button wire:click="dismissFeedback" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold">&times;</button>
        </div>
    @endif

    <!-- TAB SEGMENTED NAVIGATION -->
    <div class="flex items-center border-b border-[#E2E5E9] gap-6 text-xs sm:text-sm">
        <a
            href="{{ route('admin.kategori.index') }}"
            wire:click.prevent="switchTab('kategori')"
            @click="window.location.hash = ''"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer text-decoration-none {{ $activeTab === 'kategori' ? 'border-[#102A43] text-[#102A43] font-semibold' : 'border-transparent text-[#667085] hover:text-[#1C2430]' }}"
        >
            <span>Kategori Produk</span>
            <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'kategori' ? 'bg-[#EBF1F7] text-[#102A43]' : 'bg-[#F7F7F5] text-[#667085]' }}">
                {{ $summary['total_categories'] }}
            </span>
        </a>

        <a
            href="{{ route('admin.kategori.index', ['tab' => 'material']) }}#material"
            wire:click.prevent="switchTab('material')"
            @click="window.location.hash = 'material'"
            class="pb-3 border-b-2 flex items-center gap-2 transition-colors cursor-pointer text-decoration-none {{ $activeTab === 'material' ? 'border-[#102A43] text-[#102A43] font-semibold' : 'border-transparent text-[#667085] hover:text-[#1C2430]' }}"
        >
            <span>Material Kain</span>
            <span class="px-2 py-0.5 rounded-full text-xs {{ $activeTab === 'material' ? 'bg-[#EBF1F7] text-[#102A43]' : 'bg-[#F7F7F5] text-[#667085]' }}">
                {{ $summary['total_materials'] }}
            </span>
        </a>
    </div>

    <!-- ============================================== -->
    <!-- TAB 1: KATEGORI PRODUK                         -->
    <!-- ============================================== -->
    @if ($activeTab === 'kategori')
        <div class="space-y-4">
            
            <!-- Collapsible Add Category Panel -->
            @if ($addKategoriOpen)
                <div class="admin-card p-4 bg-white border-[#102A43]/30">
                    <h3 class="text-sm font-semibold text-[#1C2430] mb-2">Tambah Kategori Baru</h3>
                    <form wire:submit="saveKategori" class="flex flex-col sm:flex-row gap-2.5 max-w-xl">
                        <div class="flex-1">
                            <input
                                type="text"
                                wire:model="nama_kategori"
                                required
                                placeholder="Nama kategori, contoh: Jaket Varsity, Kemeja PDH"
                                class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            @error('nama_kategori')
                                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="btn-primary px-4 py-2 text-xs sm:text-sm cursor-pointer">
                                Simpan
                            </button>
                            <button type="button" wire:click="$set('addKategoriOpen', false)" class="btn-secondary px-3 py-2 text-xs cursor-pointer">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Search Bar Toolbar -->
            <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 w-full sm:max-w-md">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="searchKategori"
                            placeholder="Cari nama kategori..."
                            class="w-full h-10 pl-9 pr-3.5 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#102A43] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                        />
                    </div>
                    @if (!empty($searchKategori))
                        <button
                            type="button"
                            wire:click="$set('searchKategori', '')"
                            class="h-10 px-3 inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#102A43] hover:bg-[#F7F7F5] border border-transparent hover:border-[#E2E5E9] rounded-lg transition-colors font-medium cursor-pointer shrink-0 whitespace-nowrap"
                        >
                            <svg class="w-3.5 h-3.5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Reset</span>
                        </button>
                    @endif
                </div>
                <div class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
                    Total: <strong class="text-[#1C2430]">{{ $categories->count() }}</strong> kategori
                </div>
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
                                <th class="px-4 py-3 text-right w-24 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E2E5E9] bg-white">
                            @forelse ($categories as $cat)
                                <tr class="admin-table-row">
                                    <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                        #{{ $cat->id_kategori }}
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-[#1C2430]">
                                        @if ($editingKategoriId === $cat->id_kategori)
                                            <div class="flex items-center gap-2 max-w-sm">
                                                <input
                                                    type="text"
                                                    wire:model="editingKategoriName"
                                                    wire:keydown.enter="updateKategori"
                                                    class="px-2 py-1 border border-[#102A43] rounded text-xs text-[#1C2430] w-full"
                                                />
                                                <button wire:click="updateKategori" class="text-xs bg-[#102A43] text-white px-2 py-1 rounded">Simpan</button>
                                                <button wire:click="cancelEditKategori" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Batal</button>
                                            </div>
                                            @error('editingKategoriName')
                                                <span class="text-xs text-rose-500 mt-0.5 block">{{ $message }}</span>
                                            @enderror
                                        @else
                                            {{ $cat->nama_kategori }}
                                        @endif
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
                                                wire:click="deleteKategori({{ $cat->id_kategori }})"
                                                wire:confirm="Yakin ingin menghapus kategori '{{ $cat->nama_kategori }}'?"
                                            >
                                                Hapus
                                            </x-action-menu.item>
                                        </x-action-menu>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-xs text-[#667085]">
                                        @if(!empty($searchKategori))
                                            Tidak ada kategori cocok dengan pencarian "{{ $searchKategori }}".
                                        @else
                                            Belum ada kategori terdaftar di sistem.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    @endif

    <!-- ============================================== -->
    <!-- TAB 2: MATERIAL KAIN                           -->
    <!-- ============================================== -->
    @if ($activeTab === 'material')
        <div class="space-y-4">
            
            <!-- Collapsible Add Material Panel -->
            @if ($addMaterialOpen)
                <div class="admin-card p-4 bg-white border-[#102A43]/30">
                    <h3 class="text-sm font-semibold text-[#1C2430] mb-2">Tambah Material Kain Baru</h3>
                    <form wire:submit="saveMaterial" class="flex flex-col sm:flex-row gap-2.5 max-w-xl">
                        <div class="flex-1">
                            <input
                                type="text"
                                wire:model="nama_bahan"
                                required
                                placeholder="Nama material kain, contoh: Cotton Combed 30s, Fleece Taiwan"
                                class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#102A43] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            @error('nama_bahan')
                                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="btn-primary px-4 py-2 text-xs sm:text-sm cursor-pointer">
                                Simpan
                            </button>
                            <button type="button" wire:click="$set('addMaterialOpen', false)" class="btn-secondary px-3 py-2 text-xs cursor-pointer">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Search Bar Toolbar -->
            <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 w-full sm:max-w-md">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="searchMaterial"
                            placeholder="Cari material kain..."
                            class="w-full h-10 pl-9 pr-3.5 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#102A43] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                        />
                    </div>
                    @if (!empty($searchMaterial))
                        <button
                            type="button"
                            wire:click="$set('searchMaterial', '')"
                            class="h-10 px-3 inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#102A43] hover:bg-[#F7F7F5] border border-transparent hover:border-[#E2E5E9] rounded-lg transition-colors font-medium cursor-pointer shrink-0 whitespace-nowrap"
                        >
                            <svg class="w-3.5 h-3.5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Reset</span>
                        </button>
                    @endif
                </div>
                <div class="text-xs text-[#667085] shrink-0 self-end sm:self-center">
                    Total: <strong class="text-[#1C2430]">{{ $materials->count() }}</strong> material kain
                </div>
            </div>

            <!-- Full-Width Materials Table -->
            <div class="admin-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse">
                        <thead>
                            <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                                <th class="px-4 py-3 font-mono">ID Material</th>
                                <th class="px-4 py-3">Nama Material Kain</th>
                                <th class="px-4 py-3 text-right w-24 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E2E5E9] bg-white">
                            @forelse ($materials as $mat)
                                <tr class="admin-table-row">
                                    <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                        #{{ $mat->id_bahan }}
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-[#1C2430]">
                                        @if ($editingBahanId === $mat->id_bahan)
                                            <div class="flex items-center gap-2 max-w-sm">
                                                <input
                                                    type="text"
                                                    wire:model="editingBahanName"
                                                    wire:keydown.enter="updateBahan"
                                                    class="px-2 py-1 border border-[#102A43] rounded text-xs text-[#1C2430] w-full"
                                                />
                                                <button wire:click="updateBahan" class="text-xs bg-[#102A43] text-white px-2 py-1 rounded">Simpan</button>
                                                <button wire:click="cancelEditBahan" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Batal</button>
                                            </div>
                                            @error('editingBahanName')
                                                <span class="text-xs text-rose-500 mt-0.5 block">{{ $message }}</span>
                                            @enderror
                                        @else
                                            {{ $mat->nama_bahan }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                        <x-action-menu :label="'Menu aksi material ' . $mat->nama_bahan">
                                            <x-action-menu.item href="{{ route('admin.kategori.edit', ['kategori' => $mat->id_bahan, 'type' => 'bahan']) }}">
                                                Ubah Material
                                            </x-action-menu.item>

                                            <x-action-menu.divider />

                                            <x-action-menu.item
                                                danger
                                                wire:click="deleteMaterial({{ $mat->id_bahan }})"
                                                wire:confirm="Yakin ingin menghapus material '{{ $mat->nama_bahan }}'?"
                                            >
                                                Hapus
                                            </x-action-menu.item>
                                        </x-action-menu>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-xs text-[#667085]">
                                        @if(!empty($searchMaterial))
                                            Tidak ada material cocok dengan pencarian "{{ $searchMaterial }}".
                                        @else
                                            Belum ada material kain terdaftar di sistem.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    @endif

</div>
