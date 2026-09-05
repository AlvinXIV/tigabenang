<div
    class="space-y-5"
    x-data="{
        searchQuery: '',
        selectedCategory: '',
        items: [
            @foreach ($sizes as $itemSize)
            { id: {{ $itemSize->id_ukuran }}, catId: '{{ $itemSize->kategori_id }}', nama: '{{ addslashes(strtolower($itemSize->nama_ukuran)) }}', kategori: '{{ addslashes(strtolower($itemSize->kategori ? $itemSize->kategori->nama_kategori : '')) }}' },
            @endforeach
        ],
        matches(catId, nama, kategori) {
            const q = this.searchQuery.trim().toLowerCase();
            const cat = this.selectedCategory;
            const matchCat = !cat || String(catId) === String(cat);
            if (!matchCat) return false;
            if (!q) return true;
            return nama.includes(q) || kategori.includes(q);
        },
        get visibleCount() {
            const q = this.searchQuery.trim().toLowerCase();
            const cat = this.selectedCategory;
            return this.items.filter(item => {
                const matchCat = !cat || item.catId === String(cat);
                if (!matchCat) return false;
                if (!q) return true;
                return item.nama.includes(q) || item.kategori.includes(q);
            }).length;
        },
        get hasFilter() {
            return this.searchQuery.trim() !== '' || this.selectedCategory !== '';
        },
        resetFilter() {
            this.searchQuery = '';
            this.selectedCategory = '';
        }
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
                wire:click="$toggle('addFormOpen')"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Ukuran</span>
            </button>
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

    <!-- COLLAPSIBLE ADD SIZE FORM -->
    @if ($addFormOpen)
        <div class="admin-card p-5 bg-white border-[#B8664A]/30 space-y-4">
            <div class="border-b border-[#E2E5E9] pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-sm sm:text-base font-semibold text-[#1C2430]">Tambah Spesifikasi Ukuran Baru</h2>
                    <p class="text-xs text-[#667085] mt-0.5">Dimensi ukuran menggunakan satuan centimeter (cm).</p>
                </div>
                <button type="button" wire:click="$set('addFormOpen', false)" class="text-[#667085] hover:text-[#1C2430] text-xs cursor-pointer">
                    Tutup
                </button>
            </div>

            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3.5">
                    <!-- Kategori Produk -->
                    <div class="lg:col-span-2">
                        <label for="kategori_id" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                            Kategori Produk <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="kategori_id"
                            wire:model="kategori_id"
                            required
                            class="w-full px-3 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                        >
                            <option value="">Pilih Kategori...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id_kategori }}">
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
                            wire:model="nama_ukuran"
                            id="nama_ukuran"
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
                            Lebar Dada <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                step="0.1"
                                wire:model="lebar_dada"
                                id="lebar_dada"
                                required
                                placeholder="50"
                                class="w-full pl-3 pr-8 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-[#98A2B3] pointer-events-none">cm</span>
                        </div>
                        @error('lebar_dada')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Panjang -->
                    <div class="lg:col-span-1">
                        <label for="panjang" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                            Panjang <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                step="0.1"
                                wire:model="panjang"
                                id="panjang"
                                required
                                placeholder="70"
                                class="w-full pl-3 pr-8 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-[#98A2B3] pointer-events-none">cm</span>
                        </div>
                        @error('panjang')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lebar Bahu -->
                    <div class="lg:col-span-1">
                        <label for="lebar_bahu" class="block text-xs font-semibold text-[#1C2430] mb-1.5">
                            Lebar Bahu
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                step="0.1"
                                wire:model="lebar_bahu"
                                id="lebar_bahu"
                                placeholder="44"
                                class="w-full pl-3 pr-8 py-2 bg-white border border-[#D0D5DD] focus:border-[#B8664A] text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                            />
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-[#98A2B3] pointer-events-none">cm</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-[#E2E5E9]">
                    <button type="button" wire:click="$set('addFormOpen', false)" class="btn-secondary px-4 py-2 text-xs sm:text-sm cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary px-5 py-2 text-xs sm:text-sm cursor-pointer">
                        Simpan Spesifikasi
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- TOOLBAR & FILTERS -->
    <div class="admin-card p-3.5 bg-white flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2.5 flex-1">
            <!-- Search -->
            <div class="relative flex-1 min-w-[200px] sm:max-w-md w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Cari ukuran atau kategori..."
                    class="w-full h-10 pl-9 pr-3.5 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <!-- Category Filter -->
            <select
                x-model="selectedCategory"
                class="h-10 px-3 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors cursor-pointer w-full sm:w-auto"
            >
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                @endforeach
            </select>

            <!-- Reset Filter Button (Ghost Action) -->
            <button
                type="button"
                x-show="hasFilter"
                @click="resetFilter()"
                class="h-10 px-3 inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#B8664A] hover:bg-[#F7F7F5] border border-transparent hover:border-[#E2E5E9] rounded-lg transition-colors font-medium cursor-pointer shrink-0 whitespace-nowrap"
                style="display: none;"
            >
                <svg class="w-3.5 h-3.5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Reset Filter</span>
            </button>
        </div>

        <div class="text-xs text-[#667085] shrink-0 self-end md:self-center">
            Total: <strong class="text-[#1C2430]" x-text="visibleCount">{{ $sizes->count() }}</strong> spesifikasi
        </div>
    </div>

    <!-- SIZES MATRIX TABLE -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#F7F7F5] border-b border-[#E2E5E9] text-[11px] font-semibold text-[#667085] uppercase tracking-wider">
                        <th class="px-4 py-3 font-mono">ID</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Ukuran</th>
                        <th class="px-4 py-3 font-mono">Lebar Dada</th>
                        <th class="px-4 py-3 font-mono">Panjang</th>
                        <th class="px-4 py-3 font-mono">Lebar Bahu</th>
                        <th class="px-4 py-3 font-mono">Panjang Lengan</th>
                        <th class="px-4 py-3 text-right w-24 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E2E5E9] bg-white">
                    @forelse ($sizes as $s)
                        @if ($editingId === $s->id_ukuran)
                            <!-- Inline Edit Row -->
                            <tr class="bg-[#FFFDF9]">
                                <td class="px-4 py-3 font-mono text-xs text-[#667085]">#{{ $s->id_ukuran }}</td>
                                <td class="px-4 py-3">
                                    <select wire:model="edit_kategori_id" class="px-2 py-1 border border-[#B8664A] rounded text-xs">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text" wire:model="edit_nama_ukuran" class="w-16 px-2 py-1 border border-[#B8664A] rounded text-xs" />
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" step="0.1" wire:model="edit_lebar_dada" class="w-16 px-2 py-1 border border-[#B8664A] rounded text-xs font-mono" />
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" step="0.1" wire:model="edit_panjang" class="w-16 px-2 py-1 border border-[#B8664A] rounded text-xs font-mono" />
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" step="0.1" wire:model="edit_lebar_bahu" class="w-16 px-2 py-1 border border-[#B8664A] rounded text-xs font-mono" />
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" step="0.1" wire:model="edit_panjang_lengan" class="w-16 px-2 py-1 border border-[#B8664A] rounded text-xs font-mono" />
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button wire:click="update" class="px-2.5 py-1 bg-[#B8664A] text-white rounded text-xs font-medium cursor-pointer">Simpan</button>
                                        <button wire:click="cancelEdit" class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs cursor-pointer">Batal</button>
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr
                                class="admin-table-row"
                                x-show="matches('{{ $s->kategori_id }}', '{{ addslashes(strtolower($s->nama_ukuran)) }}', '{{ addslashes(strtolower($s->kategori ? $s->kategori->nama_kategori : '')) }}')"
                            >
                                <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                    #{{ $s->id_ukuran }}
                                </td>
                                <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap">
                                    {{ $s->kategori ? $s->kategori->nama_kategori : '-' }}
                                </td>
                                <td class="px-4 py-3.5 font-semibold text-[#1C2430] whitespace-nowrap">
                                    <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs font-bold text-[#1C2430]">
                                        {{ $s->nama_ukuran }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                    {{ $s->lebar_dada ? $s->lebar_dada . ' cm' : '-' }}
                                </td>
                                <td class="px-4 py-3.5 font-mono text-xs text-[#1C2430] whitespace-nowrap">
                                    {{ $s->panjang ? $s->panjang . ' cm' : '-' }}
                                </td>
                                <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                    {{ $s->lebar_bahu ? $s->lebar_bahu . ' cm' : '-' }}
                                </td>
                                <td class="px-4 py-3.5 font-mono text-xs text-[#667085] whitespace-nowrap">
                                    {{ $s->panjang_lengan ? $s->panjang_lengan . ' cm' : '-' }}
                                </td>
                                <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                    <x-action-menu :label="'Menu aksi ukuran ' . $s->nama_ukuran">
                                        <x-action-menu.item wire:click="startEdit({{ $s->id_ukuran }})">
                                            Ubah Cepat (Inline)
                                        </x-action-menu.item>

                                        <x-action-menu.item href="{{ route('admin.ukuran.edit', $s->id_ukuran) }}">
                                            Halaman Ubah Penuh
                                        </x-action-menu.item>

                                        <x-action-menu.divider />

                                        <x-action-menu.item
                                            danger
                                            wire:click="delete({{ $s->id_ukuran }})"
                                            wire:confirm="Yakin ingin menghapus ukuran '{{ $s->nama_ukuran }}'?"
                                        >
                                            Hapus
                                        </x-action-menu.item>
                                    </x-action-menu>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-xs text-[#667085]">
                                Belum ada spesifikasi ukuran tersimpan.
                            </td>
                        </tr>
                    @endforelse

                    <!-- Empty state row when search/filter returns 0 items -->
                    <tr x-show="visibleCount === 0" style="display: none;">
                        <td colspan="8" class="px-4 py-8 text-center text-xs text-[#667085]">
                            Tidak ada spesifikasi ukuran yang cocok dengan filter pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
