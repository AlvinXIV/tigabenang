<div class="space-y-5" x-data="{ statusFilter: 'all' }">

    <!-- TOP HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[#E2E5E9]">
        <div>
            <h1 class="text-2xl sm:text-[26px] font-semibold text-[#1C2430] tracking-tight">Model Pakaian 3D</h1>
            <p class="text-xs sm:text-sm text-[#667085] mt-1">
                Aset visual interaktif 3D (.glb / .gltf) yang terhubung pada katalog produk.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('admin.model-3d.create') }}"
                class="btn-primary px-3.5 py-2 text-xs sm:text-sm gap-1.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Hubungkan Model 3D</span>
            </a>
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

    <!-- SEARCH & FILTER TOOLBAR -->
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
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama produk..."
                    class="w-full h-10 pl-9 pr-3.5 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <!-- Status 3D Filter -->
            <select
                x-model="statusFilter"
                class="h-10 px-3 bg-[#F7F7F5] border border-[#E2E5E9] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors cursor-pointer w-full sm:w-auto"
            >
                <option value="all">Semua Status 3D</option>
                <option value="connected">Terhubung ({{ $models->count() }})</option>
                <option value="missing">Belum tersedia ({{ $availableProducts->count() }})</option>
            </select>

            <!-- Reset Filter Button (Ghost Action) -->
            <template x-if="statusFilter !== 'all' || '{{ $search }}'">
                <button
                    type="button"
                    @click="statusFilter = 'all'"
                    wire:click="$set('search', '')"
                    class="h-10 px-3 inline-flex items-center gap-1.5 text-xs text-[#667085] hover:text-[#B8664A] hover:bg-[#F7F7F5] border border-transparent hover:border-[#E2E5E9] rounded-lg transition-colors font-medium cursor-pointer shrink-0 whitespace-nowrap"
                >
                    <svg class="w-3.5 h-3.5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Reset Filter</span>
                </button>
            </template>
        </div>

        <div class="text-xs text-[#667085] shrink-0 self-end md:self-center">
            Total: <strong class="text-[#1C2430]">{{ $models->count() }}</strong> terhubung &bull; {{ $availableProducts->count() }} belum terhubung
        </div>
    </div>

    <!-- 3D ASSETS COMPACT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- 1. Connected Models -->
        @foreach ($models as $prod)
            <div
                x-show="statusFilter === 'all' || statusFilter === 'connected'"
                class="admin-card p-4 space-y-3 flex flex-col justify-between hover:border-[#B8664A]/40 transition-colors"
            >
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-[11px] font-medium text-[#1C2430]">
                            {{ $prod->kategori ? $prod->kategori->nama_kategori : 'Katalog' }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Terhubung
                            </span>
                            <x-action-menu :label="'Menu aksi model 3D ' . $prod->nama_produk">
                                <x-action-menu.item href="{{ route('admin.model-3d.preview', $prod->id_produk) }}" target="_blank">
                                    Lihat Pratinjau 3D
                                </x-action-menu.item>
                                <x-action-menu.item href="{{ route('admin.model-3d.edit', $prod->id_produk) }}">
                                    Ganti Berkas 3D
                                </x-action-menu.item>
                                <x-action-menu.divider />
                                <x-action-menu.item
                                    danger
                                    wire:click="unlink3D({{ $prod->id_produk }})"
                                    wire:confirm="Yakin ingin melepas model 3D dari produk '{{ $prod->nama_produk }}'?"
                                >
                                    Lepas Model 3D
                                </x-action-menu.item>
                            </x-action-menu>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-[#1C2430] truncate">{{ $prod->nama_produk }}</h3>
                    <p class="text-xs font-mono text-[#667085] truncate bg-[#F7F7F5] px-2.5 py-1.5 rounded border border-[#E2E5E9]">
                        {{ basename($prod->file_model_3d) }}
                    </p>
                </div>

                <div class="pt-2.5 border-t border-[#E2E5E9] flex items-center justify-between">
                    <a
                        href="{{ route('admin.model-3d.preview', $prod->id_produk) }}"
                        target="_blank"
                        class="text-xs font-medium text-[#B8664A] hover:underline text-decoration-none"
                    >
                        Buka Pratinjau 3D &rarr;
                    </a>
                </div>
            </div>
        @endforeach

        <!-- 2. Unlinked Products (Belum tersedia) -->
        @foreach ($availableProducts as $prod)
            <div
                x-show="(statusFilter === 'all' || statusFilter === 'missing') && ('{{ addslashes(strtolower($prod->nama_produk)) }}'.includes('{{ addslashes(strtolower($search)) }}'))"
                class="admin-card p-4 space-y-3 flex flex-col justify-between hover:border-[#B8664A]/40 transition-colors bg-white/70"
            >
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-[11px] font-medium text-[#1C2430]">
                            {{ $prod->kategori ? $prod->kategori->nama_kategori : 'Katalog' }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                Belum tersedia
                            </span>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-[#1C2430] truncate">{{ $prod->nama_produk }}</h3>
                    <p class="text-xs text-[#98A2B3] italic bg-[#F7F7F5] px-2.5 py-1.5 rounded border border-[#E2E5E9] truncate">
                        Belum ada berkas 3D terhubung
                    </p>
                </div>

                <div class="pt-2.5 border-t border-[#E2E5E9] flex items-center justify-end">
                    <a
                        href="{{ route('admin.model-3d.create') }}"
                        class="text-xs font-medium text-[#B8664A] hover:underline text-decoration-none inline-flex items-center gap-1"
                    >
                        Hubungkan 3D &rarr;
                    </a>
                </div>
            </div>
        @endforeach

        @if ($models->isEmpty() && $availableProducts->isEmpty())
            <div class="col-span-full">
                <x-empty-state title="Belum Ada Produk" message="Belum ada produk yang terdaftar di katalog.">
                    <a href="{{ route('admin.produk.create') }}" class="btn-primary text-xs px-4 py-2 mt-3 inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Produk Baru</span>
                    </a>
                </x-empty-state>
            </div>
        @endif
    </div>

</div>
