@extends('layouts.admin')

@section('title', 'Product Catalog')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto" x-data="{ searchQuery: '' }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH / ACTION BAR            -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Product Catalog</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Manage products, pricing, materials, and 3D models.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a
                href="{{ route('admin.produk.create') }}"
                class="px-4 py-2.5 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-1.5"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>New Product</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. PRIMARY SUMMARY METRIC (TOTAL PRODUCTS)     -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
            <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase block">
                TOTAL PRODUCTS
            </span>
            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight font-mono mt-3">
                {{ $totalProducts }}
            </h3>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. PRODUCT CATALOG TABLE                       -->
    <!-- ============================================== -->
    <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/60 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">PRODUCT</th>
                        <th class="px-6 py-3.5">CATEGORY</th>
                        <th class="px-6 py-3.5">PRICE</th>
                        <th class="px-6 py-3.5 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @forelse ($products as $prod)
                        <tr class="hover:bg-[#FAF7F2]/50 transition-colors">
                            <!-- Product Column (Thumbnail + Name) -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.produk.edit', $prod->id_produk) }}" class="flex items-center gap-3.5 group">
                                    @if ($prod->gambar)
                                        <img
                                            src="{{ asset('storage/' . $prod->gambar) }}"
                                            alt="{{ $prod->nama_produk }}"
                                            class="w-10 h-10 object-cover border border-[#EADACE] shrink-0 group-hover:opacity-90 transition-opacity"
                                        />
                                    @else
                                        <div class="w-10 h-10 bg-[#EFE7DE] border border-[#EADACE] flex items-center justify-center text-xs font-bold text-[#B85331] shrink-0">
                                            TB
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-medium text-[#1C1917] text-xs sm:text-sm block group-hover:text-[#B85331] transition-colors leading-tight">
                                            {{ $prod->nama_produk }}
                                        </span>
                                        @if ($prod->file_model_3d)
                                            <span class="text-[10px] font-mono text-[#B85331] tracking-wider uppercase block mt-0.5 font-semibold">
                                                ✓ 3D Model Attached
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </td>

                            <!-- Category Column -->
                            <td class="px-6 py-4 text-xs text-[#574E46] whitespace-nowrap">
                                {{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}
                            </td>

                            <!-- Price Column -->
                            <td class="px-6 py-4 font-mono font-medium text-xs sm:text-sm text-[#1C1917] whitespace-nowrap">
                                Rp {{ number_format($prod->harga, 0, ',', '.') }}
                            </td>

                            <!-- Actions Column (Three-Dot Menu) -->
                            <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                <div class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="menuOpen = !menuOpen"
                                        class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] border border-transparent hover:border-[#EADACE] transition-colors focus:outline-none cursor-pointer"
                                        title="Actions"
                                    >
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="19" r="2"></circle>
                                        </svg>
                                    </button>

                                    <div
                                        x-show="menuOpen"
                                        @click.away="menuOpen = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-1 w-40 bg-white border border-[#EADACE] shadow-lg py-1 z-30 text-left divide-y divide-[#EADACE]/50"
                                        style="display: none;"
                                    >
                                        <div class="py-0.5">
                                            <a
                                                href="{{ route('admin.produk.edit', $prod->id_produk) }}"
                                                class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                            >
                                                <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Edit Produk</span>
                                            </a>

                                            @if ($prod->file_model_3d)
                                                <a
                                                    href="{{ route('admin.model-3d.preview', $prod->id_produk) }}"
                                                    class="flex items-center gap-2 px-3.5 py-2 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors font-medium"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-[#78716C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    <span>Preview 3D</span>
                                                </a>
                                            @endif
                                        </div>

                                        <div class="py-0.5">
                                            <form action="{{ route('admin.produk.destroy', $prod->id_produk) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $prod->nama_produk }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="w-full flex items-center gap-2 px-3.5 py-2 text-xs text-rose-700 hover:bg-rose-50 transition-colors font-medium cursor-pointer"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Hapus Produk</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-[#78716C]">
                                Belum ada produk di dalam database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
