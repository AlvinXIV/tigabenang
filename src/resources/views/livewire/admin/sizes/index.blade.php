<div class="space-y-5">

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
    <div class="admin-card p-3 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 w-full sm:w-auto flex-1">
            <!-- Search -->
            <div class="relative w-full sm:max-w-xs">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari label ukuran..."
                    class="w-full pl-9 pr-3.5 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <!-- Category Filter -->
            <select
                wire:model.live="categoryFilter"
                class="w-full sm:w-48 px-3 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
            >
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <span class="text-xs text-[#667085] shrink-0">
            Total: <strong class="text-[#1C2430]">{{ $sizes->count() }}</strong> spesifikasi
        </span>
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
                                        <button wire:click="update" class="px-2.5 py-1 bg-[#B8664A] text-white rounded text-xs font-medium">Simpan</button>
                                        <button wire:click="cancelEdit" class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">Batal</button>
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr class="admin-table-row">
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
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="startEdit({{ $s->id_ukuran }})"
                                            class="text-xs text-[#667085] hover:text-[#B8664A] font-medium"
                                        >
                                            Ubah
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="delete({{ $s->id_ukuran }})"
                                            wire:confirm="Yakin ingin menghapus ukuran '{{ $s->nama_ukuran }}'?"
                                            class="text-xs text-rose-500 hover:text-rose-700 font-medium"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-xs text-[#667085]">
                                @if(!empty($search) || !empty($categoryFilter))
                                    Tidak ada spesifikasi ukuran yang cocok dengan filter pencarian.
                                @else
                                    Belum ada spesifikasi ukuran tersimpan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
