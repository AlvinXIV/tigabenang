@extends('layouts.admin')

@section('title', 'Material Inventory')

@section('content')
<div class="space-y-8" x-data="{ searchQuery: '', registerModalOpen: false }">

    <!-- ============================================== -->
    <!-- 1. TOP HEADER & SEARCH / ACTION TOOLBAR        -->
    <!-- ============================================== -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#EADACE]/70">
        <div>
            <h1 class="text-2xl sm:text-3xl font-normal text-[#1C1917] tracking-tight">Material Inventory</h1>
            <p class="text-xs sm:text-sm text-[#78716C] mt-1">
                Manage and review available materials.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-full sm:w-72">
                <input
                    type="text"
                    x-model="searchQuery"
                    placeholder="Search materials, SKU..."
                    class="w-full pl-9 pr-3.5 py-2 bg-white border border-[#D9CCC1] text-xs text-[#292524] placeholder-[#A89A8E] rounded-none focus:outline-none focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] transition-colors"
                />
                <svg class="w-4 h-4 text-[#A89A8E] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Register Material Button -->
            <button
                type="button"
                @click="registerModalOpen = true"
                class="px-4 py-2 bg-[#B85331] hover:bg-[#A34524] active:bg-[#8F3C1F] text-white text-xs font-mono font-medium tracking-wider uppercase transition-all shadow-xs flex items-center gap-1.5 cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>REGISTER MATERIAL</span>
            </button>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. PRIMARY SUMMARY CARDS (TOTAL & LOW STOCK)   -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: TOTAL MATERIALS -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    TOTAL MATERIALS
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight">{{ $summary['total_materials'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">Active materials</p>
            </div>
        </div>

        <!-- Card 2: LOW STOCK -->
        <div class="bg-white border border-[#EADACE] p-6 shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase">
                    LOW STOCK
                </span>
                <svg class="w-4 h-4 text-[#B85331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-normal text-[#1C1917] tracking-tight">{{ $summary['low_stock_count'] }}</h3>
                <p class="text-xs text-[#78716C] mt-1">Below reorder level</p>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- 3. MATERIAL CARDS GRID                         -->
    <!-- ============================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($materials as $mat)
            <div
                class="bg-white border border-[#EADACE] shadow-[0_2px_12px_rgba(0,0,0,0.015)] flex flex-col justify-between transition-all hover:border-[#D9CCC1] group"
                x-show="'{{ strtolower($mat['name']) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($mat['sku']) }}'.includes(searchQuery.toLowerCase())"
            >
                <!-- Material Top Image & Stock Badge -->
                <a href="{{ route('admin.kategori.edit', $mat['id']) }}" class="h-44 w-full bg-stone-100 relative overflow-hidden border-b border-[#EADACE]/70 block">
                    <img
                        src="{{ $mat['image'] }}"
                        alt="{{ $mat['name'] }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                    <div class="absolute top-3 right-3">
                        @if ($mat['is_low_stock'])
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white/95 text-[#B85331] border border-[#F7DDD2] shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B85331]"></span>
                                LOW STOCK
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-[10px] font-mono font-bold tracking-wider uppercase bg-white/95 text-stone-700 border border-[#EADACE] shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                IN STOCK
                            </span>
                        @endif
                    </div>
                </a>

                <!-- Material Card Body -->
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-baseline justify-between gap-2">
                            <a href="{{ route('admin.kategori.edit', $mat['id']) }}" class="text-base font-medium text-[#1C1917] group-hover:text-[#B85331] transition-colors">
                                {{ $mat['name'] }}
                            </a>
                            <span class="text-[10px] font-mono text-[#786C62] uppercase tracking-wider shrink-0">
                                SKU: {{ $mat['sku'] }}
                            </span>
                        </div>
                        <p class="text-xs text-[#78716C] mt-1">
                            {{ $mat['description'] }}
                        </p>

                        <!-- Product-Material Relationship ("Used in:") -->
                        <div class="mt-3 pt-3 border-t border-[#EADACE]/50">
                            <p class="text-[11px] text-[#78716C] leading-snug">
                                <span class="text-[#9E9084] font-normal">Used in:</span>
                                <span class="font-medium text-[#574E46]">{{ implode(' • ', $mat['used_in']) }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Stock Info & Manage Action Link -->
                    <div class="pt-3 border-t border-[#EADACE]/70 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-mono tracking-widest text-[#9E9084] uppercase block">
                                STOCK
                            </span>
                            <span class="text-sm font-normal text-[#1C1917] font-mono">
                                {{ $mat['stock'] }} {{ $mat['unit'] }}
                            </span>
                        </div>

                        <a
                            href="{{ route('admin.kategori.edit', $mat['id']) }}"
                            class="text-xs font-mono font-medium tracking-wider text-[#B85331] hover:underline uppercase transition-colors cursor-pointer"
                        >
                            MANAGE
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ============================================== -->
    <!-- 4. REGISTER MATERIAL MODAL                     -->
    <!-- ============================================== -->
    <div
        x-show="registerModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-xs"
        style="display: none;"
    >
        <div
            @click.away="registerModalOpen = false"
            class="bg-white border border-[#EADACE] shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6"
        >
            <div class="flex items-center justify-between pb-4 border-b border-[#EADACE]/70">
                <h2 class="text-lg font-normal text-[#1C1917]">Register New Material</h2>
                <button @click="registerModalOpen = false" class="text-[#786C62] hover:text-[#1C1917] text-lg font-mono">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        MATERIAL NAME
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        placeholder="e.g. French Terry"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="sku" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            SKU
                        </label>
                        <input
                            type="text"
                            name="sku"
                            id="sku"
                            placeholder="e.g. FT-007"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>
                    <div>
                        <label for="stock" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                            STOCK QUANTITY (m)
                        </label>
                        <input
                            type="number"
                            name="stock"
                            id="stock"
                            required
                            placeholder="e.g. 500"
                            class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm font-mono text-[#292524] rounded-none focus:outline-none transition-colors"
                        />
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-[11px] font-mono font-medium tracking-widest text-[#786C62] uppercase mb-1.5">
                        SPECIFICATIONS & DESCRIPTION
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="2"
                        placeholder="e.g. 100% Cotton, 320 g/m² loopback knit"
                        class="w-full px-3.5 py-2.5 bg-white border border-[#D9CCC1] focus:border-[#B85331] focus:ring-1 focus:ring-[#B85331] text-xs sm:text-sm text-[#292524] rounded-none focus:outline-none transition-colors"
                    ></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#EADACE]/70">
                    <button
                        type="button"
                        @click="registerModalOpen = false"
                        class="px-4 py-2 bg-white border border-[#D9CCC1] hover:bg-[#F2ECE3] text-[#292524] text-xs font-mono font-medium uppercase transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 bg-[#B85331] hover:bg-[#A34524] text-white text-xs font-mono font-medium uppercase transition-all shadow-xs"
                    >
                        Register Material
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
