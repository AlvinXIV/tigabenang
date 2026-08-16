@extends('layouts.admin')

@section('title', 'Product Catalog')

@section('content')
<div class="space-y-8" x-data="{ searchQuery: '', selectedCategory: 'all' }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH / FILTER / ACTION BAR   -->
    <!-- ============================================== -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Product Catalog</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Manage products, pricing, materials, and 3D models.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-full sm:w-64">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search products..."
                    class="w-full pl-9 pr-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] transition-colors"
                />
                <svg class="w-4 h-4 text-[#A89A8E] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Filter Dropdown / Button -->
            <div class="relative" x-data="{ filterOpen: false }">
                <button
                    type="button"
                    @click="filterOpen = !filterOpen"
                    class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium tracking-wider uppercase transition-colors flex items-center gap-2 cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5 text-[#786C62]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <span>Filter</span>
                </button>

                <!-- Filter Dropdown Menu -->
                <div
                    x-show="filterOpen"
                    @click.away="filterOpen = false"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white border border-[#EADACE] shadow-lg py-2 z-20"
                    style="display: none;"
                >
                    <button
                        @click="selectedCategory = 'all'; filterOpen = false"
                        class="w-full text-left px-4 py-1.5 text-xs text-[#292524] hover:bg-[#FAF7F2] flex items-center justify-between"
                    >
                        <span>All Categories</span>
                        <span x-show="selectedCategory === 'all'" class="text-[#B85331]">✓</span>
                    </button>
                    <button
                        @click="selectedCategory = 'Hoodie'; filterOpen = false"
                        class="w-full text-left px-4 py-1.5 text-xs text-[#292524] hover:bg-[#FAF7F2] flex items-center justify-between"
                    >
                        <span>Hoodie</span>
                        <span x-show="selectedCategory === 'Hoodie'" class="text-[#B85331]">✓</span>
                    </button>
                    <button
                        @click="selectedCategory = 'Jersey'; filterOpen = false"
                        class="w-full text-left px-4 py-1.5 text-xs text-[#292524] hover:bg-[#FAF7F2] flex items-center justify-between"
                    >
                        <span>Jersey</span>
                        <span x-show="selectedCategory === 'Jersey'" class="text-[#B85331]">✓</span>
                    </button>
                    <button
                        @click="selectedCategory = 'T-Shirt'; filterOpen = false"
                        class="w-full text-left px-4 py-1.5 text-xs text-[#292524] hover:bg-[#FAF7F2] flex items-center justify-between"
                    >
                        <span>T-Shirt</span>
                        <span x-show="selectedCategory === 'T-Shirt'" class="text-[#B85331]">✓</span>
                    </button>
                    <button
                        @click="selectedCategory = 'Jacket'; filterOpen = false"
                        class="w-full text-left px-4 py-1.5 text-xs text-[#292524] hover:bg-[#FAF7F2] flex items-center justify-between"
                    >
                        <span>Jacket</span>
                        <span x-show="selectedCategory === 'Jacket'" class="text-[#B85331]">✓</span>
                    </button>
                </div>
            </div>

            <!-- New Product Button -->
            <a
                href="{{ route('admin.produk.create') }}"
                class="px-4 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-1.5"
            >
                <span>+ NEW PRODUCT</span>
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
            <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight mt-3">
                {{ $totalProducts }}
            </h3>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. SIMPLIFIED PRODUCT CATALOG TABLE            -->
    <!-- ============================================== -->
    <div class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-[#EADACE]/70 bg-[#FAF7F2]/50 text-[10px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                        <th class="px-6 py-3.5">PRODUCT</th>
                        <th class="px-6 py-3.5">CATEGORY</th>
                        <th class="px-6 py-3.5">PRICE</th>
                        <th class="px-6 py-3.5 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADACE]/60">
                    @foreach ($products as $prod)
                        <tr
                            class="hover:bg-[#FAF7F2]/60 transition-colors"
                            x-show="(selectedCategory === 'all' || selectedCategory === '{{ $prod['category'] }}') && ('{{ strtolower($prod['name']) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($prod['sku']) }}'.includes(searchQuery.toLowerCase()))"
                        >
                            <!-- Product Column (Thumbnail + Name + SKU) -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.produk.edit', $prod['id']) }}" class="flex items-center gap-3.5 group">
                                    <img
                                        src="{{ $prod['thumbnail'] }}"
                                        alt="{{ $prod['name'] }}"
                                        class="w-10 h-10 object-cover rounded-none border border-[#EADACE] shrink-0 group-hover:opacity-90 transition-opacity"
                                    />
                                    <div>
                                        <span class="font-medium text-[#1C1917] text-xs sm:text-sm block group-hover:text-[#B85331] transition-colors leading-tight">
                                            {{ $prod['name'] }}
                                        </span>
                                        <span class="text-[10px] font-mono text-[#786C62] tracking-wider uppercase block mt-0.5">
                                            {{ $prod['sku'] }}
                                        </span>
                                    </div>
                                </a>
                            </td>

                            <!-- Category Column -->
                            <td class="px-6 py-4 text-xs text-[#574E46] whitespace-nowrap">
                                {{ $prod['category'] }}
                            </td>

                            <!-- Price Column -->
                            <td class="px-6 py-4 font-mono font-medium text-xs sm:text-sm text-[#1C1917] whitespace-nowrap">
                                {{ $prod['price'] }}
                            </td>

                            <!-- Actions Column -->
                            <td class="px-6 py-4 text-right whitespace-nowrap" x-data="{ menuOpen: false }">
                                <div class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="menuOpen = !menuOpen"
                                        class="p-1.5 text-[#786C62] hover:text-[#1C1917] hover:bg-[#FAF7F2] transition-colors focus:outline-none cursor-pointer"
                                    >
                                        <!-- Vertical 3-dots -->
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div
                                        x-show="menuOpen"
                                        @click.away="menuOpen = false"
                                        x-transition
                                        class="absolute right-0 mt-1 w-36 bg-white border border-[#EADACE] shadow-md py-1 z-20 text-left"
                                        style="display: none;"
                                    >
                                        <a
                                            href="{{ route('admin.produk.edit', $prod['id']) }}"
                                            class="block px-3 py-1.5 text-xs text-[#292524] hover:bg-[#FAF7F2] hover:text-[#B85331] transition-colors"
                                        >
                                            Edit Product
                                        </a>
                                        <form action="{{ route('admin.produk.destroy', $prod['id']) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="w-full text-left px-3 py-1.5 text-xs text-rose-600 hover:bg-rose-50 transition-colors"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ============================================== -->
        <!-- 4. PAGINATION FOOTER                           -->
        <!-- ============================================== -->
        <div class="px-6 py-4 border-t border-[#EADACE]/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#78716C]">
            <p>
                Showing 1 to {{ count($products) }} of {{ $totalProducts }} entries
            </p>

            <div class="flex items-center gap-1 font-mono text-xs">
                <button type="button" class="w-7 h-7 flex items-center justify-center border border-[#EADACE] bg-white text-[#78716C] hover:bg-[#FAF7F2] transition-colors">
                    &lt;
                </button>
                <button type="button" class="w-7 h-7 flex items-center justify-center border border-[#B85331] bg-[#EFE7DE] text-[#B85331] font-bold">
                    1
                </button>
                <button type="button" class="w-7 h-7 flex items-center justify-center border border-[#EADACE] bg-white text-[#78716C] hover:bg-[#FAF7F2] transition-colors">
                    2
                </button>
                <button type="button" class="w-7 h-7 flex items-center justify-center border border-[#EADACE] bg-white text-[#78716C] hover:bg-[#FAF7F2] transition-colors">
                    3
                </button>
                <span class="px-1 text-[#9E9084]">...</span>
                <button type="button" class="w-7 h-7 flex items-center justify-center border border-[#EADACE] bg-white text-[#78716C] hover:bg-[#FAF7F2] transition-colors">
                    &gt;
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
