<div class="space-y-5">

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
                <span>Tambah Produk</span>
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

    <!-- FILTER & SEARCH BAR -->
    <div class="admin-card p-3.5 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="w-full flex flex-col sm:flex-row items-center gap-2.5">
            <!-- Search Input -->
            <div class="relative w-full sm:max-w-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#98A2B3]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama produk..."
                    class="w-full pl-9 pr-3.5 py-2 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                />
            </div>

            <!-- Category Filter -->
            <div class="w-full sm:w-56">
                <select
                    wire:model.live="categoryFilter"
                    class="w-full px-3 py-2 bg-[#F7F7F5] border border-[#D0D5DD] focus:border-[#B8664A] focus:bg-white text-xs sm:text-sm text-[#1C2430] rounded-lg focus:outline-none transition-colors"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id_kategori }}">
                            {{ $cat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($search || $categoryFilter)
                <button
                    type="button"
                    wire:click="$set('search', ''); $set('categoryFilter', '')"
                    class="text-xs text-[#667085] hover:text-[#B8664A] px-2 py-1 shrink-0 cursor-pointer"
                >
                    Reset Filter
                </button>
            @endif
        </div>

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
                    @forelse ($products as $product)
                        <tr class="admin-table-row">
                            <!-- Produk Thumbnail & Info -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded border border-[#E2E5E9] bg-[#F7F7F5] shrink-0 overflow-hidden flex items-center justify-center">
                                        @if ($product->gambar)
                                            <img
                                                src="{{ asset('storage/' . $product->gambar) }}"
                                                alt="{{ $product->nama_produk }}"
                                                class="w-full h-full object-cover"
                                            />
                                        @else
                                            <svg class="w-5 h-5 text-[#98A2B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.produk.edit', $product->id_produk) }}" class="font-medium text-[#1C2430] hover:text-[#B8664A] text-decoration-none block truncate">
                                            {{ $product->nama_produk }}
                                        </a>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-[11px] text-[#667085]">
                                                {{ $product->bahan->count() }} material didukung
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="px-4 py-3.5 text-[#667085] whitespace-nowrap">
                                <span class="px-2.5 py-0.5 bg-[#F7F7F5] border border-[#E2E5E9] rounded text-xs text-[#1C2430] font-medium">
                                    {{ $product->kategori ? $product->kategori->nama_kategori : 'Tanpa Kategori' }}
                                </span>
                            </td>

                            <!-- Harga Dasar -->
                            <td class="px-4 py-3.5 whitespace-nowrap font-mono text-xs text-[#1C2430]">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </td>

                            <!-- Model 3D Status -->
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                @if ($product->file_model_3d)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tersedia (.glb)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                        Belum Ada
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi Menu -->
                            <td class="px-4 py-3.5 text-right whitespace-nowrap">
                                <x-action-menu :label="'Menu aksi ' . $product->nama_produk">
                                    <x-action-menu.item href="{{ route('admin.produk.edit', $product->id_produk) }}">
                                        Ubah Produk
                                    </x-action-menu.item>

                                    @if ($product->file_model_3d)
                                        <x-action-menu.item href="{{ route('admin.model-3d.preview', $product->id_produk) }}" target="_blank">
                                            Pratinjau 3D
                                        </x-action-menu.item>
                                    @endif

                                    <x-action-menu.divider />

                                    <x-action-menu.item
                                        danger
                                        wire:click="delete({{ $product->id_produk }})"
                                        wire:confirm="Yakin ingin menghapus produk '{{ $product->nama_produk }}' beserta semua keterkaitannya?"
                                    >
                                        Hapus
                                    </x-action-menu.item>
                                </x-action-menu>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-[#667085] text-xs sm:text-sm">
                                @if ($search || $categoryFilter)
                                    <p class="font-medium text-[#1C2430]">Tidak ada produk yang sesuai dengan filter.</p>
                                    <p class="mt-1">Coba sesuaikan kata kunci atau filter kategori Anda.</p>
                                @else
                                    <p class="font-medium text-[#1C2430]">Belum ada produk di katalog.</p>
                                    <p class="mt-1">Klik tombol "Tambah Produk" untuk mulai mendaftarkan produk.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
