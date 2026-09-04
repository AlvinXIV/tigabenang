<div class="space-y-5">

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

    <!-- SEARCH TOOLBAR -->
    <div class="admin-card p-3 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="relative w-full sm:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari produk dengan model 3D..."
                class="w-full pl-9 pr-3.5 py-1.5 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
            />
        </div>

        <span class="text-xs text-[#667085] shrink-0">
            Total: <strong class="text-[#1C2430]">{{ $models->count() }}</strong> berkas 3D
        </span>
    </div>

    <!-- 3D ASSETS COMPACT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($models as $prod)
            <div class="admin-card p-4 space-y-3 flex flex-col justify-between hover:border-[#B8664A]/40 transition-colors">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-[11px] font-medium text-[#1C2430]">
                            {{ $prod->kategori ? $prod->kategori->nama_kategori : 'Katalog' }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                3D Aktif
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
        @empty
            <div class="col-span-full">
                <x-empty-state title="Belum Ada Model 3D" message="Belum ada produk yang terhubung dengan file model 3D (.glb / .gltf).">
                    <a href="{{ route('admin.model-3d.create') }}" class="btn-primary text-xs px-4 py-2 mt-3 inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Hubungkan Model 3D Pertama</span>
                    </a>
                </x-empty-state>
            </div>
        @endforelse
    </div>

</div>
