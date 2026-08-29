@extends('layouts.admin')

@section('title', 'Product Catalog')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & ACTION BUTTON                  -->
    <!-- ============================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#DCD6D0]">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-[#172A39] text-[#FAF8F5] rounded-full text-[11px] font-black uppercase tracking-widest mb-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Catalog Inventory
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172A39] tracking-tight">Product Catalog</h1>
            <p class="text-xs sm:text-sm text-[#555E68] mt-1 font-medium">
                Kelola koleksi pakaian, spesifikasi harga, material kain, dan aset 3D fitting.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a
                href="{{ route('admin.produk.create') }}"
                class="btn-navy-pill px-6 py-3 text-xs tracking-wider uppercase gap-2 cursor-pointer shadow-md"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>+ New Product</span>
            </a>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. PRIMARY SUMMARY METRICS                     -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="admin-card-rich p-6 flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-black tracking-widest text-[#6E7575] uppercase block">
                    TOTAL PRODUCTS
                </span>
                <h3 class="text-3xl font-black text-[#172A39] tracking-tight mt-2">
                    {{ $totalProducts }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#172A39] text-white flex items-center justify-center shadow-md shadow-[#172A39]/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. PRODUCT CATALOG TABLE                       -->
    <!-- ============================================== -->
    <div class="admin-card-rich overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr style="background:#172A39;color:#FAF8F5;border-bottom:1.5px solid #172A39;" class="text-[11px] font-black tracking-wider uppercase">
                        <th class="px-6 py-4">PRODUCT</th>
                        <th class="px-6 py-4">CATEGORY</th>
                        <th class="px-6 py-4">PRICE</th>
                        <th class="px-6 py-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DCD6D0] bg-white">
                    @forelse ($products as $prod)
                        <tr class="admin-table-row">
                            <!-- Product Column (Thumbnail + Name) -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.produk.edit', $prod->id_produk) }}" class="flex items-center gap-3.5 group text-decoration-none">
                                    @if ($prod->gambar)
                                        <img
                                            src="{{ asset('storage/' . $prod->gambar) }}"
                                            alt="{{ $prod->nama_produk }}"
                                            class="w-12 h-12 object-cover rounded-xl border border-[#DCD6D0] shrink-0 group-hover:scale-105 transition-all shadow-xs"
                                        />
                                    @else
                                        <div class="w-12 h-12 bg-[#FAF8F5] border-1.5 border-[#DCD6D0] rounded-xl flex items-center justify-center text-xs font-black text-[#172A39] shrink-0 shadow-xs group-hover:bg-[#EAE2D8] transition-colors">
                                            CLQ
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-extrabold text-[#172A39] text-sm block group-hover:text-[#1E3345] group-hover:underline transition-colors leading-tight">
                                            {{ $prod->nama_produk }}
                                        </span>
                                        @if ($prod->file_model_3d)
                                            <span class="inline-flex items-center gap-1 text-[10px] text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full tracking-wider uppercase mt-1 font-black">
                                                ✓ 3D Model Attached
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </td>

                            <!-- Category Column -->
                            <td class="px-6 py-4 text-xs font-bold text-[#555E68] whitespace-nowrap">
                                <span class="px-3 py-1 bg-[#FAF8F5] border border-[#DCD6D0] rounded-full text-[#172A39]">
                                    {{ $prod->kategori ? $prod->kategori->nama_kategori : '-' }}
                                </span>
                            </td>

                            <!-- Price Column -->
                            <td class="px-6 py-4 font-black text-sm text-[#172A39] whitespace-nowrap">
                                Rp {{ number_format($prod->harga, 0, ',', '.') }}
                            </td>

                            <!-- Actions Column -->
                            <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                <div class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="menuOpen = !menuOpen"
                                        class="p-2 text-[#172A39] hover:bg-[#FAF8F5] rounded-xl border border-[#DCD6D0] hover:border-[#172A39] transition-all focus:outline-none cursor-pointer shadow-2xs"
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
                                        class="absolute right-0 mt-2 w-48 bg-white border-1.5 border-[#DCD6D0] rounded-2xl shadow-2xl py-2 z-30 text-left"
                                        style="display: none;"
                                    >
                                        <a
                                            href="{{ route('admin.produk.edit', $prod->id_produk) }}"
                                            class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-[#172A39] hover:bg-[#FAF8F5] transition-colors font-bold text-decoration-none"
                                        >
                                            <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span>Edit Produk</span>
                                        </a>

                                        @if ($prod->file_model_3d)
                                            <a
                                                href="{{ route('admin.model-3d.preview', $prod->id_produk) }}"
                                                class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-[#172A39] hover:bg-[#FAF8F5] transition-colors font-bold text-decoration-none"
                                            >
                                                <svg class="w-4 h-4 text-[#172A39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span>Preview 3D</span>
                                            </a>
                                        @endif

                                        <div class="border-t border-[#DCD6D0] my-1.5"></div>

                                        <form action="{{ route('admin.produk.destroy', $prod->id_produk) }}" method="POST" onsubmit="return confirm('Hapus produk {{ $prod->nama_produk }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-700 hover:bg-rose-50 transition-colors font-bold cursor-pointer border-0 bg-transparent"
                                            >
                                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Hapus Produk</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-[#6E7575] font-medium">
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
